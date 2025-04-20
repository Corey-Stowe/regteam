@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin Lịch đấu</h4>
                    <p><strong>Thời gian bắt đầu:</strong> {{ $calendar_data->team_fight_date }}</p>
                    @if ($calendar_data->team_fight_status == "scheduled")
                    <span class="badge badge-soft-warning">Đã Lên lịch</span>
                @elseif ($calendar_data->team_fight_status == "ongoing")
                    <span class="badge badge-soft-primary">đang thi đấu</span>
                @elseif ($calendar_data->team_fight_status == "done")
                    <span class="badge badge-soft-success">Hoàn thành</span>
                @else
                    <span class="badge badge-soft-danger">Hủy bỏ</span>
                @endif
                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title>">Đội nhà</h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Tên đội: </strong>{{ $self->team_name }} </p>
                                    <p><strong>Mã nhóm:</strong> {{ $self->team_code }}</p>
                                    <p>
                                        @if ($self->visibility == 1)
                                            <strong>Hiển thị:</strong> <span class="badge badge-soft-success">Công
                                                Khai</span>
                                        @else
                                            <strong>Hiển Thị:</strong> <span class="badge badge-soft-danger">Riêng tư</span>
                                        @endif
                                    </p>
                                    <p><strong>Trạng thái nhóm:</strong>
                                        @if ($self->team_status == 'full')
                                            <span class="badge badge-soft-primary">Đủ điều kiện</span>
                                        @elseif($self->team_status == 'approved')
                                            <span class="badge badge-soft-success">Đang hoạt động</span>
                                        @elseif($self->team_status == 'elimated')
                                            <span class="badge badge-soft-danger">Bị loại</span>
                                        @elseif($self->team_status == 'pending')
                                            <span class="badge badge-soft-primary">Đang tìm đồng đội</span>
                                        @else
                                            <span class="badge badge-soft-danger">Không đủ điều kiện</span>
                                        @endif
                                        @if (isset($self->team_desc))
                                            <p><strong>Admin ghi chú:</strong>
                                            <p class="text-danger"> {{ $self->team_desc }}</p>
                                    </p>
                                    @endif
                                    <p><strong>Thời gian tạo:</strong> {{ $self->created_at }}</p>

                                </div>
                            </div>


                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title>">Đội Đối đầu</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <p><strong>Tên đội:</strong> {{ $opponent->team_name }} </p>
                                        <p><strong>Mã nhóm:</strong> {{ $opponent->team_code }}</p>
                                        <p>
                                            @if ($opponent->visibility == 1)
                                                <strong>Hiển thị:</strong> <span class="badge badge-soft-success">Công
                                                    Khai</span>
                                            @else
                                                <strong>Hiển Thị:</strong> <span class="badge badge-soft-danger">Riêng
                                                    tư</span>
                                            @endif
                                        </p>
                                        <p><strong>Trạng thái nhóm:</strong>
                                            @if ($opponent->team_status == 'full')
                                                <span class="badge badge-soft-primary">Đủ điều kiện</span>
                                            @elseif($opponent->team_status == 'approved')
                                                <span class="badge badge-soft-success">Đang hoạt động</span>
                                            @elseif($opponent->team_status == 'elimated')
                                                <span class="badge badge-soft-danger">Bị loại</span>
                                            @elseif($opponent->team_status == 'pending')
                                                <span class="badge badge-soft-primary">Đang tìm đồng đội</span>
                                            @else
                                                <span class="badge badge-soft-danger">Không đủ điều kiện</span>
                                            @endif
                                            @if (isset($opponent->team_desc))
                                                <p><strong>Admin ghi chú:</strong>
                                                <p class="text-danger"> {{ $self->team_desc }}</p>
                                        </p>
                                        @endif
                                        <p><strong>Thời gian tạo:</strong> {{ $opponent->created_at }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Chi tiết lịch đấu</h4>
                                <!--  Modal trigger button  -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalId1">
                                        Chỉnh sửa lịch đấu
                                </button>

                                <!-- Modal Body-->
                                <div class="modal fade" id="modalId1" tabindex="-1" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitleId">
                                                    Chỉnh sửa lịch thi đấu
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.updateCalendar') }}"
                                                    method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="Team Win">Team dành chiến thắng</label>
                                                    <select class="form-select" name="team_id" id="penalty">
                                                        <option value="0" selected>Chọn</option>
                                                        <option value="{{ $self->team_code }}">{{ $self->team_name }}</option>
                                                        <option value="{{ $opponent->team_code }}">{{ $opponent->team_name }} </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="score">Trạng thái</label>
                                                    <select class="form-select" name="team_fight_status" id="score">

                                                        <option value="scheduled" selected>Đã lên lịch</option>
                                                        <option value="ongoing">Đang thi đấu</option>
                                                        <option value="done">Hoàn thành</option>
                                                        <option value="canceled">Hủy bỏ</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="calendar_id" value="{{ $calendar_data->id }}">
                                                <div class="mb-3">
                                                    <label for="date">Thay đổi lịch thi đấu</label>
                                                    <input type="date" class="form-control" name="team_fight_date"
                                                        id="date" value="{{ $calendar_data->team_fight_date }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="time">Ghi chú thi đấu</label>
                                                    <textarea class="form-control" name="team_fight_note" id="note"
                                                        rows="3">{{ $calendar_data->team_fight_note }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                                                </form>
                                                <a href="{{ route('admin.deleteCalendar', $calendar_data->id) }}"
                                                    class="btn btn-danger">Xóa lịch đấu</a>
                                            </div>
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lịch sử xử phạt</h4>
                    <!-- Modal trigger button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId">
                        Thêm xử phạt
                    </button>

                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Thêm xử phạt
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.addStrike') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="penalty">Nhóm xử phạt</label>
                                            <select class="form-select" name="team_id" id="penalty">
                                                <option value="{{ $self->team_code }}">{{ $self->team_name }}</option>
                                                <option value="{{ $opponent->team_code }}">{{ $opponent->team_name }}
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reason">Lý do</label>
                                            <input type="text" class="form-control" name="strike_reason"
                                                id="reason">
                                        </div>
                                        <div class="mb-3">
                                            <label for="penalty">Ghi chú</label>
                                            <textarea class="form-control" name="strike_note" id="note" rows="3"></textarea>
                                        </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Đóng
                                    </button>
                                    <button type="submit" class="btn btn-primary">Thêm xử phạt</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Optional: Place to the bottom of scripts -->


                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title>">Đội nhà</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Lý do xử phạt</th>
                                                <th>Ghi chú</th>
                                                <th>Ngày tạo</th>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($strike_data_self))
                                                <tr>
                                                    <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa có xử
                                                        phạt nào</td>
                                                </tr>
                                            @else
                                                @foreach ($strike_data_self as $key => $strikes)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $strikes->strike_reason }}</td>
                                                        <td>{{ $strikes->strike_note }}</td>
                                                        <td>{{ $strikes->date_created }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.deleteStrike', ['id' => $strikes->team_id]) }}" class="btn btn-danger">Gỡ xử phạt</a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>


                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title>">Đội Đối đầu</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Lý do xử phạt</th>
                                                <th>Ghi chú</th>
                                                <th>Ngày tạo</th>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (empty($strike_data_opponent))
                                                <tr>
                                                    <td colspan="4" class="text-center">Rất tốt, đội của bạn chưa có xử
                                                        phạt nào</td>
                                                </tr>
                                            @else
                                                @foreach ($strike_data_opponent as $key => $strikes)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $strikes->strike_reason }}</td>
                                                        <td>{{ $strikes->strike_note }}</td>
                                                        <td>{{ $strikes->created_at}}</td>
                                                        <td>
                                                            <a href="{{ route('admin.deleteStrike', ['id' => $strikes->team_id]) }}" class="btn btn-danger">Gỡ xử phạt</a>
                                                        </td>

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
@endsection
