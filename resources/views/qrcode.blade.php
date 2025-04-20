@extends('layout.master')
@section('content')
    <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}"></script>
    <div class="container">
        <div class="row">

            <div class="card mt-3">
                <div class="card-header">
                    <h4>Donate giải</h4>
                    <h6 class="card-subtitle text-muted"><a href="{{ route('selecthub') }}"> <i
                                class="bx bx-left-arrow-alt"></i> Quay trở về trang chủ </a></h6>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <img src="https://img.vietqr.io/image/MB-25565161104-compact.png" id="qr-result__img"
                                alt="QR Code image" class="img-fluid mx-auto">
                            <h5 class="ms-2">Vui lòng đọc điều khoản về donate trước khi thực hiên giao dịch !<h5>
                        </div>
                        <div class="col-lg-5 mt-3">
                            <h5>Thông tin donate</h5>
                            <p>Để donate giải, hãy scan mã QR bên cạnh hoặc chuyển khoản qua số tài khoản dưới đây</p>
                            <p>Số tài khoản: 25565161104</p>
                            <p>Chủ tài khoản: PHAM THE BAO</p>
                            <p>Ngân hàng: MB Bank</p>
                            <p>Nội dung: <strong>{{ Auth::user()->discord_username }} Donate giai</strong></p>
                            <p>Sau khi donate hệ thống sẽ ghi lại trên lịch sử donate trong 24 - 48h</p>
                            <p class="text-danger">Lưu ý: Nếu thông tin QR bị sai vui lòng không được thực hiên CK, Sau khi
                                CK vui lòng chụp lại màn hình và gửi trong server discord !</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Chính sách & điều khoản</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tos">Nội quy và chính sách đóng góp giải</label>
                        <textarea id="tos" class="form-control" rows="20" readonly>
NỘI QUY VÀ CHÍNH SÁCH ĐÓNG GÓP GIẢI THƯỞNG

1. Mục đích đóng góp
- Khoản tiền đóng góp sẽ được sử dụng vào mục đích trao giải thưởng trong các sự kiện, giải đấu hoặc hoạt động được tổ chức bởi cộng đồng Liên Quân Mobile.
- Đóng góp mang tính tự nguyện, không ép buộc, và nhằm xây dựng một cộng đồng phát triển, công bằng và lành mạnh.

2. Quản lý tài chính minh bạch
- Mọi khoản đóng góp sẽ được ghi nhận và sao kê rõ ràng, bao gồm:
  + Số tiền đóng góp.
  + Thời gian đóng góp.
  + Người đóng góp (công khai nếu có sự đồng ý).
- Sao kê tài chính sẽ được công khai định kỳ (hàng tháng hoặc sau mỗi sự kiện) để đảm bảo tính minh bạch.

3. Lịch sử đóng góp
- Danh sách lịch sử đóng góp sẽ được lưu trữ bao gồm:
  + Thông tin người đóng góp (nếu công khai).
  + Mục đích sử dụng khoản đóng góp.
  + Tình trạng giải ngân cho các hoạt động trao giải.
- Người đóng góp có thể yêu cầu kiểm tra lịch sử giao dịch liên quan đến khoản đóng góp của mình.

4. Sử dụng khoản tiền đóng góp
- Toàn bộ khoản đóng góp sẽ được sử dụng cho các mục đích sau:
  + Trao giải thưởng cho người chơi trong các sự kiện/giải đấu.
  + Tổ chức các hoạt động cộng đồng nhằm nâng cao trải nghiệm của người chơi.
  + Duy trì và phát triển các hoạt động hỗ trợ cộng đồng.
- Không sử dụng khoản đóng góp vào các mục đích cá nhân hoặc không liên quan.

5. Quyền lợi của người đóng góp
- Người đóng góp sẽ nhận được sự ghi nhận từ ban tổ chức thông qua:
  + Công khai danh tính (nếu được sự đồng ý).
  + Cảm ơn trên các kênh truyền thông chính thức của cộng đồng.
- Được ưu tiên tham gia hoặc nhận phần thưởng từ các sự kiện đặc biệt (nếu có).

6. Chính sách hoàn trả
- Khoản đóng góp sẽ không được hoàn trả sau khi đã được sử dụng hoặc chuyển vào quỹ cộng đồng.
- Trong trường hợp sự kiện bị hủy hoặc thay đổi, ban tổ chức sẽ thông báo và có thể cân nhắc hoàn trả hoặc chuyển khoản đóng góp vào sự kiện tiếp theo.

7. Khiếu nại và hỗ trợ
- Người đóng góp có quyền yêu cầu giải trình về việc sử dụng khoản tiền đóng góp thông qua kênh hỗ trợ chính thức.
- Ban tổ chức cam kết trả lời các thắc mắc và khiếu nại trong thời gian sớm nhất (tối đa 7 ngày làm việc).

8. Cam kết của ban tổ chức
- Đảm bảo tính minh bạch và công khai trong quản lý tài chính.
- Sử dụng nguồn đóng góp đúng mục đích và vì lợi ích của cộng đồng.
- Tạo dựng lòng tin và sự ủng hộ của người chơi, góp phần xây dựng một môi trường cạnh tranh lành mạnh, phát triển bền vững.

</textarea>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Lịch sử giao dịch</h4>
                    <p class="card-subtitle text-muted">Tổng số tiền đã donate là:  {{ number_format($sum_donate, 0, ',', '.') }} VND</p>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Số Tiền</th>
                                    <th>Nội dung</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($donate_data as $money)
                                    <tr>
                                        <td>{{ number_format($money->amount, 0, ',', '.') }} VND</td>
                                        <td>{{ $money->trx_name }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    {{-- paginate --}}
                    {{-- <div class="card-footer">
                        {{ $donate_data->links('vendor.pagination.bootstrap-5') }}
                    </div> --}}
                    <div>
                    </div>
                </div>
                <!-- end card body -->
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ensure the container is empty
            const gridContainer = document.getElementById("table-gridjs");
            gridContainer.innerHTML = ''; // Clear any pre-existing content

            // Initialize the Grid.js table
            new gridjs.Grid({
                columns: ["STT", "Số tiền", "Nội dung", "Ghi chú"],
                pagination: {
                    limit: 5,
                },
                sort: true,
                search: true,
                data: [
                    ["1", "100.000 VND", "Số tiền cọc ban đầu", "Tiền Cọc"],
                ],
            }).render(gridContainer);
        });
    </script>
@endsection
