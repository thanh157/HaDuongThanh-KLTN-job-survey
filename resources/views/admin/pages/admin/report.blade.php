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
            {{-- <form method="GET" action="{{ route('admin.report.index') }}" class="ms-auto">
                <div class="d-flex align-items-center gap-2">
                    <label for="graduation_id" class="col-form-label fw-semibold mb-0">Đợt tốt nghiệp:</label>
                    <select name="graduation_id" id="graduation_id" class="form-select custom-select"
                        onchange="this.form.submit()">
                        <option value="">-- Chọn đợt --</option>
                        @foreach ($graduationList as $graduation)
                            <option value="{{ $graduation['id'] }}"
                                {{ $selectedGraduationId == $graduation['id'] ? 'selected' : '' }}>
                                {{ $graduation['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form> --}}
        </ul>
<form method="GET" action="{{ route('admin.report.index') }}" class="row mb-3 g-3 align-items-end">
    <div class="col-md-4">
        <label for="graduation_id" class="form-label fw-semibold">Chọn đợt khảo sát:</label>
        <select name="graduation_id" id="graduation_id" class="form-select custom-select" onchange="this.form.submit()">
            <option value="">-- Tất cả các đợt --</option>
            @foreach ($graduationList as $graduation)
                <option value="{{ $graduation['id'] }}" {{ $selectedGraduationId == $graduation['id'] ? 'selected' : '' }}>
                    {{ $graduation['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-auto">
        <label class="form-label d-block invisible">Tải xuống</label>
        <a href="{{ route('admin.report.export', ['graduation_id' => $selectedGraduationId]) }}" class="btn btn-success">
            <i class="bi bi-download"></i> Tải Excel
        </a>
    </div>
</form>

        <!-- Nội dung tab -->
        <div class="tab-content">

            <!-- Mẫu báo cáo 1 -->
            <div class="tab-pane fade show active" id="tab1">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem trước
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div> --}}

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
                                            {{-- <th rowspan="3">TT</th> --}}
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
                                        @forelse ($report1 as $key => $row)
                                            <tr>
                                                {{-- <td>{{ $key + 1 }}</td> --}}
                                                <td>{{ $row->training_industry_id }}</td>
                                                <td>{{ $row->ten_nganh }}</td>
                                                <td>{{ $row->sv_tot_nghiep ?? '-' }}</td>
                                                <td>{{ $row->sv_nu_tot_nghiep ?? '-' }}</td>
                                                <td>{{ $row->tong_phan_hoi ?? '-' }}</td>
                                                <td>{{ $row->nu_phan_hoi ?? '-' }}</td>
                                                <td>{{ $row->co_viec_lam ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_dung_nganh ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_lien_quan ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_khong_lien_quan ?? '-' }}</td>
                                                <td>{{ $row->tiep_tuc_hoc ?? '-' }}</td>
                                                {{-- <td>{{ $row->chua_co_viec ?? '-' }}</td> --}}
                                                <td>{{ $row->ty_le_co_viec_phan_hoi ?? '-' }}%</td>
                                                <td>{{ $row->ty_le_co_viec_tot_nghiep ?? '-' }}%</td>
                                                <td>{{ $row->lam_viec_nha_nuoc ?? '-' }}</td>
                                                <td>{{ $row->lam_viec_tu_nhan ?? '-' }}</td>
                                                <td>{{ $row->tu_tao_viec_lam ?? '-' }}</td>
                                                <td>{{ $row->yeu_to_nuoc_ngoai ?? '-' }}</td>
                                                <td>{{ $row->noi_lam_viec ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="20" class="text-center text-muted">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
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
                        {{-- <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem trước
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div> --}}

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
                                        @foreach ($report2 as $row)
                                            <tr>
                                                <td>{{ $row->stt }}</td>
                                                <td>{{ $row->student_code }}</td>
                                                <td>{{ $row->full_name }}</td>
                                                <td>{{ $row->gender }}</td>
                                                <td>{{ $row->citizen_id }}</td>
                                                <td>{{ $row->training_industry_code }}</td>
                                                <td>{{ $row->graduation_decision_number }}</td>
                                                <td>{{ $row->graduation_decision_date }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->survey_method }}</td>
                                                <td>{{ $row->has_response }}</td>
                                                <td>{{ $row->training_industry_name }}</td>
                                                <td>{{ $row->faculty_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <div class="mt-3">
                                    {{ $report2->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mẫu báo cáo 3 --}}
            <div class="tab-pane fade" id="tab3">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2"><i class="bi bi-eye"></i> Xem trước</a>
                            <a href="#" class="btn btn-success"><i class="bi bi-download"></i> Tải xuống báo
                                cáo</a>
                        </div> --}}

                        <div class="border rounded p-3" style="max-height: 800px; overflow: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-3">TÊN ĐƠN VỊ</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM 2021
                                    PHẢN HỒI VỀ TÌNH HÌNH VIỆC LÀM</h5>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered text-center align-middle mb-0"
                                    style="font-size: 13px; min-width: 3400px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th>TT</th>
                                            <th>Mã sinh viên</th>
                                            <th>Họ và tên</th>
                                            <th>Ngày sinh</th>
                                            <th>Giới tính</th>
                                            <th>Số CCCD</th>
                                            <th>Mã ngành</th>
                                            <th>Điện thoại</th>
                                            <th>Email</th>
                                            <th>Đúng ngành</th>
                                            <th>Liên quan</th>
                                            <th>Không liên quan</th>
                                            <th>Tiếp tục học</th>
                                            <th>Chưa có việc</th>
                                            <th>Nhà nước</th>
                                            <th>Tư nhân</th>
                                            <th>Nước ngoài</th>
                                            <th>Tự tạo</th>
                                            <th>Mã tỉnh</th>
                                            <th>
                                                < 3 tháng</th>
                                            <th>3-6</th>
                                            <th>6-12</th>
                                            <th>>12</th>
                                            <th>
                                                < 5tr</th>
                                            <th>5-10tr</th>
                                            <th>10-15tr</th>
                                            <th>>15tr</th>
                                            <th>Đã học</th>
                                            <th>Một phần</th>
                                            <th>Không học</th>
                                            <th>Trường GT</th>
                                            <th>Bạn bè</th>
                                            <th>Tự tìm</th>
                                            <th>Tự tạo</th>
                                            <th>Khác</th>
                                            {{-- Thêm các cột tiếp theo nếu cần --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report3 as $row)
                                            <tr>
                                                <td>{{ $row->stt }}</td>
                                                <td>{{ $row->student_code }}</td>
                                                <td>{{ $row->full_name }}</td>
                                                <td>{{ $row->dob }}</td>
                                                <td>{{ $row->gender }}</td>
                                                <td>{{ $row->citizen_id }}</td>
                                                <td>{{ $row->training_industry_code }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->employed_correct }}</td>
                                                <td>{{ $row->employed_related }}</td>
                                                <td>{{ $row->employed_irrelevant }}</td>
                                                <td>{{ $row->continue_study }}</td>
                                                <td>{{ $row->unemployed }}</td>
                                                <td>{{ $row->state }}</td>
                                                <td>{{ $row->private }}</td>
                                                <td>{{ $row->foreign }}</td>
                                                <td>{{ $row->self_employed }}</td>
                                                <td>{{ $row->city_code }}</td>
                                                <td>{{ $row->under_3_months }}</td>
                                                <td>{{ $row->from_3_to_6 }}</td>
                                                <td>{{ $row->from_6_to_12 }}</td>
                                                <td>{{ $row->above_12_months }}</td>
                                                <td>{{ $row->under_5m }}</td>
                                                <td>{{ $row->from_5_to_10m }}</td>
                                                <td>{{ $row->from_10_to_15m }}</td>
                                                <td>{{ $row->above_15m }}</td>
                                                <td>{{ $row->learned_well }}</td>
                                                <td>{{ $row->partly_learned }}</td>
                                                <td>{{ $row->not_learned }}</td>
                                                <td>{{ $row->via_school }}</td>
                                                <td>{{ $row->via_friends }}</td>
                                                <td>{{ $row->self_find }}</td>
                                                <td>{{ $row->self_create }}</td>
                                                <td>{{ $row->others }}</td>
                                                {{-- Thêm các cột tiếp theo --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $report3->links('pagination::bootstrap-5') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
