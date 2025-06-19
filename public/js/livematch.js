function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.player-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectedCount();
        }

        function selectAll() {
            const checkboxes = document.querySelectorAll('.player-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            selectAllCheckbox.checked = true;
            updateSelectedCount();
        }

        function clearAll() {
            const checkboxes = document.querySelectorAll('.player-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.player-checkbox:checked');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count;
        }

        function resetForm() {
            if(confirm('Bạn có chắc chắn muốn làm mới tất cả dữ liệu?')) {
                document.getElementById('calendarForm').reset();
                clearAll();
                document.getElementById('fightData').innerHTML = '<div class="text-center text-muted py-3"><i class="bx bx-loader-alt bx-spin me-2"></i>Nhập mã trận đấu để tải dữ liệu</div>';
            }
        }

        function cancelMatch() {
            if(confirm('Bạn có chắc chắn muốn hủy trận đấu này?')) {
                document.getElementById('match_status').value = 'cancelled';
                // Add additional cancel logic here
            }
        }

        function fetchMatchData() {
            const matchCode = document.getElementById('match_code').value;

            // Get all player PUUIDs
            const playerPuuids = [];
            document.querySelectorAll('input[name="player_ids[]"]').forEach(input  => {
                if(input.value) {
                    playerPuuids.push(input.value);
                }
            });

            if(!matchCode && playerPuuids.length === 0) {
                alert('Vui lòng nhập mã trận đấu hoặc chọn người chơi để lấy match mới nhất');
                return;
            }

            const fightData = document.getElementById('fightData');
            fightData.innerHTML = '<div class="text-center py-3"><i class="bx bx-loader-alt bx-spin me-2"></i>Đang tải dữ liệu...</div>';

            // If we have match code, use it directly
            if(matchCode) {
                fetchByMatchCode(matchCode);
            } else if(playerPuuids.length > 0) {
                // Use the first player's PUUID to get latest match
                fetchLatestMatch(playerPuuids[0]);
            }
        }

        function fetchMatchDataByPuuid() {
            const puuid = document.getElementById('puuid').value.trim();

            if(!puuid) {
                alert('Vui lòng nhập PUUID của người chơi');
                return;
            }

            const fightData = document.getElementById('fightData');
            fightData.innerHTML = '<div class="text-center py-3"><i class="bx bx-loader-alt bx-spin me-2"></i>Đang tải dữ liệu từ PUUID...</div>';

            fetchLatestMatch(puuid);
        }

        function fetchFromSelectedPlayers() {
            // Get all selected player PUUIDs
            const selectedPuuids = [];
            const checkboxes = document.querySelectorAll('.player-checkbox:checked');

            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const puuidInput = row.querySelector('input[name="player_ids[]"]');
                if(puuidInput && puuidInput.value) {
                    selectedPuuids.push(puuidInput.value);
                }
            });

            if(selectedPuuids.length === 0) {
                alert('Vui lòng chọn ít nhất một người chơi');
                return;
            }

            const fightData = document.getElementById('fightData');
            fightData.innerHTML = '<div class="text-center py-3"><i class="bx bx-loader-alt bx-spin me-2"></i>Đang tải dữ liệu từ người chơi đã chọn...</div>';

            // Use the first selected player's PUUID
            fetchLatestMatch(selectedPuuids[0]);
        }

        function loadDemoData() {
            if(confirm('Bạn có muốn tải dữ liệu demo? Điều này sẽ thay thế dữ liệu hiện tại.')) {
                const fightData = document.getElementById('fightData');
                fightData.innerHTML = '<div class="text-center py-3"><i class="bx bx-loader-alt bx-spin me-2"></i>Đang tải dữ liệu demo...</div>';

                // Load demo data from JSON files - try Set 14 first, then Set 10
                const demoFiles = [
                    '/app/demo.json',    // Set 14 demo
                    '/app/set10.json'    // Set 10 demo
                ];

                // Try loading demo files sequentially
                async function loadDemo() {
                    for (const demoFile of demoFiles) {
                        try {
                            const response = await fetch(demoFile);
                            if (response.ok) {
                                const data = await response.json();
                                displayMatchData(data);
                                return; // Success, exit the function
                            }
                        } catch (error) {
                            console.warn(`Failed to load ${demoFile}:`, error);
                            continue; // Try next file
                        }
                    }

                    // If all files failed to load
                    throw new Error('Không thể tải bất kỳ file demo nào');
                }

                loadDemo().catch(error => {
                    console.error('Error loading demo data:', error);
                    const fightData = document.getElementById('fightData');
                    fightData.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bx bx-error-circle me-2"></i>
                            Không thể tải dữ liệu demo: ${error.message}
                            <br><small class="text-muted">Vui lòng kiểm tra xem các file demo.json và set10.json có tồn tại trong thư mục /app/</small>
                        </div>
                    `;
                });
            }
        }

        function fetchByMatchCode(matchCode) {
            // Simulate API call for match code
            setTimeout(() => {
                const fightData = document.getElementById('fightData');
                fightData.innerHTML = `
                    <div class="alert alert-success">
                        <i class="bx bx-check-circle me-2"></i>
                        Đã tải thành công dữ liệu trận đấu <strong>${matchCode}</strong>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Thời gian:</strong> ${new Date().toLocaleString('vi-VN')}
                        </div>
                        <div class="col-md-6">
                            <strong>Trạng thái:</strong> <span class="badge bg-success">Hoàn thành</span>
                        </div>
                    </div>
                `;
            }, 2000);
        }

        function fetchLatestMatch(puuid) {
            // Call the API route
            fetch(`/api/discord/lastestmatch/${puuid}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + '{{ session("access_token") }}', // Adjust based on your auth method
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                displayMatchData(data);
            })
            .catch(error => {
                console.error('Error fetching match data:', error);
                const fightData = document.getElementById('fightData');
                fightData.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bx bx-error-circle me-2"></i>
                        Không thể tải dữ liệu trận đấu: ${error.message}
                    </div>
                `;
            });
        }

        function displayMatchData(matchData) {
            const fightData = document.getElementById('fightData');

            if (!matchData || !matchData.info) {
                fightData.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="bx bx-exclamation-triangle me-2"></i>
                        Không tìm thấy dữ liệu trận đấu
                    </div>
                `;
                return;
            }

            // Store match data globally for modal use
            window.currentMatchData = matchData;

            // Update match code field if available
            if (matchData.metadata && matchData.metadata.match_id) {
                document.getElementById('match_code').value = matchData.metadata.match_id;
            }

            // Get current player PUUIDs from the form
            const currentPlayerPuuids = [];
            document.querySelectorAll('input[name="player_ids[]"]').forEach(input => {
                if(input.value) {
                    currentPlayerPuuids.push(input.value);
                }
            });

            // Display match information
            let matchInfoHtml = `
                <div class="alert alert-success">
                    <i class="bx bx-check-circle me-2"></i>
                    Đã tải thành công dữ liệu trận đấu <strong>${matchData.metadata?.match_id || 'N/A'}</strong>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <strong>Match ID:</strong><br>
                        <small class="text-muted">${matchData.metadata?.match_id || 'N/A'}</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Thời gian:</strong><br>
                        <small class="text-muted">${matchData.info?.game_datetime ? new Date(matchData.info.game_datetime).toLocaleString('vi-VN') : 'N/A'}</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Thời lượng:</strong><br>
                        <small class="text-muted">${matchData.info?.game_length ? Math.round(matchData.info.game_length / 60) + ' phút' : 'N/A'}</small>
                    </div>
                    <div class="col-md-3">
                        <strong>Set TFT:</strong><br>
                        <small class="text-muted">Set ${matchData.info?.tft_set_number || 'N/A'}</small>
                    </div>
                </div>
            `;

            let participantsHtml = '';
            let matchedCount = 0;
            let unmatchedPlayers = [];

            if (matchData.info.participants) {
                participantsHtml = `
                    <div class="mt-3">
                        <h6 class="mb-3">
                            <i class="bx bx-trophy me-2"></i>Kết quả chi tiết trận đấu:
                            <span class="badge bg-info ms-2">${matchData.info.participants.length} người chơi</span>
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 60px;">Hạng</th>
                                        <th>Tên người chơi</th>
                                        <th style="width: 80px;">Level</th>
                                        <th style="width: 100px;">Vòng cuối</th>
                                        <th style="width: 100px;">Sát thương</th>
                                        <th style="width: 100px;">Trạng thái</th>
                                        <th style="width: 100px;">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;

                // Sort participants by placement
                const sortedParticipants = matchData.info.participants.sort((a, b) => a.placement - b.placement);

                sortedParticipants.forEach((participant, index) => {
                    const isMatched = currentPlayerPuuids.includes(participant.puuid);
                    if (isMatched) {
                        matchedCount++;
                    } else {
                        unmatchedPlayers.push(participant);
                    }

                    const placementBadge = getPlacementBadge(participant.placement);
                    const statusBadge = isMatched ?
                        '<span class="badge bg-success"><i class="bx bx-check"></i> Khớp</span>' :
                        '<span class="badge bg-warning"><i class="bx bx-x"></i> Không khớp</span>';

                    participantsHtml += `
                        <tr class="${isMatched ? 'table-success' : 'table-warning'}">
                            <td>${placementBadge}</td>
                            <td>
                                <div class="fw-semibold">${participant.riotIdGameName || 'N/A'}</div>
                                <small class="text-muted">#${participant.riotIdTagline || 'N/A'}</small>
                                <div><small class="text-muted font-monospace">${participant.puuid.substring(0, 20)}...</small></div>
                            </td>
                            <td><span class="badge bg-secondary">Lv ${participant.level}</span></td>
                            <td><strong>${participant.last_round}</strong></td>
                            <td><span class="text-danger">${participant.total_damage_to_players}</span></td>
                            <td>${statusBadge}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="showPlayerDetail('${participant.puuid}', event)" title="Xem chi tiết đội hình">
                                    <i class="bx bx-search-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                participantsHtml += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;

                // Add match summary
                participantsHtml += `
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <h5 class="text-success">${matchedCount}</h5>
                                        <small class="text-muted">Người chơi khớp</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning">${unmatchedPlayers.length}</h5>
                                        <small class="text-muted">Người chơi không khớp</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info">
                                    <div class="card-body text-center">
                                        <h5 class="text-info">${currentPlayerPuuids.length}</h5>
                                        <small class="text-muted">Người chơi trong danh sách</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            fightData.innerHTML = matchInfoHtml + participantsHtml;

            // Auto-fill player rankings if available
            if (matchData.info.participants) {
                autoFillPlayerRankings(matchData.info.participants);
            }

            // Show notification about match status
            showMatchStatusNotification(matchedCount, currentPlayerPuuids.length, unmatchedPlayers.length);
        }

        function showPlayerDetail(puuid, event) {
            // Prevent form submission and event bubbling
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const participant = window.currentMatchData.info.participants.find(p => p.puuid === puuid);
            if (!participant) return;

            const modalTitle = document.getElementById('playerDetailModalLabel');
            const modalContent = document.getElementById('playerDetailContent');

            modalTitle.innerHTML = `
                <i class="bx bx-user-detail me-2"></i>Chi tiết: ${participant.riotIdGameName}#${participant.riotIdTagline}
            `;

            // Build detailed content
            let detailHtml = `
                <div class="row">
                    <!-- Player Summary -->
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bx bx-user me-2"></i>Thông tin tổng quan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            ${getPlacementBadge(participant.placement)}
                                            <div class="mt-1"><small>Hạng</small></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-primary">${participant.level}</h4>
                                        <small>Level</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6"><strong>Vòng cuối:</strong></div>
                                    <div class="col-6">${participant.last_round}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><strong>Sát thương:</strong></div>
                                    <div class="col-6 text-danger">${participant.total_damage_to_players}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><strong>Tiêu diệt:</strong></div>
                                    <div class="col-6">${participant.players_eliminated}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><strong>Vàng còn:</strong></div>
                                    <div class="col-6 text-warning">${participant.gold_left}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Traits/Synergies -->
                    <div class="col-md-8">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="bx bx-layer-plus me-2"></i>Tộc & Hệ</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    ${generateTraitsHtml(participant.traits)}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Units and Items -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bx bx-chess me-2"></i>Đội hình & Trang bị</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    ${generateUnitsHtml(participant.units)}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            modalContent.innerHTML = detailHtml;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('playerDetailModal'));
            modal.show();
        }

        function generateTraitsHtml(traits) {
            if (!traits || traits.length === 0) return '<div class="col-12 text-muted">Không có thông tin tộc/hệ</div>';

            // Sort traits by tier and style
            const sortedTraits = traits.sort((a, b) => {
                if (b.tier_current !== a.tier_current) return b.tier_current - a.tier_current;
                return b.style - a.style;
            });

            return sortedTraits.map(trait => {
                const traitName = translateTraitName(trait.name);
                const styleClass = getTraitStyleClass(trait.style);
                const isActive = trait.tier_current > 0;

                return `
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="border rounded p-2 ${isActive ? styleClass : 'bg-light text-muted'}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">${traitName}</span>
                                <span class="badge ${isActive ? 'bg-white text-dark' : 'bg-secondary'}">${trait.num_units}</span>
                            </div>
                            ${isActive ? `<small>Cấp ${trait.tier_current}/${trait.tier_total}</small>` : '<small>Chưa kích hoạt</small>'}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function generateUnitsHtml(units) {
            if (!units || units.length === 0) return '<div class="col-12 text-muted">Không có thông tin tướng</div>';

            // Sort units by rarity (cost) and tier
            const sortedUnits = units.sort((a, b) => {
                if (b.rarity !== a.rarity) return b.rarity - a.rarity;
                return b.tier - a.tier;
            });

            return sortedUnits.map(unit => {
                const unitName = translateUnitName(unit.character_id);
                const rarityClass = getRarityClass(unit.rarity);
                const stars = '★'.repeat(unit.tier);

                return `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header ${rarityClass} text-white p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">${unitName}</span>
                                    <span class="badge bg-white text-dark">${stars}</span>
                                </div>
                                <small>Cost: ${unit.rarity} | Tier: ${unit.tier}</small>
                            </div>
                            <div class="card-body p-2">
                                ${unit.itemNames && unit.itemNames.length > 0 ? `
                                    <div class="mb-2">
                                        <strong>Trang bị:</strong>
                                        <div class="mt-1">
                                            ${unit.itemNames.map(item => `
                                                <span class="badge bg-warning text-dark me-1 mb-1" title="${item}">
                                                    ${translateItemName(item)}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>
                                ` : '<div class="text-muted">Không có trang bị</div>'}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function translateTraitName(traitName) {
            // Set 14 traits
            const set14Traits = {
                'TFT14_Bruiser': 'Đấu Sĩ',
                'TFT14_Cutter': 'Sát Thủ',
                'TFT14_Divinicorp': 'Divinicorp',
                'TFT14_Immortal': 'Bất Tử',
                'TFT14_Strong': 'Mạnh Mẽ',
                'TFT14_Supercharge': 'Siêu Tăng Cường',
                'TFT14_Techie': 'Kỹ Thuật Viên',
                'TFT14_Vanguard': 'Tiền Phong',
                'TFT14_AnimaSquad': 'Anima Squad',
                'TFT14_Armorclad': 'Áo Giáp',
                'TFT14_BallisTek': 'BallisTek',
                'TFT14_Controller': 'Điều Khiển',
                'TFT14_Cyberboss': 'Cyber Boss',
                'TFT14_EdgeRunner': 'Edge Runner',
                'TFT14_HotRod': 'Hot Rod',
                'TFT14_Marksman': 'Xạ Thủ',
                'TFT14_Overlord': 'Chúa Tể',
                'TFT14_StreetDemon': 'Ác Quỷ Đường Phố',
                'TFT14_Swift': 'Nhanh Nhẹn',
                'TFT14_Thirsty': 'Khát Máu',
                'TFT14_Suits': 'Vest',
                'TFT14_Virus': 'Virus',
                'TFT14_Mob': 'Băng Đảng'
            };

            // Set 10 traits
            const set10Traits = {
                'TFT10_8Bit': '8-bit',
                'TFT10_Brawler': 'Đấu Sĩ',
                'TFT10_Breakout': 'Breakout',
                'TFT10_Country': 'Country',
                'TFT10_CrowdDive': 'Crowd Dive',
                'TFT10_Dazzler': 'Dazzler',
                'TFT10_Deadeye': 'Deadeye',
                'TFT10_DJ': 'DJ',
                'TFT10_EDM': 'EDM',
                'TFT10_Edgelord': 'Edgelord',
                'TFT10_Emo': 'Emo',
                'TFT10_Executioner': 'Executioner',
                'TFT10_Fighter': 'Fighter',
                'TFT10_Funk': 'Funk',
                'TFT10_Guardian': 'Guardian',
                'TFT10_Hyperpop': 'Hyperpop',
                'TFT10_IllBeats': 'Ill Beats',
                'TFT10_Jazz': 'Jazz',
                'TFT10_KDA': 'K/DA',
                'TFT10_Pentakill': 'Pentakill',
                'TFT10_PopBand': 'Heart Steel',
                'TFT10_PunkRock': 'Punk Rock',
                'TFT10_Quickshot': 'Quickshot',
                'TFT10_Sentinel': 'Sentinel',
                'TFT10_Spellweaver': 'Spellweaver',
                'TFT10_Superfan': 'Superfan',
                'TFT10_TrueDamage': 'True Damage',
                'TFT10_TwoSides': 'Two Sides'
            };

            // Check if it's Set 14 or Set 10
            if (traitName.startsWith('TFT14_')) {
                return set14Traits[traitName] || traitName.replace('TFT14_', '');
            } else if (traitName.startsWith('TFT10_')) {
                return set10Traits[traitName] || traitName.replace('TFT10_', '');
            }

            return traitName;
        }

        function translateUnitName(unitId) {
            // Set 14 units
            const set14Units = {
                'TFT14_Alistar': 'Alistar',
                'TFT14_Graves': 'Graves',
                'TFT14_Rhaast': 'Rhaast',
                'TFT14_Jarvan': 'Jarvan IV',
                'TFT14_Gragas': 'Gragas',
                'TFT14_Vex': 'Vex',
                'TFT14_Annie': 'Annie',
                'TFT14_Viego': 'Viego',
                'TFT14_NidaleeCougar': 'Nidalee',
                'TFT14_Kindred': 'Kindred',
                'TFT14_Poppy': 'Poppy',
                'TFT14_Shyvana': 'Shyvana',
                'TFT14_Elise': 'Elise',
                'TFT14_Mordekaiser': 'Mordekaiser',
                'TFT14_Aurora': 'Aurora',
                'TFT14_Aphelios': 'Aphelios',
                'TFT14_Samira': 'Samira',
                'TFT14_Renekton': 'Renekton',
                'TFT14_Urgot': 'Urgot',
                'TFT14_Kobuko': 'Kobuko'
            };

            // Set 10 units
            const set10Units = {
                'TFT10_Annie': 'Annie',
                'TFT10_Gragas': 'Gragas',
                'TFT10_Amumu': 'Amumu',
                'TFT10_Vex': 'Vex',
                'TFT10_Lulu': 'Lulu',
                'TFT10_Ekko': 'Ekko',
                'TFT10_Ahri': 'Ahri',
                'TFT10_Poppy': 'Poppy',
                'TFT10_Seraphine': 'Seraphine',
                'TFT10_KSante': 'K\'Sante',
                'TFT10_Aphelios': 'Aphelios',
                'TFT10_Yone': 'Yone',
                'TFT10_Sett': 'Sett',
                'TFT10_Ezreal': 'Ezreal',
                'TFT10_Caitlyn': 'Caitlyn',
                'TFT10_Zac': 'Zac',
                'TFT10_Blitzcrank': 'Blitzcrank',
                'TFT10_Yasuo': 'Yasuo',
                'TFT10_Kennen': 'Kennen',
                'TFT10_Senna': 'Senna',
                'TFT10_Viego': 'Viego',
                'TFT10_Akali_TrueDamage': 'Akali (True Damage)',
                'TFT10_Kayn': 'Kayn',
                'TFT10_Gnar': 'Gnar',
                'TFT10_Pantheon': 'Pantheon',
                'TFT10_Neeko': 'Neeko',
                'TFT10_Thresh': 'Thresh',
                'TFT10_Qiyana': 'Qiyana',
                'TFT10_Yorick': 'Yorick',
                'TFT10_Lillia': 'Lillia',
                'TFT10_Vi': 'Vi',
                'TFT10_Jax': 'Jax',
                'TFT10_Kayle': 'Kayle',
                'TFT10_Riven': 'Riven',
                'TFT10_Lucian': 'Lucian',
                'TFT10_Lux': 'Lux',
                'TFT10_Zed': 'Zed',
                'TFT10_Illaoi': 'Illaoi',
                'TFT10_Sona': 'Sona',
                'TFT10_Ziggs': 'Ziggs'
            };

            // Check if it's Set 14 or Set 10
            if (unitId.startsWith('TFT14_')) {
                return set14Units[unitId] || unitId.replace('TFT14_', '');
            } else if (unitId.startsWith('TFT10_')) {
                return set10Units[unitId] || unitId.replace('TFT10_', '');
            }

            return unitId;
        }

        function translateItemName(itemName) {
            // Common items for both sets
            const commonItems = {
                'TFT_Item_SteraksGage': 'Sterak',
                'TFT_Item_ThiefsGloves': 'Găng Tay Trộm',
                'TFT_Item_GuinsoosRageblade': 'Guinsoo',
                'TFT_Item_BlueBuff': 'Đấm Xanh',
                'TFT_Item_BrambleVest': 'Áo Gai',
                'TFT_Item_SpectralGauntlet': 'Găng Ma',
                'TFT_Item_DragonsClaw': 'Móng Rồng',
                'TFT_Item_InfinityEdge': 'Vô Cực',
                'TFT_Item_Bloodthirster': 'Khát Máu',
                'TFT_Item_GuardianAngel': 'Thiên Thần Hộ Mệnh',
                'TFT_Item_MadredsBloodrazor': 'Madred\'s Bloodrazor',
                'TFT_Item_SpearOfShojin': 'Spear of Shojin',
                'TFT_Item_ArchangelsStaff': 'Archangel\'s Staff',
                'TFT_Item_RabadonsDeathcap': 'Rabadon\'s Deathcap',
                'TFT_Item_JeweledGauntlet': 'Jeweled Gauntlet',
                'TFT_Item_RunaansHurricane': 'Runaan\'s Hurricane',
                'TFT_Item_RedBuff': 'Red Buff',
                'TFT_Item_GargoyleStoneplate': 'Gargoyle Stoneplate',
                'TFT_Item_WarmogsArmor': 'Warmog\'s Armor',
                'TFT_Item_Redemption': 'Redemption',
                'TFT_Item_FrozenHeart': 'Frozen Heart',
                'TFT_Item_LastWhisper': 'Last Whisper',
                'TFT_Item_RapidFireCannon': 'Rapid Firecannon',
                'TFT_Item_IonicSpark': 'Ionic Spark',
                'TFT_Item_PowerGauntlet': 'Power Gauntlet',
                'TFT_Item_HextechGunblade': 'Hextech Gunblade',
                'TFT_Item_TitansResolve': 'Titan\'s Resolve',
                'TFT_Item_UnstableConcoction': 'Unstable Concoction',
                'TFT_Item_Leviathan': 'Leviathan',
                'TFT_Item_NightHarvester': 'Night Harvester',
                'TFT_Item_AdaptiveHelm': 'Adaptive Helm',
                'TFT_Item_Morellonomicon': 'Morellonomicon',
                'TFT_Item_Deathblade': 'Deathblade',
                'TFT_Item_ForceOfNature': 'Force of Nature'
            };

            // Set 14 specific items
            const set14Items = {
                'TFT5_Item_NightHarvesterRadiant': 'Thu Hoạch Đêm (Rực Rỡ)',
                'TFT5_Item_QuicksilverRadiant': 'Thủy Ngân (Rực Rỡ)',
                'TFT14_Item_ImmortalEmblemItem': 'Ấn Bất Tử',
                'TFT5_Item_RedemptionRadiant': 'Cứu Chuộc (Rực Rỡ)',
                'TFT5_Item_JeweledGauntletRadiant': 'Găng Châu Báu (Rực Rỡ)',
                'TFT5_Item_BlueBuffRadiant': 'Đấm Xanh (Rực Rỡ)',
                'TFT5_Item_GuardianAngelRadiant': 'Thiên Thần (Rực Rỡ)'
            };

            // Set 10 specific items
            const set10Items = {
                'TFT_Item_Artifact_LichBane': 'Lich Bane (Artifact)',
                'TFT_Item_Artifact_LightshieldCrest': 'Lightshield Crest (Artifact)',
                'TFT9_Item_OrnnDeathfireGrasp': 'Deathfire Grasp (Ornn)',
                'TFT4_Item_OrnnInfinityForce': 'Trinity Force (Ornn)',
                'TFT4_Item_OrnnRanduinsSanctum': 'Randuin\'s Sanctum (Ornn)',
                'TFT5_Item_SteraksGageRadiant': 'Sterak (Rực Rỡ)',
                'TFT5_Item_InfinityEdgeRadiant': 'Vô Cực (Rực Rỡ)',
                'TFT5_Item_GiantSlayerRadiant': 'Giant Slayer (Rực Rỡ)',
                'TFT10_Item_DazzlerEmblem': 'Ấn Dazzler',
                'TFT10_Item_HyperPopEmblem': 'Ấn Hyperpop',
                'TFT10_Item_8bitEmblem': 'Ấn 8-bit',
                'TFT10_Item_WardenEmblem': 'Ấn Warden',
                'TFT10_Item_SpellweaverEmblem': 'Ấn Spellweaver',
                'TFT10_Item_EmoEmblem': 'Ấn Emo',
                'TFT10_Item_StreetDemonEmblem': 'Ấn Street Demon',
                'TFT10_Item_TechieEmblem': 'Ấn Techie',
                'TFT10_Item_SwiftEmblem': 'Ấn Swift',
                'TFT10_Item_MarksmanEmblem': 'Ấn Marksman',
                'TFT10_Item_KDAEmblem': 'Ấn K/DA',
                'TFT10_Item_SuperfanEmblem': 'Ấn Superfan',
                'TFT10_Item_GuardianEmblem': 'Ấn Guardian',
                'TFT10_Item_PunkEmblem': 'Ấn Punk',
                'TFT10_Item_FighterEmblem': 'Ấn Fighter',
                'TFT10_Item_BigShotEmblem': 'Ấn Big Shot',
                'TFT10_Item_CrowdDiverEmblem': 'Ấn Crowd Diver',
                'TFT10_Item_ThirstyEmblem': 'Ấn Thirsty'
            };

            // Combine all item translations
            const allItems = { ...commonItems, ...set14Items, ...set10Items };

            // Return translated name or clean version
            if (allItems[itemName]) {
                return allItems[itemName];
            }

            // Clean item name by removing prefixes and suffixes
            return itemName
                .replace(/TFT\d*_?Item_/, '')
                .replace(/Radiant$/, ' (RR)')
                .replace(/Emblem(Item)?$/, ' (Emblem)');
        }

        function getTraitStyleClass(style) {
            switch(style) {
                case 4: return 'bg-warning text-dark'; // Gold
                case 3: return 'bg-info text-white';   // Diamond
                case 2: return 'bg-success text-white'; // Silver
                case 1: return 'bg-primary text-white'; // Bronze
                default: return 'bg-light text-muted';  // Inactive
            }
        }

        function getRarityClass(rarity) {
            switch(rarity) {
                case 0: return 'bg-secondary'; // 1 cost
                case 1: return 'bg-success';   // 2 cost
                case 2: return 'bg-primary';   // 3 cost
                case 4: return 'bg-danger';    // 4 cost
                case 6: return 'bg-warning';   // 5 cost
                case 7: return 'bg-dark';      // Special
                default: return 'bg-secondary';
            }
        }

        function getPlacementBadge(placement) {
            const badges = {
                1: '<span class="badge bg-warning text-dark fs-6">🥇 #1</span>',
                2: '<span class="badge bg-secondary text-white fs-6">🥈 #2</span>',
                3: '<span class="badge bg-warning text-dark fs-6">🥉 #3</span>',
                4: '<span class="badge bg-success text-white fs-6">#4</span>',
                5: '<span class="badge bg-primary text-white fs-6">#5</span>',
                6: '<span class="badge bg-info text-white fs-6">#6</span>',
                7: '<span class="badge bg-danger text-white fs-6">#7</span>',
                8: '<span class="badge bg-dark text-white fs-6">#8</span>'
            };
            return badges[placement] || `<span class="badge bg-secondary">#${placement}</span>`;
        }

        function autoFillPlayerRankings(participants) {
            // Sort participants by placement
            const sortedParticipants = participants.sort((a, b) => a.placement - b.placement);

            // Get current player PUUIDs from the form
            const currentPlayerPuuids = [];
            const playerInputs = document.querySelectorAll('input[name="player_ids[]"]');

            playerInputs.forEach((input, index) => {
                if(input.value) {
                    // Find matching participant
                    const participant = sortedParticipants.find(p => p.puuid === input.value);
                    if(participant) {
                        // Find the corresponding rank input and score input
                        const row = input.closest('tr');
                        if(row) {
                            // Fill rank
                            const rankInput = row.querySelector('input[name*="player_rank"]');
                            if(rankInput) {
                                rankInput.value = participant.placement;
                            }

                            // Fill score (using missions.PlayerScore2 if available)
                            const scoreInput = row.querySelector('input[name*="player_score"]');
                            if(scoreInput && participant.missions && participant.missions.PlayerScore2) {
                                scoreInput.value = participant.missions.PlayerScore2;
                            }

                            // Fill result dropdown
                            const resultSelect = row.querySelector('select[name*="player_result"]');
                            if(resultSelect) {
                                let resultValue = '';
                                switch(participant.placement) {
                                    case 1: resultValue = '1st'; break;
                                    case 2: resultValue = '2nd'; break;
                                    case 3: resultValue = '3rd'; break;
                                    case 4: resultValue = 'top4'; break;
                                    default: resultValue = 'eliminated'; break;
                                }
                                resultSelect.value = resultValue;
                            }

                            // Check the checkbox for matched players
                            const checkbox = row.querySelector('.player-checkbox');
                            if(checkbox) {
                                checkbox.checked = true;
                            }
                        }
                    }
                }
            });

            // Update selected count
            updateSelectedCount();
        }

        function showMatchStatusNotification(matchedCount, totalPlayers, unmatchedCount) {
            // Remove any existing notifications
            const existingNotification = document.querySelector('.match-status-notification');
            if(existingNotification) {
                existingNotification.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'match-status-notification alert alert-dismissible fade show mt-3';

            if(matchedCount === totalPlayers && unmatchedCount === 0) {
                // Perfect match
                notification.className += ' alert-success';
                notification.innerHTML = `
                    <i class="bx bx-check-circle me-2"></i>
                    <strong>Hoàn hảo!</strong> Tất cả ${totalPlayers} người chơi đều khớp với dữ liệu trận đấu.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
            } else if(matchedCount > 0) {
                // Partial match
                notification.className += ' alert-warning';
                notification.innerHTML = `
                    <i class="bx bx-exclamation-triangle me-2"></i>
                    <strong>Khớp một phần:</strong> ${matchedCount}/${totalPlayers} người chơi khớp với dữ liệu.
                    ${unmatchedCount > 0 ? `Có ${unmatchedCount} người chơi khác trong trận đấu.` : ''}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
            } else {
                // No match
                notification.className += ' alert-danger';
                notification.innerHTML = `
                    <i class="bx bx-error-circle me-2"></i>
                    <strong>Không khớp:</strong> Không có người chơi nào trong danh sách khớp với trận đấu này.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
            }

            // Insert notification after the fightData container
            const fightDataContainer = document.querySelector('.fight-data-container');
            if(fightDataContainer) {
                fightDataContainer.appendChild(notification);
            }
        }

        function saveAsDraft() {
            if(confirm('Bạn có muốn lưu thông tin trận đấu hiện tại làm bản nháp?')) {
                // Add draft saving logic here
                alert('Đã lưu bản nháp thành công!');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedCount();
        });
