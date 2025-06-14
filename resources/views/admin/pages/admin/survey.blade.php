@extends('admin.layouts.master')

@section('title', 'Đợt khảo sát')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Khảo sát - Đợt khảo sát</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Đợt khảo sát</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đợt khảo sát</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('admin.survey.create-survey') }}" class="btn btn-primary mt-2 mt-sm-0">
                    <i class="bi bi-plus-lg me-1"></i> Tạo mới
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-bordered">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Tên đợt khảo sát</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ten')"></i>
                                    <div id="filter-ten" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="ten_dot_khao_sat" class="form-control"
                                                placeholder="vd: PHIẾU KHẢO SÁT 1">
                                        </div>
                                    </div>
                                </form>
                            </th>
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Năm khảo sát</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-nam')"></i>
                                    <div id="filter-nam" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="nam_khao_sat" class="form-control"
                                                placeholder="vd: 2025">
                                        </div>
                                    </div>
                                </form>
                            </th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Trạng thái</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-trangthai')"></i>
                                    <div id="filter-trangthai"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select class="form-select" name="trang_thai">
                                            <option value="">Tất cả</option>
                                            <option value="hoat_dong">Hoạt động</option>
                                            <option value="an">Ẩn</option>
                                        </select>
                                    </div>
                                </form>
                            </th>
                            <th>Phản hồi</th>
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Ngày tạo</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ngay')"></i>
                                    <div id="filter-ngay"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select class="form-select" name="sap_xep">
                                            <option value="moi_nhat">Gần nhất</option>
                                            <option value="cu_nhat">Xa nhất</option>
                                        </select>
                                    </div>
                                </form>
                            </th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PHIẾU KHẢO SÁT 1</td>
                            <td>2025</td>
                            <td>18:00 20/10/2024</td>
                            <td>23:00 23/12/2025</td>
                            <td><span class="badge bg-success">HOẠT ĐỘNG</span></td>
                            <td>99 / 118</td>
                            <td>18:06 16/11/2024</td>
                            <td class="text-center d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.survey.form-edit-survey') }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Xóa"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" title="Sao chép đường dẫn"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                    data-link="https://yourdomain.com/survey/1"
                                    onclick="copySurveyLink(this)">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Xem thông tin sinh viên"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-lines-fill"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-success" title="Gửi biểu mẫu khảo sát qua mail"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                    onclick="sendSurveyByEmail(this)">
                                    <i class="bi bi-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>NCT - TEST</td>
                            <td>2025</td>
                            <td>23:59 15/11/2024</td>
                            <td>23:59 17/01/2025</td>
                            <td><span class="badge bg-success">HOẠT ĐỘNG</span></td>
                            <td>1 / 1</td>
                            <td>23:11 15/11/2024</td>
                            <td class="text-center d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.survey.form-edit-survey') }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Xóa"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" title="Sao chép đường dẫn"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                    data-link="https://yourdomain.com/survey/2"
                                    onclick="copySurveyLink(this)">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-outline-info" title="Xem thông tin sinh viên"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-lines-fill"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-success" title="Gửi biểu mẫu khảo sát qua mail"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                    onclick="sendSurveyByEmail(this)">
                                    <i class="bi bi-envelope"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end p-3">
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        function copySurveyLink(button) {
            const link = button.getAttribute('data-link') || '';
            if (!link) {
                alert('Không có đường dẫn để sao chép.');
                return;
            }
            navigator.clipboard.writeText(link).then(() => {
                alert('Đường dẫn khảo sát đã được sao chép!');
            }).catch(() => {
                alert('Sao chép thất bại, vui lòng thử lại.');
            });
        }

        function sendSurveyByEmail(button) {
            // Ví dụ đơn giản, bạn có thể hiện modal nhập email hoặc gọi API gửi mail
            alert('Chức năng gửi biểu mẫu khảo sát qua mail sẽ được phát triển sau.');
        }

        // Hàm toggleFilter nếu chưa có trong file bạn có thể thêm
        function toggleFilter(id) {
            const el = document.getElementById(id);
            if (el.style.display === 'block') {
                el.style.display = 'none';
            } else {
                el.style.display = 'block';
            }
        }
    </script>
@endsection
