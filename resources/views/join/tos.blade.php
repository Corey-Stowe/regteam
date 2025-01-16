@extends('layout.master')
@section('content')

<div class="container">
    <div class="card mt-3">
        <div class="card-header">
            <h4>Xác nhận tham gia nhóm</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="url">Tên tổ đội</label>
                <input type="text" class="form-control" name="team_name" value="{{ $team_data->team_name }}">
            </div>
            <div class="mb-3">
                <label for="url">Quản lý bởi</label>
                <input type="text" class="form-control" name="team_name"  value="{{ $team_data->name }}">
            </div>
            {{-- <div class="mb-3">
                <label for="url">Mã nhóm</label>
                <input type="text" class="form-control" name="team_code"  value="{{ $team_data->team_code }}" readonly>
            </div> --}}
            <form class="needs-validation was-validated"  method="POST" action="{{ route('join.accept') }}">
                <input type="hidden" name="team_id" value="{{ $team_data->team_code }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->discord_id }}">
             @csrf
                <div class="mb-3">
                    <label for="tos">Nội quy tham gia</label>
                    <textarea id="tos" class="form-control" rows="15" readonly>
                NỘI QUY THAM TẠO ĐỘI & THAM GIA GIẢI ĐẤU

                1. Sự công bằng trong chơi game
                - Tuyệt đối không sử dụng phần mềm gian lận, hack hoặc các công cụ can thiệp trái phép vào trò chơi.
                - Không lợi dụng lỗi game để trục lợi hoặc gây ảnh hưởng đến trải nghiệm của người chơi khác.
                - Tôn trọng kết quả trận đấu, không cố tình thoát trận hoặc hành động tiêu cực ảnh hưởng đến đồng đội và đối thủ.

                2. Ứng xử khi thi đấu và ngoài thi đấu
                - Tôn trọng đồng đội và đối thủ trong mọi hoàn cảnh, kể cả khi thắng hay thua.
                - Không phá hoại trận đấu bằng cách cố tình feed, AFK, hoặc tranh cãi làm mất tinh thần đồng đội.
                - Trong các giải đấu hoặc sự kiện, tuân thủ quy định và chỉ đạo từ ban tổ chức.

                3. Phát ngôn và giao tiếp
                - Sử dụng ngôn từ lịch sự, không xúc phạm, công kích cá nhân hoặc có hành vi bắt nạt.
                - Không lan truyền thông tin sai lệch, nội dung phản cảm, bạo lực, hoặc kỳ thị dưới bất kỳ hình thức nào.
                - Tôn trọng ngôn ngữ và văn hóa của cộng đồng người chơi.

                4. Tuân thủ chính sách và quy định của nhà phát hành
                - Chấp hành các điều khoản sử dụng dịch vụ của nhà phát hành Liên Quân Mobile.
                - Không mua bán, trao đổi tài khoản trái phép hoặc sử dụng tài khoản của người khác mà không có sự đồng ý.

                5. Hỗ trợ và báo cáo vi phạm
                - Báo cáo các hành vi gian lận, vi phạm nội quy hoặc ảnh hưởng xấu đến cộng đồng trong Server Discord Furcity và Arena of Furry.
                - Hợp tác với ban tổ chức trong việc xử lý các vấn đề liên quan.

                6. Cam kết của người chơi
                - Khi tham gia sự kiện này, người chơi cam kết tuân thủ các quy định để xây dựng một cộng đồng chơi game văn minh, lành mạnh và bền vững.
                    </textarea>
                    <input class="form-check-input mt-3" type="radio" name="formRadios" id="formRadios1" required=""> Tôi đồng ý với nội quy tham gia
                    <div class="invalid-feedback">
                        Vui lòng đồng ý nội quy tham gia.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Gia nhập</button>
            </form>
        </div>


@endsection
