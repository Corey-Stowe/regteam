@extends('layout.master')
@section('content')
    <div class="container">
        <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}"></script>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3>Chỉnh sửa thời gian Vote</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vote.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="time_vote">Thời gian bắt đầu</label>
                            <input type="datetime-local" class="form-control" name="time_start_vote" id="time_vote" value="@if(!empty($vote_data)){{ $vote_data->start_date }}@endif">
                        </div>
                        <div class="form-group">
                            <label for="time_vote">Thời gian kết thúc</label>
                            <input type="datetime-local" class="form-control" name="time_end_vote" id="time_vote" value="@if(!empty($vote_data)){{ $vote_data->end_date }}@endif">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" value="@if(!empty($vote_data)){{ $vote_data->id }}@endif">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>

        </div>
        <div class="row">
          <div class="card">
            <div class="card-header">
                <h3>Dánh sách vote</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Vote Bởi</th>
                            <th>Pepapig</th>
                            <th>Vườn hoa đà lạt</th>
                            <th>Thời gian vote</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listVote as $list )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->team_pepapig }}</td>
                            <td>{{ $list->team_vuon_hoa }}</td>
                            <td>{{ $list->created_at }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
          </div>
        </div>
    </div>
 @endsection
