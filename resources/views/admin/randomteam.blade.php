@extends('layout.master')
@section('content')
    <div class="container">
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
                                    <th>Đội đối đầu</th>
                                    <th>Chọn ngày thi đấu</th>
                                    <th> Xếp đội</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matches as $match)
                                    @if (is_array($match) && count($match) == 2)
                                        <!-- Hiển thị các cặp đấu -->
                                        <tr>
                                             <form action="{{ route('admin.addCalendar') }}" method="POST">
                                                @csrf
                                            @if(is_null($match[0]))
                                                <td>Không đủ đội</td>
                                            @else
                                            <td>{{ $match[0]->team_name }}</td>
                                            <input type="hidden" name="team_id_self" value="{{ $match[0]->team_code }}">
                                            @endif

                                            @if(is_null($match[1]))
                                            <td>Không đủ đội</td>
                                            @else
                                            <td>{{ $match[1]->team_name }}</td>
                                            <input type="hidden" name="team_id_opponent" value="{{ $match[1]->team_code }}">
                                            @endif

                                            <td>


                                                    <input type="datetime-local" name="team_fight_date">
                                            </td>
                                                    @if(is_null($match[0]) || is_null($match[1]))
                                                    <td>
                                                    <button type="submit" class="btn btn-primary disabled">Đội Lẻ</button>
                                                    </td>
                                                    @else
                                            <td>
                                                    <button type="submit" class="btn btn-primary">Xếp đội</button>
                                            </td>

                                                    @endif
                                                </form>

                                            <!-- Trường hợp không có cặp đấu hoặc không đủ đội -->
                                        @else
                                        No random team

                                        @endif
                                        </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>

                </div>
            </div>



        </div>
    </div>
@endsection
