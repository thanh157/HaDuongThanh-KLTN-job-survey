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
                                    style="font-size: 12px; min-width: 1500px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="2"><br>TT</th>
                                            <th rowspan="2"><br>Mã ngành<br><small>(Mã tuyển sinh)</small></th>
                                            <th rowspan="2"><br>Tên ngành đào tạo</th>
                                            <th rowspan="2"><br>Số SV tốt nghiệp</th>
                                            <th rowspan="2"><br>Số SV phản hồi</th>
                                            <th colspan="3"><br>Có việc làm</th>
                                            <th rowspan="2"><br>Tiếp tục học</th>
                                            <th rowspan="2"><br>Chưa có việc làm</th>
                                            <th rowspan="2"><br>Tỷ lệ việc làm / SV phản hồi</th>
                                            <th rowspan="2"><br>Tỷ lệ việc làm / SV tốt nghiệp</th>
                                            <th colspan="4"><br>Khu vực làm việc</th>
                                            <th rowspan="2"><br>Nơi làm việc<br>(Tỉnh/TP)</th>
                                        </tr>
                                        <tr>
                                            <th>Đúng ngành</th>
                                            <th>Liên quan ngành</th>
                                            <th>Không liên quan</th>
                                            <th>Nhà nước</th>
                                            <th>Tư nhân</th>
                                            <th>Tự tạo</th>
                                            <th>Nước ngoài</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>7480201</td>
                                            <td>Công nghệ thông tin</td>
                                            <td>100</td>
                                            <td>90</td>
                                            <td>50</td>
                                            <td>30</td>
                                            <td>5</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td>94.4%</td>
                                            <td>85%</td>
                                            <td>10</td>
                                            <td>60</td>
                                            <td>10</td>
                                            <td>5</td>
                                            <td>01</td>
                                        </tr>
                                        <!-- Thêm -->
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
                                    style="font-size: 13px; min-width: 1200px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th>TT</th>
                                            <th>Mã sinh viên</th>
                                            <th>Họ và tên</th>
                                            <th>Nữ</th>
                                            <th>Số CCCD/CMND</th>
                                            <th>Mã ngành đào tạo<br><small>(Theo mã tuyển sinh)</small></th>
                                            <th>Số QĐ TN</th>
                                            <th>Ngày ký QĐ</th>
                                            <th>Điện thoại</th>
                                            <th>Email</th>
                                            <th>Hình thức khảo sát</th>
                                            <th>Có phản hồi</th>
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
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 3 --}}
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
                                style="font-size: 13px; min-width: 2800px;">
                                <thead class="align-middle">
                                    <tr>
                                        <th rowspan="2">TT</th>
                                        <th rowspan="2">Mã sinh viên</th>
                                        <th rowspan="2">Họ và tên</th>
                                        <th rowspan="2">Ngày sinh</th>
                                        <th rowspan="2">Giới tính</th>
                                        <th rowspan="2">Số thẻ CCCD/CMND</th>
                                        <th rowspan="2">Mã ngành đào tạo<br><small>(theo mã tuyển sinh)</small></th>
                                        <th rowspan="2">Điện thoại</th>
                                        <th rowspan="2">Email</th>
                                        <th colspan="3">Tình hình việc làm</th>
                                        <th rowspan="2">Tiếp tục học</th>
                                        <th rowspan="2">Chưa có việc làm</th>
                                        <th colspan="4">Khu vực làm việc</th>
                                        <th rowspan="2">Nơi làm việc<br>(Mã tỉnh/TP)</th>
                                        <th colspan="4">Thời gian có việc sau TN</th>
                                        <th colspan="4">Thu nhập bình quân / tháng</th>
                                        <th colspan="3">Kiến thức, kỹ năng từ nhà trường</th>
                                        <th colspan="5">Hình thức tìm việc</th>
                                        <th colspan="5">Mức độ áp dụng kiến thức</th>
                                        <th colspan="5">Mức độ áp dụng kỹ năng</th>
                                        <th colspan="8">Kỹ năng mềm cần thiết</th>
                                        <th colspan="6">Khóa học bổ sung</th>
                                        <th colspan="6">Giải pháp nâng cao tỷ lệ việc làm đúng ngành</th>
                                    </tr>
                                    <tr>
                                        <th>Đúng ngành</th>
                                        <th>Liên quan ngành</th>
                                        <th>Không liên quan</th>
                                        <th>Nhà nước</th>
                                        <th>Tư nhân</th>
                                        <th>Tự tạo</th>
                                        <th>Nước ngoài</th>
                                        <th>
                                            <3 tháng</th>
                                        <th>3–6 tháng</th>
                                        <th>6–12 tháng</th>
                                        <th>>12 tháng</th>
                                        <th>
                                            <5 triệu</th>
                                        <th>5–10 triệu</th>
                                        <th>10–15 triệu</th>
                                        <th>>15 triệu</th>
                                        <th>Đã học được</th>
                                        <th>Một phần</th>
                                        <th>Không học</th>
                                        <th>Trường giới thiệu</th>
                                        <th>Bạn bè</th>
                                        <th>Tự tìm</th>
                                        <th>Tự tạo</th>
                                        <th>Khác</th>
                                        <th>Rất nhiều</th>
                                        <th>Tương đối</th>
                                        <th>Ít</th>
                                        <th>Rất ít</th>
                                        <th>Không</th>
                                        <th>Rất nhiều</th>
                                        <th>Tương đối</th>
                                        <th>Ít</th>
                                        <th>Rất ít</th>
                                        <th>Không</th>
                                        <th>Giao tiếp</th>
                                        <th>Thuyết trình</th>
                                        <th>Làm việc nhóm</th>
                                        <th>Viết báo cáo</th>
                                        <th>Lãnh đạo</th>
                                        <th>Tiếng Anh</th>
                                        <th>Tin học</th>
                                        <th>Khác</th>
                                        <th>Chuyên môn</th>
                                        <th>Kỹ năng nghề</th>
                                        <th>CNTT</th>
                                        <th>Ngoại ngữ</th>
                                        <th>Kỹ năng mềm</th>
                                        <th>Quản lý</th>
                                        <th>Nâng cao trình độ</th>
                                        <th>Giao lưu cựu SV</th>
                                        <th>Giao lưu nhà tuyển dụng</th>
                                        <th>Doanh nghiệp tham gia đào tạo</th>
                                        <th>Cập nhật CTĐT</th>
                                        <th>Thực hành cơ sở</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>581001</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>01/01/1999</td>
                                        <td>1</td>
                                        <td>123456789</td>
                                        <td>7620103</td>
                                        <td>0912345678</td>
                                        <td>vana@example.com</td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>01</td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                        <td>1</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <!-- Thêm dữ liệu tại đây -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
