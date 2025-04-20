@extends('layout.master')
@section('content')
    <div class="container">

        <div class="card mt-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Tìm kiếm đồng đội</h4>
                        <h6 class="card-subtitle text-muted"><a href="{{ route('selecthub') }}"> <i class="bx bx-left-arrow-alt"></i> Quay trở về trang chủ </a></h6>
                    </div>
                    <div class="col-lg-6">
                       <form action="{{ route('join.search') }}" method="GET">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="team_name" placeholder="Nhập tên đội hoặc mã đội" value="{{ request()->input('team_name') }}">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
            </div>
            <div class="card-body">
                <div class="card">
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
                                    @if($team->visibility == 1)
                                    <tr>
                                        <td>{{ $team->team_name }}</td>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->team_members_count }}/5</td>
                                        <td>@if($team->team_members_count < 5) <span class="badge badge-soft-success">Còn chỗ</span> @else <span class="badge badge-soft-danger">Hết chỗ</span> @endif</td>
                                        <td>@if($team->visibility == 1) <span class="badge badge-soft-success">Công khai</span> @else <span class="badge badge-soft-danger">Riêng tư</span> @endif</td>
                                        <td>
                                            @if($team->team_members_count < 5 && $team->visibility == 1)
                                             <form action="{{ route('join.join_team_detail') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="team_code" value="{{ $team->team_code }}">
                                                <button type="submit" class="btn btn-primary">Tham gia</button>
                                            </form>
                                            @elseif ($team->team_members_count < 5 && $team->visibility == 0)
                                            <button class="btn btn-primary" disabled>Riêng tư</button>
                                            @else
                                            <button class="btn btn-primary" disabled>Hết chỗ</button>
                                            @endif


                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        {{-- paginate --}}
                        <div class="card-footer">
                            {{ $team_data->links('vendor.pagination.bootstrap-5') }}
                        </div>

                    </div>

                </div>
                <p class="text-danger">*Lưu ý: Vui lòng hỏi ý kiến các đội trưởng trước khi vào, bạn có thể nhập username để tìm kiếm trên discord nhé !</p>
            </div>
        </div>
    </div>
@endsection
