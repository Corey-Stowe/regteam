@extends('layout.master')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Đăng ký team mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('reg.create_team') }}" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="mb-3">
                        <label for="url">Tên tổ đội</label>
                        <input type="text" class="form-control" name="team_name" id="validationTooltip03"
                            placeholder="Tên tổ đội của bạn" required="" value="{{ old('team_name') }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập tên tổ đội.
                        </div>
                    </div>
                    <h4> Thông tin người đại diện </h4>
                    <div class="mb-3">
                        <label for="url">Họ Và Tên</label>
                        <input type="text" class="form-control" name="fullname" id="validationTooltip04"
                            placeholder="Họ Tên" required="">
                        <div class="invalid-feedback">
                            Vui lòng nhập Họ Và Tên
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url">Số Điện Thoại</label>
                        <input type="text" class="form-control" name="phonenumber" id="validationTooltip05"
                            placeholder="Số Điện Thoại" required="" value="{{ old('phonenumber') }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập Số Điện Thoại
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url">Ngày sinh</label>
                        <input type="date" class="form-control" name="DoB" id="validationTooltip06"
                            placeholder="Tên tổ đội của bạn" required="" value="{{ old('DoB') }}" >
                        <div class="invalid-feedback">
                            Vui lòng chọn ngày sinh
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url">Discord Username</label>
                        <input type="text" class="form-control" name="discordusername" id="validationTooltip07"
                            placeholder="Discord username" readonly value="{{ Auth::user()->discord_username }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập discord username
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url">Email</label>
                        <input type="text" class="form-control" name="email" id="validationTooltip08"
                            placeholder="Discord username" readonly value="{{ Auth::user()->email }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập Email
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url">Discord UID</label>
                        <input type="text" class="form-control" name="UID" id="validationTooltip09"
                            placeholder="Discord UID" readonly value="{{ Auth::user()->discord_id }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập Discord UID
                        </div>
                    </div>
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

                    <button type="submit" class="btn btn-primary mt-3">Đăng ký tổ đội mới</button>
                </form>

            </div>
        </div>
    @endsection
