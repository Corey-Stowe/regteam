@extends('layout.master')
@section('content')
<div class="container my-4">
    <div class="card shadow">
        <!-- Header -->
        <div class="card-header">
            <h3 class="mb-0">LUẬT THI ĐẤU LIÊN QUÂN MOBILE</h3>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- Phần 1: Dừng đấu -->
            <div class="mb-5">
                <h4 class=" mb-3">1. Quy định về dừng đấu</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="list-group">
                            <div class="list-group-item">
                                <h5 class="mb-2">Số lượt dừng đấu</h5>
                                <ul class="mb-0">
                                    <li>2 lượt/trận (tối đa 5 phút/lượt)</li>
                                </ul>
                            </div>
                            <div class="list-group-item">
                                <h5 class="mb-2">Mục đích sử dụng</h5>
                                <ul>
                                    <li>Phát hiện gian lận</li>
                                    <li>Sự cố kỹ thuật nghiêm trọng</li>
                                    <li>Thảo luận chiến thuật</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="alert alert-warning">
                            <h5>Xử phạt:</h5>
                            <ul class="mb-0">
                                <li>Dừng đấu vô cớ: +1 vé phạt</li>
                                <li>3 vé phạt: Cấm thi đấu + xử thua</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần 2: Thể thức thi đấu -->
            <div class="mb-5">
                <h4 class=" mb-3">2. Thể thức thi đấu</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                Final Match
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Thắng 3 điểm trước</li>
                                    <li>Hòa → OverTime</li>
                                    <li>Áp dụng: Vòng knock-out</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                Regular Match
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Thắng 2 điểm trước</li>
                                    <li>Áp dụng: Vòng bảng</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần 3: Thể thức đặc biệt -->
            <div class="mb-5">
                <h4 class=" mb-3">3. Thể thức đặc biệt</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">OverTime</div>
                            <div class="card-body">
                                <ul>
                                    <li>Áp dụng khi hòa</li>
                                    <li>Thắng 1 điểm đầu tiên</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Special Match</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Vòng</th>
                                                <th>Regular</th>
                                                <th>Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2</td>
                                                <td>10%</td>
                                                <td>10%</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>30%</td>
                                                <td>30%</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>50%</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>-</td>
                                                <td>50%</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>-</td>
                                                <td>70%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần 4: Điều kiện hoãn trận, xử thắng/thua & tái đấu -->
            <div class="mb-5">
                <h4 class=" mb-3">4. Điều kiện hoãn trận, xử thắng/thua & tái đấu</h4>
                <div class="accordion" id="accordionRules">
                    <!-- Gian lận -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Gian lận
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionRules">
                            <div class="accordion-body">
                                <ul>
                                    <li>Phát hiện trong trận: Đối phương thắng</li>
                                    <li>Phát hiện sau trận: Cần video gốc</li>
                                    <li>Tái đấu: Đồng ý của đối phương, không bao che</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- AFK -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                AFK/Thoát trận
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionRules">
                            <div class="accordion-body">
                                <ul>
                                    <li>AFK >50%: Tái đấu</li>
                                    <li>Cả hai đội AFK: +1 vé phạt</li>
                                    <li>Chia rẽ nội bộ: Xử thua ngay</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần 5: Trọng tài -->
            <div class="mb-5">
                <h4 class=" mb-3">5. Quy định về trọng tài</h4>
                <div class="alert alert-info">
                    <ul>
                        <li>Mỗi phòng có 1 trọng tài</li>
                        <li>Quay video toàn trận</li>
                        <li>Bao che gian lận: Cấm vĩnh viễn</li>
                    </ul>
                </div>
            </div>

            <!-- Phần 6: Nhận giải thưởng -->
            <div class="mb-5">
                <h4 class=" mb-3">6. Nhận giải thưởng</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Giải cá nhân ≥ 500,000 VND</div>
                            <div class="card-body">
                                <ul>
                                    <li>Chuyển thành giải nhóm</li>
                                    <li>Team Leader ≥16 tuổi, có CCCD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="card">
                            <div class="card-header">Giải cá nhân < 500,000 VND</div>
                            <div class="card-body">
                                <ul>
                                    <li>Nhận qua thẻ nạp QH</li>
                                    <li>Người ≥16 tuổi: Chuyển khoản</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer text-muted">
            <form class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreeRules">
                    <label class="form-check-label" for="agreeRules">
                        Tôi đã đọc và đồng ý với các điều khoản
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Xác nhận</button>
            </form>
        </div>
    </div>
</div>
@endsection
