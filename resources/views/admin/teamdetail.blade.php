@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin đội nhóm</h4>


                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-7">
                            <p><strong>Tên nhóm:</strong> {{ $team_info->team_name }}</p>
                            <p><strong>Mã nhóm:</strong> {{ $team_info->team_code }}</p>
                            <p><strong>Họ và Tên:</strong> {{ $team_info->team_leader_name }}</p>
                            <p><strong>Email:</strong> {{ $team_info->team_leader_email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $team_info->team_leader_phone }}</p>
                            <p>@if($team_info->visibility == 1) <strong>Hiển thị:</strong> <span class="badge badge-soft-success">Công Khai</span> @else <strong>Hiển Thị:</strong> <span class="badge badge-soft-danger">Riêng tư</span> @endif</p>
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
                                @if(isset($team_info->team_desc))
                                    <p><strong>Admin ghi chú:</strong><p class="text-danger"> {{ $team_info->team_desc }}</p></p>
                                @endif
                            <p><strong>Thời gian tạo:</strong> {{ $team_info->created_at }}</p>
                        </div>
                        <div class="col-sm-5">
                            <!-- Modal trigger button -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalId66">
                                Chỉnh sửa thông tin nhóm
                            </button>

                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="modalId66" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Chỉnh sửa thông tin nhóm
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.updateTeam') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="team_name" class="form-label">Tên nhóm</label>
                                                    <input type="text" class="form-control" name="team_name"
                                                        value="{{ $team_info->team_name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="public"
                                                            name="public" @if($team_info->visibility == 1) checked @endif>
                                                        <label class="form-check-label" for="customSwitchsizemd">Công khai nhóm</label>
                                                    </div>
                                                    <p class="text-muted">Nếu chọn công khai nhóm, mọi người có thể tìm thấy nhóm của bạn và tham gia, nhưng vẫn phải cần bạn duyệt thành viên đó</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="team_status" class="form-label">Trạng thái nhóm</label>
                                                    <select class="form-select" name="team_status">
                                                        <option value="full" @if($team_info->team_status == 'full') selected @endif>Đủ điều kiện</option>
                                                        <option value="approved" @if($team_info->team_status == 'approved') selected @endif>Đang hoạt động</option>
                                                        <option value="elimated" @if($team_info->team_status == 'elimated') selected @endif>Bị loại</option>
                                                        <option value="pending" @if($team_info->team_status == 'pending') selected @endif>Đang tìm đồng đội</option>
                                                        <option value="notenough" @if($team_info->team_status == 'notenough') selected @endif>Không đủ điều kiện</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="team_desc" class="form-label">Ghi chú</label>
                                                    <textarea class="form-control" name="team_desc"
                                                        rows="3">{{ $team_info->team_desc }}</textarea>
                                                </div>
                                                <input type="text" hidden name="team_id" value="{{ $team_info->team_code }}">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Đóng
                                            </button>
                                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                                        </div>
                                        </form>
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
                        <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true"
                            tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Thành Viên</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false"
                            tabindex="-1">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Lịch Thi đấu</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab" aria-selected="false"
                            tabindex="-1">
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
                                                    <th>Trạng thái</th>
                                                    <th>Hành động </th>
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
                                                        <td>
                                                            @if ($member->status == 'appected')
                                                                <span class="badge badge-soft-success">Đã duyệt</span>
                                                            @elseif($member->status == 'pending')
                                                                <span class="badge badge-soft-primary">Chờ duyệt</span>
                                                            @elseif($member->status == 'accepted')
                                                                <span class="badge badge-soft-success">Đã duyệt</span>
                                                            @else
                                                                <span class="badge badge-soft-danger">Từ chối</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($member->status == 'pending')
                                                                <form action="{{ route('leader.approve_member') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="text" hidden name="discord_id"
                                                                        value="{{ $member->discord_uid }}"></text>
                                                                    <input type="text" hidden name="team_id"
                                                                        value="{{ $team_info->team_code }}"></text>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Duyệt</button>
                                                                </form>
                                                            @endif
                                                            @if ($member->is_leader == 1)
                                                                <!-- Button trigger modal -->
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#modalId">
                                                                    Giải tán nhóm
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="modalId" tabindex="-1"
                                                                    role="dialog" aria-labelledby="modalTitleId"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="modalTitleId">
                                                                                    Giải tán nhóm
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="container-fluid">
                                                                                    <p class="text-danger"> <strong> Nếu
                                                                                            bạn giải tán nhóm, tất cả thành
                                                                                            viên sẽ bị loại khỏi nhóm
                                                                                        </strong></p>
                                                                                    <p class="text-danger"><strong>Bạn có
                                                                                            chắc chắn muốn giải tán nhóm
                                                                                            không?</strong></p>
                                                                                    <p class="text-danger"><strong>Hành
                                                                                            động này không thể hoàn
                                                                                            tác</strong></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-success"
                                                                                    data-bs-dismiss="modal">
                                                                                    Hủy bỏ
                                                                                </button>
                                                                                <form
                                                                                    action="{{ route('leader.delteam') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="text" hidden
                                                                                        name="team_id"
                                                                                        value="{{ $team_info->team_code }}">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Giải tán
                                                                                        nhóm</button>

                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#modalId1">
                                                                    Từ chối/loại thành viên
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="modalId1" tabindex="-1"
                                                                    role="dialog" aria-labelledby="modalTitleId"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="modalTitleId">
                                                                                    Loại thành viên
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="container-fluid">
                                                                                    <p class="text-danger">Bạn có chắc chắn
                                                                                        muốn loại trừ / từ chối thành viên
                                                                                        không</p>
                                                                                    <p class="text-danger">Hành động này
                                                                                        không thể hoàn tác</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-success"
                                                                                    data-bs-dismiss="modal">
                                                                                    Hủy bỏ
                                                                                </button>
                                                                                <form
                                                                                    action="{{ route('leader.delete_member') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="text" hidden
                                                                                        name="discord_id"
                                                                                        value="{{ $member->discord_uid }}">
                                                                                    <input type="text" hidden
                                                                                        name="team_id"
                                                                                        value="{{ $team_info->team_code }}">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">Loại trừ /
                                                                                        từ chối</button>

                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif



                                                        </td>
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
                                                @if (empty($team_strikes))
                                                    <tr>
                                                        <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa
                                                            có xử phạt nào</td>
                                                    </tr>
                                                @else
                                                    @foreach ($team_calendar as $key => $calendar)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $calendar->team_fight_date }}</td>
                                                            <td>{{ $calendar->team_name }}</td>
                                                            <td>{{ $calendar->team_fight_status }}</td>
                                                            <td>{{ $calendar->team_fight_note }}</td>

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
                                                @if (empty($team_strikes))
                                                    <tr>
                                                        <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa
                                                            có xử phạt nào</td>
                                                    </tr>
                                                @else
                                                    @foreach ($team_strikes as $key => $strikes)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $strikes->strike_reason }}</td>
                                                            <td>{{ $strikes->strike_note }}</td>
                                                            <td>{{ $strikes->date_created }}</td>

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
