@extends('layout.master')
@section('content')
    <div class="container">
        <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}"></script>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="font-size-15">Tổng Số Team đã đăng ký</h6>
                                <h4 class="mt-3 pt-1 mb-0 font-size-22">{{ $toal_team }} <span
                                        class="text-success fw-medium font-size-14 align-middle"> </h4>
                            </div>
                            <div class="">
                                <div class="avatar">
                                    <div class="avatar-title rounded bg-primary-subtle ">
                                        <i class="bx bx-store-alt font-size-24 mb-0 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="font-size-15">Tổng người dùng</h6>
                                <h4 class="mt-3 pt-1 mb-0 font-size-22">{{ $total_user }} </h4>
                            </div>
                            <div class="">
                                <div class="avatar">
                                    <div class="avatar-title rounded bg-primary-subtle ">
                                        <i class="bx bx-store-alt font-size-24 mb-0 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="font-size-15">Tổng Số Tiền Donate</h6>
                                <h4 class="mt-3 pt-1 mb-0 font-size-22">{{ number_format($sum_donate, 0, ',', '.') }} VND
                                </h4>
                            </div>
                            <div class="">
                                <div class="avatar">
                                    <div class="avatar-title rounded bg-primary-subtle ">
                                        <i class="bx bx-store-alt font-size-24 mb-0 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @if (Auth::user()->discord_id == 852599845071749240)
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>super_admin_container_find_user_v1</h4>
                        <div class="card-body">
                            <form action="{{ route('admin.findUser') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Tìm kiếm người dùng, userID" aria-label="Recipient's username"
                                        aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>super_admin_container_find_group_user</h4>
                        <div class="card-body">
                            <form action="{{ route('admin.findUserGroup') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Tìm kiếm người dùng, userID" aria-label="Recipient's username"
                                        aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4>super_admin_container_add_group</h4>
                            <div class="card-body">
                                <form action="{{ route('admin.joinGroup') }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="discord_uid" placeholder="User_ID"
                                            aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <input type="text" class="form-control" name="team_code" placeholder="Group_ID"
                                            aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-primary" type="submit" id="button-addon2">Thêm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

        @endif
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách đội</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Tên đội</th>
                                    <th>Đội trưởng</th>
                                    <th>Số người tham gia</th>
                                    <th>Trạng thái</th>
                                    <th>Truy cập</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($team_data as $team)
                                    <tr>
                                        <td>{{ $team->team_name }}</td>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->team_members_count }}/5</td>
                                        <td>
                                            @if ($team->team_members_count < 5)
                                                <span class="badge badge-soft-success">Còn chỗ</span>
                                            @else
                                                <span class="badge badge-soft-danger">Hết chỗ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($team->visibility == 1)
                                                <span class="badge badge-soft-success">Công khai</span>
                                            @else
                                                <span class="badge badge-soft-danger">Riêng tư</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.team_detail', ['team_id' => $team->team_code]) }}">
                                                <button type="button" class="btn btn-primary">Chi tiết</button></a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    {{-- paginate --}}
                    <div class="card-footer">
                        {{ $team_data->links('vendor.pagination.bootstrap-5') }}
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh sách đóng góp</h4>
                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">
                            Thêm mục mới
                        </button>

                        <!-- Modal Body -->
                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static"
                            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitleId">
                                            Thêm mới đóng góp
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('admin.add_donate') }}" id="form">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Số tiền</label>
                                                <input type="number" class="form-control" name="amount" id="amount"
                                                    aria-describedby="helpId" placeholder="Nhập số tiền">
                                                <small id="helpId" class="form-text text-muted">Nhập số tiền</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="trx_name" class="form-label">Nội dung</label>
                                                <input type="text" class="form-control" name="trx_name"
                                                    id="trx_name" aria-describedby="helpId" placeholder="Nhập nội dung">
                                                <small id="helpId" class="form-text text-muted">Nhập nội dung</small>
                                            </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Số Tiền</th>
                                        <th>Nội dung</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($donate_data as $money)
                                        <tr>
                                            <td>{{ number_format($money->amount, 0, ',', '.') }} VND</td>
                                            <td>{{ $money->trx_name }}</td>
                                            <td>
                                                <a href="{{ route('admin.delete_donate', ['id' => $money->id]) }}"
                                                    class="btn btn-danger">Xóa</a>

                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        {{-- paginate --}}

                    </div>
                </div>

                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lịch thi đấu sắp tới</h4>
                            <div class="row">
                                <div class="mb-4">
                                    <a type="button" class="btn btn-primary" href="{{ route('admin.randomTeam') }}">Xếp
                                        đội</a>
                                </div>
                                <div class="mb-4">
                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalId2">
                                        Thêm lịch đấu
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId2" tabindex="-1" data-bs-backdrop="static"
                                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Thêm lịch đấu
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.manualCalendar') }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="team1" class="form-label">Đội Chủ nhà</label>
                                                            <select class="form-select" name="team1" id="team1">
                                                                @foreach ($team_data as $team)
                                                                    <option value="{{ $team->team_code }}">
                                                                        {{ $team->team_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="team2" class="form-label">Đội Đối đầu</label>
                                                            <select class="form-select" name="team2" id="team2">
                                                                @foreach ($team_data as $team)
                                                                    <option value="{{ $team->team_code }}">
                                                                        {{ $team->team_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="team_fight_date" class="form-label">Ngày thi đấu</label>
                                                            <input type="date" class="form-control" name="team_fight_date"
                                                                id="team_fight_date" aria-describedby="helpId"
                                                                placeholder="Nhập ngày thi đấu">
                                                            <small id="helpId" class="form-text text-muted">Nhập ngày thi đấu</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="team_fight_status" class="form-label">Trạng thái</label>
                                                            <select class="form-select" name="team_fight_status" id="team_fight_status">
                                                                <option value="scheduled" selected>Đã Lên lịch</option>
                                                                <option value="ongoing">Đang thi đấu</option>
                                                                <option value="done">Hoàn thành</option>
                                                                <option value="cancel">Hủy bỏ</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="team_fight_note" class="form-label">ghi chú</label>
                                                            <input type="text" class="form-control" name="team_fight_note"
                                                                id="team_fight_note" aria-describedby="helpId"
                                                                placeholder="Nhập ghi chú">
                                                            <small id="helpId" class="form-text text-muted">Nhập ghi chú</small>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Optional: Place to the bottom of scripts -->


                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Đội Chủ nhà</th>
                                            <th>Đội Đối đầu</th>
                                            <th>Ngày thi đấu</th>
                                            <th>Trạng thái</th>
                                            <th>Kết quả</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($calendar_data as $team)
                                            <tr>
                                                <td>{{ $team->self_team_name }} ({{ $team->self_team_leader_name }})</td>
                                                <td>{{ $team->opponent_team_name }} ({{ $team->opponent_team_leader_name}})</td>
                                                <td>{{ $team->team_fight_date }}</td>
                                                <td>
                                                    @if ($team->team_fight_status == 'scheduled')
                                                        <span class="badge badge-soft-warning">Đã Lên lịch</span>
                                                    @elseif ($team->team_fight_status == 'ongoing')
                                                        <span class="badge badge-soft-primary">đang thi đấu</span>
                                                    @elseif ($team->team_fight_status == 'done')
                                                        <span class="badge badge-soft-success">Hoàn thành</span>
                                                    @else
                                                        <span class="badge badge-soft-danger">Hủy bỏ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($team->team_id_winner == 0)
                                                        Chưa có kết quả
                                                    @else
                                                        {{ $team->team_id_winner }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.editCalendar', ['id' => $team->id]) }}"> <button
                                                            type="button" class="btn btn-primary">Chi tiết</button></a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.MatchReport', ['id' => $team->id]) }}"> <button
                                                        type="button" class="btn btn-primary">Báo cáo</button></a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            {{-- paginate --}}

                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
