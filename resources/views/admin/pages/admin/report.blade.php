@extends('admin.layouts.master')

@section('title', 'Báo cáo - Tổng hợp khảo sát việc làm')

@section('content')
    <div class="container py-4">
        <!-- Header cải tiến -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="mb-1 fw-bold">Báo cáo - Thống kê</h5>
                <nav style="--bs-breadcrumb-divider: '>'; font-size: 14px;">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Báo cáo - Thống kê</a></li>
                        <li class="breadcrumb-item active">Báo cáo tổng hợp</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab1">Mẫu báo cáo 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab2">Mẫu báo cáo 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab3">Mẫu báo cáo 3</a>
            </li>
        </ul>

        <!-- Nội dung tab -->
        <div class="tab-content">

            <!-- Mẫu báo cáo 1 -->
            <div class="tab-pane fade show active" id="tab1">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem trước
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow-y: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-1">TÊN ĐƠN VỊ ………………….</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    MẪU SỐ 01: BÁO CÁO TÌNH HÌNH VIỆC LÀM CỦA SINH VIÊN TỐT NGHIỆP NĂM 2021
                                </h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle"
                                    style="font-size: 12px; min-width: 2000px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="3"><br>TT</th>
                                            <th rowspan="3"><br>Mã ngành<br><small>(Ghi bằng số theo mã ngành tuyển
                                                    sinh)</small></th>
                                            <th rowspan="3"><br>Tên ngành đào tạo</th>
                                            <th colspan="2" rowspan="2">(4)<br>Số sinh viên tốt nghiệp</th>
                                            <th colspan="2" rowspan="2">(5)<br>Số sinh viên phản hồi</th>
                                            <th colspan="5"><br>Tình hình việc làm</th>
                                            <th rowspan="3"><br>Tỷ lệ có việc làm/ tổng số sinh viên phản hồi</th>
                                            <th rowspan="3"><br>Tỷ lệ có việc làm/ tổng số sinh viên tốt nghiệp</th>
                                            <th colspan="4" rowspan="2"><br>Khu vực làm việc</th>
                                            <th rowspan="3"><br>Nơi làm việc<br>(Tỉnh/TP)</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Có việc làm</th>
                                            <th rowspan="2"><br>Tiếp tục học</th>
                                            <th rowspan="2"><br>Chưa có việc làm</th>
                                        </tr>
                                        <tr>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th><br>Đúng ngành đào tạo</th>
                                            <th><br>Liên quan đến ngành đào tạo</th>
                                            <th><br>Không liên quan đến nghành đào tạo</th>
                                            <th><br>Nhà nước</th>
                                            <th><br>Tư nhân</th>
                                            <th><br>Tự tạo việc làm</th>
                                            <th><br>Có yếu tố nước ngoài</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>7480201</td>
                                            <td>Công nghệ thông tin</td>
                                            <td>100</td>
                                            <td>40</td>
                                            <td>90</td>
                                            <td>35</td>
                                            <td>50</td>
                                            <td>30</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>94.4%</td>
                                            <td>85%</td>
                                            <td>10</td>
                                            <td>60</td>
                                            <td>10</td>
                                            <td>5</td>
                                            <td>Hà Nội</td>
                                        </tr>
                                        <!-- Thêm dòng dữ liệu khác tại đây -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 2 --}}
            <div class="tab-pane fade" id="tab2">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem trước
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow-y: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-3">BAN QUẢN LÝ ĐÀO TẠO</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    MẪU SỐ 02: DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM 2021
                                </h5>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle mb-0"
                                    style="font-size: 13px; min-width: 1500px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="2">TT</th>
                                            <th rowspan="2">Mã sinh viên</th>
                                            <th rowspan="2">Họ và tên</th>
                                            <th rowspan="2">Nữ</th>
                                            <th rowspan="2">Số thẻ CCCD/CMND</th>
                                            <th rowspan="2">
                                                Mã ngành đào tạo<br>
                                                <small>(Ghi bằng số theo mã ngành tuyển sinh của Bộ Giáo dục và Đào
                                                    tạo)</small>
                                            </th>
                                            <th colspan="2">Quyết định tốt nghiệp</th>
                                            <th colspan="2">Thông tin liên hệ</th>
                                            <th rowspan="2">Hình thức khảo sát<br>(Online, điện thoại, email …)</th>
                                            <th rowspan="2">Có phản hồi</th>
                                            <th rowspan="2">Ngành</th>
                                            <th rowspan="2">Khoa</th>
                                        </tr>
                                        <tr>
                                            <th>Số Quyết định</th>
                                            <th>Ngày ký Quyết định</th>
                                            <th>Điện thoại</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>41</td>
                                            <td>581576</td>
                                            <td>Lê Thị Vân Anh</td>
                                            <td>1</td>
                                            <td>174733120</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                        <tr>
                                            <td>42</td>
                                            <td>581577</td>
                                            <td>Nguyễn Hồng Hạnh</td>
                                            <td>1</td>
                                            <td>174733121</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                        <tr>
                                            <td>43</td>
                                            <td>581578</td>
                                            <td>Ngô Thị Ngọc Hoa</td>
                                            <td>1</td>
                                            <td>174733122</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                        <tr>
                                            <td>44</td>
                                            <td>581579</td>
                                            <td>Ngô Trọng Huy</td>
                                            <td></td>
                                            <td>174733123</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                        <tr>
                                            <td>45</td>
                                            <td>596652</td>
                                            <td>Trần Quốc Khánh</td>
                                            <td></td>
                                            <td>174733124</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                        <tr>
                                            <td>46</td>
                                            <td>596653</td>
                                            <td>Nguyễn Mạnh Kiên</td>
                                            <td></td>
                                            <td>174733125</td>
                                            <td>7480201</td>
                                            <td>122/QĐ-HV</td>
                                            <td>08/01/2021</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Công nghệ thông tin</td>
                                            <td>Công nghệ Thông tin</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 3 --}}
            <div class="tab-pane fade" id="tab3">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem trước
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-3">TÊN ĐƠN VỊ</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM 2021 PHẢN HỒI VỀ TÌNH HÌNH VIỆC LÀM
                                </h5>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle mb-0"
                                    style="font-size: 13px; min-width: 3400px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="3">TT</th>
                                            <th rowspan="3">Mã sinh viên</th>
                                            <th rowspan="3">Họ và tên</th>
                                            <th rowspan="3">Ngày sinh</th>
                                            <th rowspan="3">Giới tính</th>
                                            <th rowspan="3">Số thẻ CCCD/CMND</th>
                                            <th rowspan="3">Mã ngành đào tạo<br><small>(Ghi bằng số theo mã ngành tuyển
                                                    sinh)</small></th>
                                            <th rowspan="3">Điện thoại</th>
                                            <th rowspan="3">Email</th>
                                            <th colspan="5">Tình hình việc làm</th>
                                            <th colspan="4">Khu vực làm việc</th>
                                            <th rowspan="3">Nơi làm việc (Tỉnh/ Tp)<br>Ghi bằng mã số tỉnh</th>
                                            <th colspan="4">Thời gian có việc làm sau tốt nghiệp</th>
                                            <th colspan="4">Thu nhập bình quân/1 tháng</th>
                                            <th colspan="3">Kiến thức, kỹ năng từ nhà trường</th>
                                            <th colspan="5">Hình thức tìm việc làm</th>
                                            <th colspan="5">Mức độ áp dụng kiến thức</th>
                                            <th colspan="5">Mức độ áp dụng kỹ năng</th>
                                            <th colspan="8">Kỹ năng mềm cần thiết cho công việc</th>
                                            <th colspan="7">Khóa học đã tham gia sau khi tốt nghiệp</th>
                                            <th colspan="6">Giải pháp nâng cao tỷ lệ việc làm đúng ngành đào tạo</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Có việc làm</th>
                                            <th rowspan="2">Tiếp tục học</th>
                                            <th rowspan="2">Chưa có việc làm</th>
                                            <th>Khu vực nhà nước</th>
                                            <th>Khu vực tư nhân</th>
                                            <th>Có yếu tố nước ngoài</th>
                                            <th>Tự tạo việc làm</th>
                                            <th>Dưới 3 tháng</th>
                                            <th>Từ 3 tháng đến 6 tháng</th>
                                            <th>Từ 6 tháng đến 12 tháng</th>
                                            <th>Trên 12 tháng</th>
                                            <th>Dưới 5 triệu đồng</th>
                                            <th>Từ 5 triệu đến 10 triệu đồng</th>
                                            <th>Từ trên 10 triệu đến 15 triệu đồng</th>
                                            <th>Trên 15 triệu đồng</th>
                                            <th>Đã học được</th>
                                            <th>Chỉ học được một phần</th>
                                            <th>Không học được</th>
                                            <th>Do Học viện/khoa giới thiệu</th>
                                            <th>Bạn bè, người quen giới thiệu</th>
                                            <th>Tự tìm việc làm</th>
                                            <th>Tự tạo việc làm</th>
                                            <th>Hình thức khác</th>
                                            <th>Áp dụng rất nhiều</th>
                                            <th>Áp dụng tương đối nhiều</th>
                                            <th>Áp dụng ít</th>
                                            <th>Áp dụng rất ít</th>
                                            <th>Không áp dụng</th>
                                            <th>Áp dụng rất nhiều</th>
                                            <th>Áp dụng tương đối nhiều</th>
                                            <th>Áp dụng ít</th>
                                            <th>Áp dụng rất ít</th>
                                            <th>Không áp dụng</th>
                                            <th>Kỹ năng giao tiếp</th>
                                            <th>Kỹ năng lãnh đạo</th>
                                            <th>Kỹ năng thuyết trình</th>
                                            <th>Kỹ năng Tiếng Anh</th>
                                            <th>Kỹ năng làm việc nhóm</th>
                                            <th>Kỹ năng tin học</th>
                                            <th>Kỹ năng viết báo cáo tài liệu</th>
                                            <th>Khác</th>
                                            <th>Nâng cao kiến thức chuyên môn</th>
                                            <th>Nâng cao kỹ năng chuyên môn nghiệp vụ</th>
                                            <th>Nâng cao về kỹ năng công nghệ thông tin</th>
                                            <th>Nâng cao kỹ năng ngoại ngữ</th>
                                            <th>Phát triển kỹ năng quản lý</th>
                                            <th>Tiếp tục học lên cao</th>
                                            <th>Khác</th>
                                            <th>Học viện tổ chức chương trình chia sẻ từ cựu sinh viên</th>
                                            <th>Học viện tổ chức trao đổi với nhà tuyển dụng</th>
                                            <th>Đơn vị tuyển dụng tham gia đào tạo</th>
                                            <th>Chương trình đào tạo được cập nhật</th>
                                            <th>Tăng cường thực hành tại cơ sở</th>
                                            <th>Khác</th>
                                        </tr>
                                        <tr>
                                            <th>Đúng ngành đào tạo</th>
                                            <th>Liên quan đến ngành đào tạo</th>
                                            <th>Không liên quan đến ngành đào tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>581001</td>
                                            <td>Nguyễn Văn A</td>
                                            <td>01/01/1999</td>
                                            <td>Nam</td>
                                            <td>123456789</td>
                                            <td>7620103</td>
                                            <td>0912345678</td>
                                            <td>vana@example.com</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>01</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
