@extends('admin.layouts.master')

@section('title', 'Báo cáo - Tổng hợp khảo sát việc làm')

@section('content')
    <style>
        .custom-select {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            min-width: 220px;
            font-weight: 500;
        }

        .custom-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .custom-select:hover {
            border-color: #0d6efd;
        }
    </style>
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
            <form method="GET" action="{{ route('admin.report.index') }}" class="ms-auto">
                <div class="d-flex align-items-center gap-2">
                    <label for="survey_id" class="col-form-label fw-semibold mb-0">Khảo sát:</label>
                    <select name="survey_id" id="survey_id" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">-- Chọn khảo sát --</option>
                        @php $surveyX = \App\Models\Survey::get(); @endphp
                        @foreach ($surveyX as $item)
                            <option value="{{ $item->id }}" {{ request('survey_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </ul>

        <!-- Nội dung tab -->
        <div class="tab-content">

            <!-- Mẫu báo cáo 1 -->
            <div class="tab-pane fade show active" id="tab1">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('admin.charts.index') }}" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem biểu đồ thống kê
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow-y: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-1">BAN QUẢN LÝ ĐÀO TẠO.</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    BÁO CÁO TÌNH HÌNH VIỆC LÀM CỦA SINH VIÊN TỐT NGHIỆP NĂM {{ $schoolYear }}
                                </h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle"
                                    style="font-size: 12px; min-width: 2000px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="3">TT</th>
                                            <th rowspan="3">Mã ngành<br><small>(Ghi bằng số theo mã ngành tuyển
                                                    sinh)</small></th>
                                            <th rowspan="3">Tên ngành đào tạo</th>
                                            <th colspan="2" rowspan="2">(4)<br>Số sinh viên tốt nghiệp</th>
                                            <th colspan="2" rowspan="2">(5)<br>Số sinh viên phản hồi</th>
                                            <th colspan="5">Tình hình việc làm</th>
                                            <th rowspan="3">Tỷ lệ có việc làm / phản hồi</th>
                                            <th rowspan="3">Tỷ lệ có việc làm / tốt nghiệp</th>
                                            <th colspan="4" rowspan="2">Khu vực làm việc</th>
                                            <th rowspan="3">Nơi làm việc<br>(Tỉnh/TP)</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Có việc làm</th>
                                            <th rowspan="2">Tiếp tục học</th>
                                            <th rowspan="2">Chưa có việc làm</th>
                                        </tr>
                                        <tr>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th>Đúng ngành</th>
                                            <th>Liên quan</th>
                                            <th>Không liên quan</th>
                                            <th>Nhà nước</th>
                                            <th>Tư nhân</th>
                                            <th>Tự tạo</th>
                                            <th>Nước ngoài</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ !empty($r1) ? $r1['total_student'] : '' }}</td>
                                            <td>{{ !empty($r1) ? $r1['total_nu'] : '' }}</td>
                                            <td>{{ !empty($r1) ? $r1['total_res'] : '' }}</td>
                                            <td>{{ !empty($r1) ? $r1['total_res_nu'] : '' }}</td>
                                            <td>{{ !empty($r1_trained_field) ? $r1_trained_field->dung_nganh : '' }}</td>
                                            <td>{{ !empty($r1_trained_field) ? $r1_trained_field->lien_quan : '' }}</td>
                                            <td>{{ !empty($r1_trained_field) ? $r1_trained_field->khong_lien_quan : '' }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>100%</td>
                                            <td>{{ !empty($r1) ? round(($r1['total_res'] / $r1['total_student']) * 100, 2) . '%' : '' }}
                                            </td>
                                            <td>{{ !empty($r1_work_area) ? $r1_work_area->nha_nuoc : '' }}</td>
                                            <td>{{ !empty($r1_work_area) ? $r1_work_area->tu_nhan : '' }}</td>
                                            <td>{{ !empty($r1_work_area) ? $r1_work_area->tu_tao : '' }}</td>
                                            <td>{{ !empty($r1_work_area) ? $r1_work_area->nuoc_ngoai : '' }}</td>
                                        </tr>
                                        {{--                                        @forelse ($report1 as $key => $row) --}}
                                        {{--                                            <tr> --}}
                                        {{--                                                <td>{{ $key + 1 }}</td> --}}
                                        {{--                                                <td>{{ $row->training_industry_id }}</td> --}}
                                        {{--                                                <td>{{ $row->ten_nganh }}</td> --}}
                                        {{--                                                <td>{{ $row->sv_tot_nghiep ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->sv_nu_tot_nghiep ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->tong_phan_hoi ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->nu_phan_hoi ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->co_viec_lam ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->viec_lam_dung_nganh ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->viec_lam_lien_quan ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->viec_lam_khong_lien_quan ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->tiep_tuc_hoc ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->chua_co_viec ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->ty_le_co_viec_phan_hoi ?? '-' }}%</td> --}}
                                        {{--                                                <td>{{ $row->ty_le_co_viec_tot_nghiep ?? '-' }}%</td> --}}
                                        {{--                                                <td>{{ $row->lam_viec_nha_nuoc ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->lam_viec_tu_nhan ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->tu_tao_viec_lam ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->yeu_to_nuoc_ngoai ?? '-' }}</td> --}}
                                        {{--                                                <td>{{ $row->noi_lam_viec ?? '-' }}</td> --}}
                                        {{--                                            </tr> --}}
                                        {{--                                        @empty --}}
                                        {{--                                            <tr> --}}
                                        {{--                                                <td colspan="20" class="text-center text-muted">Không có dữ liệu</td> --}}
                                        {{--                                            </tr> --}}
                                        {{--                                        @endforelse --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 2 tab2 --}}
            <div class="tab-pane fade" id="tab2">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('admin.charts.index') }}" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem biểu đồ thống kê
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
                                    DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM {{ $schoolYear }}
                                </h5>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle mb-0"
                                    style="font-size: 13px; min-width: 1500px;">
                                    <thead class="align-middle">
                                        <tr>
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
                                            <th rowspan="2">Khóa học</th>
                                        </tr>
                                        <tr>
                                            <th>Số Quyết định</th>
                                            <th>Ngày ký Quyết định</th>
                                            <th>Điện thoại</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentTab2 as $item)
                                            @php $res = \App\Models\EmploymentSurveyResponse::where('student_id', $item->id)->where('survey_period_id', $survey->id)->first(); @endphp
                                            <tr>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
                                                <td>{{ $item->citizen_identification }}</td>
                                                <td>
                                                    {{--                                                @php --}}
                                                    {{--                                                    $major = \App\Models\Major::query()->where('id', $item->training_industry_id)->first(); --}}
                                                    {{--                                                @endphp --}}
                                                    {{--                                                {{ $major->code  }} --}}
                                                </td>
                                                <td>
                                                    @php
                                                        $graduation = Illuminate\Support\Facades\DB::table(
                                                            'graduation_student',
                                                        )
                                                            ->join(
                                                                'graduation',
                                                                'graduation_student.graduation_id',
                                                                '=',
                                                                'graduation.id',
                                                            )
                                                            ->where('graduation_student.student_id', $item->id)
                                                            ->select('graduation.*')
                                                            ->first();
                                                    @endphp
                                                    {{ !empty($graduation) ? $graduation->certification : '' }}
                                                </td>
                                                <td>{{ !empty($graduation) ? date('d-m-Y', strtotime($graduation->certification_date)) : '' }}
                                                </td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td></td>
                                                <td>{{ !empty($res) ? 1 : 0 }}</td>
                                                <td>
                                                    {{--                                                {{ $major->name }} --}}
                                                </td>
                                                <td>
                                                    {{--                                                {{ $item->course }} --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($r2 as $item)
                                            <tr>
                                                <td>{{ $item->code_student }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
                                                <td>{{ $item->identification_card_number }}</td>
                                                <td>
                                                    @php
                                                        $major = \App\Models\Major::query()
                                                            ->where('id', $item->training_industry_id)
                                                            ->first();
                                                    @endphp
                                                    {{ $major->code }}
                                                </td>
                                                <td>
                                                    @php
                                                        $graduation = Illuminate\Support\Facades\DB::table(
                                                            'graduation_student',
                                                        )
                                                            ->join(
                                                                'graduation',
                                                                'graduation_student.graduation_id',
                                                                '=',
                                                                'graduation.id',
                                                            )
                                                            ->where('graduation_student.student_id', $item->student_id)
                                                            ->select('graduation.*')
                                                            ->first();
                                                    @endphp
                                                    {{ !empty($graduation) ? $graduation->certification : '' }}
                                                </td>
                                                <td>{{ !empty($graduation) ? date('d-m-Y', strtotime($graduation->certification_date)) : '' }}
                                                </td>
                                                <td>{{ $item->phone_number }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td></td>
                                                <td>1</td>
                                                <td>{{ $major->name }}</td>
                                                <td>{{ $item->course }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 3 tab3 --}}
            <div class="tab-pane fade" id="tab3">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('admin.charts.index') }}" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem biểu đồ thống kê
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-3">BAN QUẢN LÝ ĐÀO TẠO</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM {{ $schoolYear }} PHẢN HỒI VỀ TÌNH HÌNH VIỆC LÀM
                                </h5>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle mb-0"
                                    style="font-size: 13px; min-width: 3400px;">
                                    <thead class="align-middle">
                                        <tr>
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
                                            <th colspan="8">Kỹ năng mềm cần thiết cho công việc</th>
                                            <th colspan="7">Khóa học đã tham gia sau khi tốt nghiệp</th>
                                            <th colspan="7">Giải pháp nâng cao tỷ lệ việc làm đúng ngành đào tạo</th>
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
                                            {{--                                            <th>Áp dụng rất nhiều</th> --}}
                                            {{--                                            <th>Áp dụng tương đối nhiều</th> --}}
                                            {{--                                            <th>Áp dụng ít</th> --}}
                                            {{--                                            <th>Áp dụng rất ít</th> --}}
                                            {{--                                            <th>Không áp dụng</th> --}}
                                            {{--                                            <th>Áp dụng rất nhiều</th> --}}
                                            {{--                                            <th>Áp dụng tương đối nhiều</th> --}}
                                            {{--                                            <th>Áp dụng ít</th> --}}
                                            {{--                                            <th>Áp dụng rất ít</th> --}}
                                            {{--                                            <th>Không áp dụng</th> --}}
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
                                            <th>Học viện tổ chức các buổi trao đổi</th>
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
                                        @foreach ($r2 as $item)
                                            <tr>
                                                <td>{{ $item->code_student }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ !empty($item->dob) ? date('d-m-Y', strtotime($item->dob)) : '' }}
                                                </td>
                                                <td>{{ $item->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
                                                <td>{{ $item->identification_card_number }}</td>
                                                <td>
                                                    @php
                                                        $major = \App\Models\Major::query()
                                                            ->where('id', $item->training_industry_id)
                                                            ->first();
                                                    @endphp
                                                    {{ $major->code }}
                                                </td>
                                                <td>{{ $item->phone_number }}</td>
                                                <td>{{ $item->email }}</td>
                                                @foreach (config('config.trained_field') as $k => $trained_field)
                                                    <td>{{ $k == $item->trained_field ? 1 : 0 }}</td>
                                                @endforeach
                                                <td>0</td>
                                                <td>0</td>
                                                @foreach (config('config.work_area') as $k => $v)
                                                    <td>{{ $k == $item->work_area ? 1 : 0 }}</td>
                                                @endforeach
                                                <td>N/A</td>
                                                @foreach (config('config.employed_since') as $k => $v)
                                                    <td>{{ $k == $item->employed_since ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.average_income') as $k => $v)
                                                    <td>{{ $k == $item->average_income ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.level_knowledge_acquired') as $k => $v)
                                                    <td>{{ $k == $item->level_knowledge_acquired ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.recruitment_type') as $k => $v)
                                                    @php $data = json_decode($item->recruitment_type, true); @endphp
                                                    <td>{{ in_array($k, data_get($data, 'value')) ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.soft_skills_required') as $k => $v)
                                                    @php $data = json_decode($item->soft_skills_required, true); @endphp
                                                    <td>{{ in_array($k, data_get($data, 'value')) ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.must_attended_courses') as $k => $v)
                                                    @php $data = json_decode($item->must_attended_courses, true); @endphp
                                                    <td>{{ in_array($k, data_get($data, 'value')) ? 1 : 0 }}</td>
                                                @endforeach
                                                @foreach (config('config.solutions_get_job') as $k => $v)
                                                    @php $data = json_decode($item->solutions_get_job, true); @endphp
                                                    <td>{{ in_array($k, data_get($data, 'value')) ? 1 : 0 }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Khi click vào tab → lưu ID tab
            const tabLinks = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');
            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const targetId = this.getAttribute('href');
                    localStorage.setItem('activeTab', targetId);
                });
            });

            // Khi load lại → lấy tab đã lưu
            const lastTab = localStorage.getItem('activeTab');
            if (lastTab) {
                const triggerEl = document.querySelector(`.nav-link[href="${lastTab}"]`);
                if (triggerEl) {
                    const tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }
        });
    </script>

@endsection
