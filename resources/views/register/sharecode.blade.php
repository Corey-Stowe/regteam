@extends('layout.master')
@section('content')
    <div class="container">

        <div class="card mt-3">
            <div class="card-header">
                <h4>Tạo tổ đội thành công</h4>
            </div>
            <div class="card-body">
               <div class="mb-3">
                   <h5>Chia sẻ mã code hoặc copy url cho thành viên khác tham gia</h5>
                   <div class="hstack gap-3">
                    <input class="form-control me-auto" type="text" id="link" value="{{ route('join.invite', ['code' => $team->team_code]) }}" readonly>
                        <button class="btn btn-primary" onclick="copy()">Copy</button>
                </div>
                <div id="notification-text" class="mt-3">
                </div>
                   <p>Mã code nhóm của bạn: <strong>{{ $team->team_code }}</strong></p>
               </div>
            </div>
        </div>
    </div>
    <script>
        function copy(link){
            var copyText = document.getElementById("link");
            copyText.select();
            document.execCommand("copy");
            var notification = document.getElementById("notification-text");
            notification.innerHTML = '<div class="alert alert-success" role="alert">Đã copy link</div>';
        }
    </script>
@endsection
