class TFTCompareCheat {
    constructor() {
        this.spamThreshold = 55; // 55% similarity threshold
        this.fraudScores = {
            traits: 0,
            units: 0,
            items: 0,
            stats: 0,
            overall: 0
        };
        this.detailedWarnings = [];
    }

    // Main comparison function
    async compareMatches(matchId1, matchId2, discordId, type = 'round') {
        try {
            const apiUrl = type === 'round'
                ? `/api/discord/roundcompare/${matchId1}/${matchId2}/${discordId}`
                : `/api/discord/matchcompare/${matchId1}/${matchId2}/${discordId}`;

            const response = await fetch(apiUrl);
            const data = await response.json();

            if (data.data && data.data.length >= 2) {
                return this.analyzeSpamFraud(data.data[0], data.data[1]);
            }

            throw new Error('Insufficient data for comparison');
        } catch (error) {
            console.error('Comparison error:', error);
            throw error;
        }
    }

    // Core fraud analysis
    analyzeSpamFraud(match1, match2) {
        this.detailedWarnings = [];

        const results = {
            traitsComparison: this.compareTraits(match1.api_traits, match2.api_traits),
            unitsComparison: this.compareUnits(match1.api_units, match2.api_units),
            statsComparison: this.compareStats(match1, match2),
            itemsComparison: this.compareItems(match1.api_units, match2.api_units),
            fraudScores: this.fraudScores,
            isSpam: false,
            riskLevel: 'LOW',
            warnings: [],
            detailedAnalysis: [],
            match1Details: this.extractMatchDetails(match1),
            match2Details: this.extractMatchDetails(match2)
        };

        // Calculate overall fraud score
        results.fraudScores.overall = (
            results.fraudScores.traits +
            results.fraudScores.units +
            results.fraudScores.items +
            results.fraudScores.stats
        ) / 4;

        // Detailed analysis for each category
        results.detailedAnalysis = this.generateDetailedAnalysis(results);

        // Determine spam status and risk level
        if (results.fraudScores.overall >= this.spamThreshold) {
            results.isSpam = true;
            results.riskLevel = results.fraudScores.overall >= 80 ? 'CRITICAL' : 'HIGH';
            results.warnings.push(`Độ tương đồng tổng thể: ${results.fraudScores.overall.toFixed(1)}% (vượt ngưỡng ${this.spamThreshold}%)`);
        }

        results.warnings = [...results.warnings, ...this.detailedWarnings];
        return results;
    }

    // Compare traits between matches
    compareTraits(traits1, traits2) {
        const traits1Map = new Map(traits1.map(t => [t.name, t]));
        const traits2Map = new Map(traits2.map(t => [t.name, t]));

        let identicalTraits = 0;
        let totalTraits = Math.max(traits1.length, traits2.length);
        const details = [];

        for (const [name, trait1] of traits1Map) {
            const trait2 = traits2Map.get(name);
            if (trait2) {
                const similarity = this.calculateTraitSimilarity(trait1, trait2);
                if (similarity >= 90) identicalTraits++;
                details.push({
                    name,
                    similarity,
                    match1: trait1,
                    match2: trait2,
                    isIdentical: similarity >= 90
                });
            }
        }

        this.fraudScores.traits = totalTraits > 0 ? (identicalTraits / totalTraits) * 100 : 0;

        // Add detailed warnings for traits
        if (this.fraudScores.traits > 70) {
            this.detailedWarnings.push(`⚠️ Traits: ${identicalTraits}/${totalTraits} traits giống hệt nhau (${this.fraudScores.traits.toFixed(1)}%)`);
        }
        if (this.fraudScores.traits > 85) {
            this.detailedWarnings.push(`🚨 CẢNH BÁO: Cấu hình traits gần như hoàn toàn giống nhau - có thể gian lận`);
        }

        return {
            identicalCount: identicalTraits,
            totalCount: totalTraits,
            similarityPercentage: this.fraudScores.traits,
            details,
            specificWarnings: this.getTraitSpecificWarnings(details)
        };
    }

    // Compare units between matches
    compareUnits(units1, units2) {
        const units1Map = new Map(units1.map(u => [u.character_id, u]));
        const units2Map = new Map(units2.map(u => [u.character_id, u]));

        let identicalUnits = 0;
        let totalUnits = Math.max(units1.length, units2.length);
        const details = [];

        for (const [charId, unit1] of units1Map) {
            const unit2 = units2Map.get(charId);
            if (unit2) {
                const similarity = this.calculateUnitSimilarity(unit1, unit2);
                if (similarity >= 85) identicalUnits++;
                details.push({
                    character_id: charId,
                    similarity,
                    match1: unit1,
                    match2: unit2,
                    isIdentical: similarity >= 85
                });
            }
        }

        this.fraudScores.units = totalUnits > 0 ? (identicalUnits / totalUnits) * 100 : 0;

        // Add detailed warnings for units
        if (this.fraudScores.units > 70) {
            this.detailedWarnings.push(`⚠️ Tướng: ${identicalUnits}/${totalUnits} tướng giống hệt nhau (${this.fraudScores.units.toFixed(1)}%)`);
        }
        if (this.fraudScores.units > 85) {
            this.detailedWarnings.push(`🚨 CẢNH BÁO: Đội hình tướng gần như hoàn toàn giống nhau - nghi ngờ spam`);
        }

        return {
            identicalCount: identicalUnits,
            totalCount: totalUnits,
            similarityPercentage: this.fraudScores.units,
            details,
            specificWarnings: this.getUnitSpecificWarnings(details)
        };
    }

    // Compare items across all units
    compareItems(units1, units2) {
        const items1 = this.extractAllItems(units1);
        const items2 = this.extractAllItems(units2);

        const commonItems = items1.filter(item => items2.includes(item));
        const totalUniqueItems = [...new Set([...items1, ...items2])].length;

        this.fraudScores.items = totalUniqueItems > 0 ? (commonItems.length / totalUniqueItems) * 100 : 0;

        // Add detailed warnings for items
        if (this.fraudScores.items > 60) {
            this.detailedWarnings.push(`⚠️ Trang bị: ${commonItems.length}/${totalUniqueItems} trang bị giống nhau (${this.fraudScores.items.toFixed(1)}%)`);
        }
        if (this.fraudScores.items > 80) {
            this.detailedWarnings.push(`🚨 CẢNH BÁO: Trang bị gần như hoàn toàn giống nhau - có thể gian lận`);
        }

        return {
            commonItems: commonItems.length,
            totalItems: totalUniqueItems,
            similarityPercentage: this.fraudScores.items,
            match1Items: items1,
            match2Items: items2,
            commonItemsList: commonItems,
            specificWarnings: this.getItemSpecificWarnings(items1, items2, commonItems)
        };
    }

    // Compare game stats
    compareStats(match1, match2) {
        const stats = ['api_placement', 'api_level', 'api_gold_left', 'api_last_round', 'api_total_damage'];
        let identicalStats = 0;
        const details = [];

        stats.forEach(stat => {
            const val1 = match1[stat];
            const val2 = match2[stat];
            const isIdentical = val1 === val2;

            if (isIdentical) identicalStats++;

            details.push({
                stat,
                match1Value: val1,
                match2Value: val2,
                isIdentical
            });
        });

        this.fraudScores.stats = (identicalStats / stats.length) * 100;

        // Add detailed warnings for stats
        if (this.fraudScores.stats > 60) {
            this.detailedWarnings.push(`⚠️ Thống kê: ${identicalStats}/${stats.length} chỉ số giống hệt nhau (${this.fraudScores.stats.toFixed(1)}%)`);
        }
        if (this.fraudScores.stats > 80) {
            this.detailedWarnings.push(`🚨 NGHIÊM TRỌNG: Thống kê trận đấu hoàn toàn giống nhau - nghi ngờ gian lận nghiêm trọng`);
        }

        return {
            identicalCount: identicalStats,
            totalCount: stats.length,
            similarityPercentage: this.fraudScores.stats,
            details,
            specificWarnings: this.getStatsSpecificWarnings(details)
        };
    }

    // Helper functions
    calculateTraitSimilarity(trait1, trait2) {
        let score = 0;
        if (trait1.num_units === trait2.num_units) score += 40;
        if (trait1.style === trait2.style) score += 30;
        if (trait1.tier_current === trait2.tier_current) score += 30;
        return score;
    }

    calculateUnitSimilarity(unit1, unit2) {
        let score = 0;
        if (unit1.tier === unit2.tier) score += 50;
        if (unit1.rarity === unit2.rarity) score += 25;

        // Compare items
        const items1 = unit1.itemNames || [];
        const items2 = unit2.itemNames || [];
        const commonItems = items1.filter(item => items2.includes(item));
        const itemSimilarity = items1.length > 0 ? (commonItems.length / items1.length) * 25 : 25;
        score += itemSimilarity;

        return score;
    }

    extractAllItems(units) {
        return units.flatMap(unit => unit.itemNames || []);
    }

    // Generate detailed report
    generateReport(results) {
        return {
            summary: {
                isSpam: results.isSpam,
                riskLevel: results.riskLevel,
                overallScore: results.fraudScores.overall,
                warnings: results.warnings
            },
            details: {
                traits: results.traitsComparison,
                units: results.unitsComparison,
                items: results.itemsComparison,
                stats: results.statsComparison
            },
            recommendations: this.generateRecommendations(results)
        };
    }

    // Generate detailed analysis for each category
    generateDetailedAnalysis(results) {
        const analysis = [];

        // Traits analysis
        if (results.fraudScores.traits > 30) {
            analysis.push({
                category: 'Traits (Đặc tính)',
                severity: results.fraudScores.traits > 70 ? 'high' : 'medium',
                score: results.fraudScores.traits,
                message: this.getTraitsAnalysisMessage(results.traitsComparison),
                details: results.traitsComparison.specificWarnings || []
            });
        }

        // Units analysis
        if (results.fraudScores.units > 30) {
            analysis.push({
                category: 'Units (Tướng)',
                severity: results.fraudScores.units > 70 ? 'high' : 'medium',
                score: results.fraudScores.units,
                message: this.getUnitsAnalysisMessage(results.unitsComparison),
                details: results.unitsComparison.specificWarnings || []
            });
        }

        // Items analysis
        if (results.fraudScores.items > 30) {
            analysis.push({
                category: 'Items (Trang bị)',
                severity: results.fraudScores.items > 70 ? 'high' : 'medium',
                score: results.fraudScores.items,
                message: this.getItemsAnalysisMessage(results.itemsComparison),
                details: results.itemsComparison.specificWarnings || []
            });
        }

        // Stats analysis
        if (results.fraudScores.stats > 30) {
            analysis.push({
                category: 'Stats (Thống kê)',
                severity: results.fraudScores.stats > 70 ? 'high' : 'medium',
                score: results.fraudScores.stats,
                message: this.getStatsAnalysisMessage(results.statsComparison),
                details: results.statsComparison.specificWarnings || []
            });
        }

        return analysis;
    }

    // Specific warning generators
    getTraitSpecificWarnings(details) {
        const warnings = [];
        const identicalTraits = details.filter(d => d.isIdentical);

        if (identicalTraits.length > 0) {
            warnings.push(`Các traits giống hệt: ${identicalTraits.map(t => t.name.replace('TFT14_', '').replace('TFTEvent5YR_', '')).join(', ')}`);
        }

        return warnings;
    }

    getUnitSpecificWarnings(details) {
        const warnings = [];
        const identicalUnits = details.filter(d => d.isIdentical);

        if (identicalUnits.length > 0) {
            warnings.push(`Các tướng giống hệt: ${identicalUnits.map(u => u.character_id.replace('TFT14_', '')).join(', ')}`);
        }

        return warnings;
    }

    getItemSpecificWarnings(items1, items2, commonItems) {
        const warnings = [];

        if (commonItems.length > 0) {
            warnings.push(`Trang bị giống nhau: ${commonItems.map(item => item.replace('TFT_Item_', '').replace('TFTEvent5YR_Item_', '')).join(', ')}`);
        }

        return warnings;
    }

    getStatsSpecificWarnings(details) {
        const warnings = [];
        const identicalStats = details.filter(d => d.isIdentical);

        identicalStats.forEach(stat => {
            const statName = this.translateStatName(stat.stat);
            warnings.push(`${statName}: ${stat.match1Value} (hoàn toàn giống nhau)`);
        });

        return warnings;
    }

    // Analysis message generators
    getTraitsAnalysisMessage(comparison) {
        if (comparison.similarityPercentage > 80) {
            return 'Cấu hình đặc tính gần như hoàn toàn giống nhau - nghi ngờ cao về gian lận';
        } else if (comparison.similarityPercentage > 60) {
            return 'Cấu hình đặc tính có độ tương đồng cao - cần xem xét thêm';
        } else {
            return 'Có một số đặc tính giống nhau nhưng vẫn trong mức bình thường';
        }
    }

    getUnitsAnalysisMessage(comparison) {
        if (comparison.similarityPercentage > 80) {
            return 'Đội hình tướng gần như hoàn toàn giống nhau - nghi ngờ cao về spam';
        } else if (comparison.similarityPercentage > 60) {
            return 'Đội hình tướng có độ tương đồng cao - có thể là spam';
        } else {
            return 'Có một số tướng giống nhau nhưng vẫn chấp nhận được';
        }
    }

    getItemsAnalysisMessage(comparison) {
        if (comparison.similarityPercentage > 80) {
            return 'Trang bị gần như hoàn toàn giống nhau - nghi ngờ cao về gian lận';
        } else if (comparison.similarityPercentage > 60) {
            return 'Trang bị có độ tương đồng cao - cần kiểm tra thêm';
        } else {
            return 'Có một số trang bị giống nhau nhưng vẫn hợp lý';
        }
    }

    getStatsAnalysisMessage(comparison) {
        if (comparison.similarityPercentage > 80) {
            return 'Thống kê trận đấu hoàn toàn giống nhau - nghi ngờ nghiêm trọng về gian lận';
        } else if (comparison.similarityPercentage > 60) {
            return 'Thống kê trận đấu có độ tương đồng cao - cần điều tra';
        } else {
            return 'Có một số thống kê giống nhau nhưng vẫn bình thường';
        }
    }

    translateStatName(statName) {
        const translations = {
            'api_placement': 'Thứ hạng',
            'api_level': 'Cấp độ',
            'api_gold_left': 'Vàng còn lại',
            'api_last_round': 'Vòng cuối',
            'api_total_damage': 'Tổng sát thương'
        };
        return translations[statName] || statName;
    }

    // Enhanced recommendations
    generateRecommendations(results) {
        const recommendations = [];

        if (results.fraudScores.traits > 70) {
            recommendations.push('🔍 Kiểm tra cấu hình traits - độ tương đồng quá cao');
        }
        if (results.fraudScores.units > 70) {
            recommendations.push('🔍 Xem xét đội hình tướng - có thể có dấu hiệu spam');
        }
        if (results.fraudScores.items > 70) {
            recommendations.push('🔍 Kiểm tra trang bị - sự trùng lặp bất thường');
        }
        if (results.fraudScores.stats > 80) {
            recommendations.push('🚨 KHẨN CẤP: Thống kê hoàn toàn giống nhau - cần điều tra ngay');
        }
        if (results.isSpam) {
            recommendations.push('⚠️ PHÁT HIỆN SPAM: Cần xem xét thủ công và có biện pháp xử lý');
        }

        if (recommendations.length === 0) {
            recommendations.push('✅ Không phát hiện dấu hiệu bất thường');
        }

        return recommendations;
    }

    // Extract detailed match information
    extractMatchDetails(match) {
        return {
            basic: {
                calendar_id: match.calendar_id,
                tft_division: match.tft_division,
                tft_rank: match.tft_rank,
                tft_points: match.tft_points,
                created_at: match.created_at
            },
            gameStats: {
                placement: match.api_placement,
                level: match.api_level,
                goldLeft: match.api_gold_left,
                lastRound: match.api_last_round,
                totalDamage: match.api_total_damage,
                playersEliminated: match.api_players_eliminated,
                gameLength: match.api_game_length,
                gameDateTime: match.api_game_datetime
            },
            traits: match.api_traits.map(trait => ({
                name: trait.name.replace('TFT14_', '').replace('TFTEvent5YR_', ''),
                originalName: trait.name,
                numUnits: trait.num_units,
                style: trait.style,
                tierCurrent: trait.tier_current,
                tierTotal: trait.tier_total
            })),
            units: match.api_units.map(unit => ({
                name: unit.character_id.replace('TFT14_', ''),
                originalName: unit.character_id,
                tier: unit.tier,
                rarity: unit.rarity,
                items: unit.itemNames ? unit.itemNames.map(item =>
                    item.replace('TFT_Item_', '').replace('TFTEvent5YR_Item_', '')
                ) : []
            }))
        };
    }

    // Create detailed comparison popup content
    createMatchComparisonPopup(match1Details, match2Details, results) {
        return `
            <div class="modal fade" id="matchComparisonModal" tabindex="-1" aria-labelledby="matchComparisonModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="matchComparisonModalLabel">
                                <i class="fas fa-vs me-2"></i>Chi tiết so sánh trận đấu
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Match Overview -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-trophy me-2"></i>Trận đấu 1</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Lịch đấu:</strong> ${match1Details.basic.calendar_id}</p>
                                            <p class="mb-1"><strong>Division:</strong> ${match1Details.basic.tft_division}</p>
                                            <p class="mb-1"><strong>Rank:</strong> ${match1Details.basic.tft_rank}</p>
                                            <p class="mb-1"><strong>Points:</strong> ${match1Details.basic.tft_points}</p>
                                            <p class="mb-0"><strong>Thời gian:</strong> ${new Date(match1Details.basic.created_at).toLocaleString('vi-VN')}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="fas fa-trophy me-2"></i>Trận đấu 2</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Lịch đấu:</strong> ${match2Details.basic.calendar_id}</p>
                                            <p class="mb-1"><strong>Division:</strong> ${match2Details.basic.tft_division}</p>
                                            <p class="mb-1"><strong>Rank:</strong> ${match2Details.basic.tft_rank}</p>
                                            <p class="mb-1"><strong>Points:</strong> ${match2Details.basic.tft_points}</p>
                                            <p class="mb-0"><strong>Thời gian:</strong> ${new Date(match2Details.basic.created_at).toLocaleString('vi-VN')}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Game Stats Comparison -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="mb-3"><i class="fas fa-chart-bar me-2"></i>So sánh thống kê trận đấu</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Thống kê</th>
                                                    <th class="text-center">Trận đấu 1</th>
                                                    <th class="text-center">Trận đấu 2</th>
                                                    <th class="text-center">Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${this.generateStatsComparisonRows(match1Details.gameStats, match2Details.gameStats, results.statsComparison.details)}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Traits Comparison -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="mb-3"><i class="fas fa-star me-2"></i>So sánh đặc tính (Traits)</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-primary text-white">
                                                    <small>Trận đấu 1 - Traits</small>
                                                </div>
                                                <div class="card-body">
                                                    ${this.generateTraitsList(match1Details.traits)}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-info text-white">
                                                    <small>Trận đấu 2 - Traits</small>
                                                </div>
                                                <div class="card-body">
                                                    ${this.generateTraitsList(match2Details.traits)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Units Comparison -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="mb-3"><i class="fas fa-users me-2"></i>So sánh đội hình tướng</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-primary text-white">
                                                    <small>Trận đấu 1 - Đội hình</small>
                                                </div>
                                                <div class="card-body">
                                                    ${this.generateUnitsList(match1Details.units)}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-info text-white">
                                                    <small>Trận đấu 2 - Đội hình</small>
                                                </div>
                                                <div class="card-body">
                                                    ${this.generateUnitsList(match2Details.units)}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Identical Elements Highlight -->
                            ${this.generateIdenticalElementsSection(results)}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>In báo cáo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    generateStatsComparisonRows(stats1, stats2, comparisonDetails) {
        const statTranslations = {
            'placement': 'Thứ hạng',
            'level': 'Cấp độ',
            'goldLeft': 'Vàng còn lại',
            'lastRound': 'Vòng cuối',
            'totalDamage': 'Tổng sát thương',
            'playersEliminated': 'Số người loại',
            'gameLength': 'Thời gian trận',
            'gameDateTime': 'Thời điểm trận đấu'
        };

        let rows = '';
        Object.keys(statTranslations).forEach(key => {
            const detail = comparisonDetails.find(d => d.stat === `api_${key === 'goldLeft' ? 'gold_left' : key === 'lastRound' ? 'last_round' : key === 'totalDamage' ? 'total_damage' : key === 'playersEliminated' ? 'players_eliminated' : key === 'gameLength' ? 'game_length' : key === 'gameDateTime' ? 'game_datetime' : key}`);
            const isIdentical = detail ? detail.isIdentical : false;
            const statusClass = isIdentical ? 'text-danger' : 'text-success';
            const statusIcon = isIdentical ? '⚠️ Giống hệt' : '✅ Khác nhau';

            rows += `
                <tr class="${isIdentical ? 'table-warning' : ''}">
                    <td><strong>${statTranslations[key]}</strong></td>
                    <td class="text-center">${stats1[key] || 'N/A'}</td>
                    <td class="text-center">${stats2[key] || 'N/A'}</td>
                    <td class="text-center ${statusClass}"><small>${statusIcon}</small></td>
                </tr>
            `;
        });

        return rows;
    }

    generateTraitsList(traits) {
        if (!traits || traits.length === 0) {
            return '<p class="text-muted">Không có traits</p>';
        }

        return traits.map(trait => `
            <div class="mb-2 p-2 border rounded">
                <strong>${trait.name}</strong>
                <br>
                <small class="text-muted">
                    Units: ${trait.numUnits} |
                    Tier: ${trait.tierCurrent}/${trait.tierTotal} |
                    Style: ${trait.style}
                </small>
            </div>
        `).join('');
    }

    generateUnitsList(units) {
        if (!units || units.length === 0) {
            return '<p class="text-muted">Không có tướng</p>';
        }

        return units.map(unit => `
            <div class="mb-2 p-2 border rounded">
                <strong>${unit.name}</strong>
                <span class="badge bg-secondary">⭐${unit.tier}</span>
                <span class="badge bg-info">Rarity: ${unit.rarity}</span>
                <br>
                <small class="text-muted">
                    Items: ${unit.items.length > 0 ? unit.items.join(', ') : 'Không có trang bị'}
                </small>
            </div>
        `).join('');
    }

    generateIdenticalElementsSection(results) {
        const identicalTraits = results.traitsComparison.details.filter(d => d.isIdentical);
        const identicalUnits = results.unitsComparison.details.filter(d => d.isIdentical);
        const identicalStats = results.statsComparison.details.filter(d => d.isIdentical);

        if (identicalTraits.length === 0 && identicalUnits.length === 0 && identicalStats.length === 0) {
            return '';
        }

        return `
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning">
                        <h6 class="mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Các yếu tố giống hệt nhau</h6>

                        ${identicalTraits.length > 0 ? `
                            <div class="mb-3">
                                <strong>Traits giống hệt:</strong>
                                <div class="mt-1">
                                    ${identicalTraits.map(trait => `
                                        <span class="badge bg-danger me-1">${trait.name.replace('TFT14_', '').replace('TFTEvent5YR_', '')}</span>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}

                        ${identicalUnits.length > 0 ? `
                            <div class="mb-3">
                                <strong>Tướng giống hệt:</strong>
                                <div class="mt-1">
                                    ${identicalUnits.map(unit => `
                                        <span class="badge bg-danger me-1">${unit.character_id.replace('TFT14_', '')}</span>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}

                        ${identicalStats.length > 0 ? `
                            <div class="mb-0">
                                <strong>Thống kê giống hệt:</strong>
                                <div class="mt-1">
                                    ${identicalStats.map(stat => `
                                        <span class="badge bg-danger me-1">${this.translateStatName(stat.stat)}: ${stat.match1Value}</span>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }
}

// Export for use in other files
window.TFTCompareCheat = TFTCompareCheat;
