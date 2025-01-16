@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin đội nhóm</h4>
                    <h6 class="card-subtitle text-muted">Chỉ có quản lý nhóm mới hiện thông tin đầy đủ</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-7">
                            <p><strong>Tên nhóm:</strong> {{ $team_info->team_name }}</p>
                            <p><strong>Mã nhóm:</strong> {{ $team_info->team_code }}</p>
                            <p><strong>Nhóm trưởng:</strong> {{ $team_info->name }}</p>
                            <p><strong>Trạng thái nhóm:</strong>
                                @if ($team_info->team_status == 'full')
                                    <span class="badge badge-soft-primary">Đủ điều kiện</span>
                                @elseif($team_info->team_status == 'approved')
                                    <span class="badge badge-soft-success">Đang hoạt động</span>
                                @elseif($team_info->team_status == 'elimated')
                                    <span class="badge badge-soft-danger">Bị loại</span>
                                @elseif($team_info->team_status == 'pending')
                                    <span class="badge badge-soft-primary">Đang tìm đồng đội</span>
                                @else
                                    <span class="badge badge-soft-danger">Không đủ điều kiện</span>
                                @endif
                                @if ($team_members->count() < 5)
                                    <p class="text-danger"><strong>Nhóm của bạn chưa đủ thành viên sẽ dẫn tới không đủ điều
                                            kiện tham gia </strong></p>
                                @endif
                            <p><strong>Thời gian tạo:</strong> {{ $team_info->created_at }}</p>
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalId">
                                Rời nhóm
                             </button>
                             <!-- Modal -->
                             <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="modalTitleId">
                                                Rời nhóm
                                             </h5>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body">
                                             <div class="container-fluid">
                                                 <p class="text-danger"> <strong> Nếu bạn chọn giời nhóm, bạn vẫn có thể tham gia lại được nếu nhóm đó còn slot </strong></p>
                                                 <p class="text-danger"><strong>Hành động này không thể hoàn tác</strong></p>
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                                                 Hủy bỏ
                                             </button>
                                             <form action="{{ route('leader.leave_team') }}" method="POST">
                                                 @csrf
                                                 <input type="hidden" name="team_id" value="{{ $team_info->team_code }}">
                                                 <button type="submit" class="btn btn-danger">Rời nhóm</button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Thành Viên</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Lịch Thi đấu</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Xử Phạt</span>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Danh sách thành viên</h4>
                                <h6 class="card-subtitle text-muted">Danh sách thành viên trong nhóm</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Họ và Tên</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($team_members as $key => $member)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $member->name }} @if ($member->is_leader == 1)
                                                                <span class="badge badge-soft-primary">Nhóm trưởng</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $member->email }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="profile" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Lịch thi đấu sắp tới</h4>
                                <h6 class="card-subtitle text-muted">Lịch thi đấu</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Ngày thi đấu</th>
                                                    <th>Đội đối đầu</th>
                                                    <th>Trạng thái</th>
                                                    <th>Ghi chú</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tbody>
                                                    @if(empty($team_strikes))
                                                    <tr>
                                                        <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa có xử phạt nào</td>
                                                    </tr>
                                                    @else
                                                    @foreach ($team_calendar as $key => $calendar)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $calendar->team_fight_date }}</td>
                                                            <td>{{ $calendar->team_name}}</td>
                                                            <td>{{ $calendar->team_fight_status}}</td>
                                                            <td>{{ $calendar->team_fight_note}}</td>

                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="messages" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Lịch sử xử phạt</h4>
                                <h6 class="card-subtitle text-muted">Nếu nhóm bạn có xử phạt thì sẽ hiện ở dưới đây</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Lý do xử phạt</th>
                                                    <th>Ghi chú</th>
                                                    <th>Ngày tạo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(empty($team_strikes))
                                                <tr>
                                                    <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa có xử phạt nào</td>
                                                </tr>
                                                @else
                                                @foreach ($team_strikes as $key => $strikes)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $strikes->strike_reason }}</td>
                                                        <td>{{ $strikes->strike_note}}</td>
                                                        <td>{{ $strikes->date_created}}</td>

                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection
