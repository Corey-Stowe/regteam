@extends('layout.master')
@section('content')

<?php
use Illuminate\Support\Facades\Auth;
use App\Models\TeamMember;
$team = new TeamMember();
$isHaveTeam = $team->hasJoinedTeam(Auth::user()->discord_id);
?>
    <div class="container">
        <h1 class="text-center mt-5">Chào mừng bạn đến với trang đăng ký tham gia giải đấu Fur City</h1>
        <div class="card mt-3">
            <div class="card-header">
                <h4>Vui lòng chọn hình thức tham gia</h4>
            </div>
            <div class="card-body">
                @if($isHaveTeam)
                <div class="row mt-5">
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card text-center position-relative">
                        <div class="card-body">
                            <i class="bx bx-user-circle" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-2">Đội của tôi</h5>
                            <p class="card-text">Quản lý tổ đội của bạn</p>
                            <a href="{{ route('leader.dashboard') }}" class="btn btn-primary ">Truy cập</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card text-center position-relative">
                        <div class="card-body">
                            <i class="bx bx-money" style="font-size: 2rem;"></i>
                            <h5 class="card-title mt-2">Đóng góp giải</h5>
                            <p class="card-text">Donate nâng mức hạn nhận giải</p>
                            <a href="{{ route('donate.donate') }}" class="btn btn-primary ">Donate</a>
                        </div>
                    </div>
                </div>
                </div>
                @else
                <div class="row mt-5">
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card text-center position-relative">
                            <div class="card-body">
                                <i class="bx bx-plus-circle" style="font-size: 2rem;"></i>
                                <h5 class="card-title mt-2">Tạo team Mới</h5>
                                <p class="card-text">Tạo một tổ đội mới</p>
                                <a href="{{ route('reg.new_team') }}" class="btn btn-primary ">Đăng ký</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card text-center position-relative">
                            <div class="card-body">
                                <i class="bx bx-user-plus" style="font-size: 2rem;"></i>
                                <h5 class="card-title mt-2">Vào một tổ đội có sẵn</h5>
                                <p class="card-text">Vào một tổ đội có sẵn</p>
                                <a href="{{ route('join.join_team') }}" class="btn btn-primary ">Gia nhập</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card text-center position-relative">
                            <div class="card-body">
                                <i class="bx bx-money" style="font-size: 2rem;"></i>
                                <h5 class="card-title mt-2">Gia nhập đội</h5>
                                <p class="card-text">Vào tổ đội đang chiêu mộ</p>
                                <a href="{{ route('join.listteam') }}" class="btn btn-primary ">Tìm đội ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card text-center position-relative">
                            <div class="card-body">
                                <i class="bx bx-money" style="font-size: 2rem;"></i>
                                <h5 class="card-title mt-2">Đóng góp giải</h5>
                                <p class="card-text">Donate nâng mức hạn nhận giải</p>
                                <a href="{{ route('donate.donate') }}" class="btn btn-primary ">Donate</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
