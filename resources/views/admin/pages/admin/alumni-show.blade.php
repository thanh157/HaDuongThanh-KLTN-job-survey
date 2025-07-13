@extends('admin.layouts.master')

@section('title', 'Chi tiết khảo sát việc làm')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <h3 class="fw-bold text-primary">
                <i class="bi bi-mortarboard-fill me-2"></i>Thông tin khảo sát việc làm cựu sinh viên
            </h3>
            <p class="text-muted">Thông tin chi tiết được thu thập trong quá trình khảo sát sinh viên tốt nghiệp.</p>
        </div>

        <div class="card shadow-sm p-4">
            {{-- PHẦN 1: Thông tin cá nhân --}}
            <h5 class="text-secondary fw-bold mb-3">
                <i class="bi bi-person-badge-fill me-2"></i>Thông tin cá nhân
            </h5>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Họ tên:</strong> Phạm Thị Huyền</div>
                <div class="col-md-4"><strong>Giới tính:</strong> Nữ</div>
                <div class="col-md-4"><strong>Ngày sinh:</strong> 10/08/2001</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Mã SV:</strong> 648519</div>
                <div class="col-md-4"><strong>CCCD:</strong> 012345678912</div>
                <div class="col-md-4"><strong>Nơi cấp:</strong> Tuyên Quang (10/09/2018)</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Khóa:</strong> K65</div>
                <div class="col-md-4"><strong>Ngành:</strong> Công nghệ thông tin</div>
                <div class="col-md-4"><strong>Điện thoại:</strong> 0987654321</div>
            </div>
            <div class="mb-4"><strong>Email:</strong> 698519@sv.vnua.edu.vn</div>

            <hr>

            {{-- PHẦN 2: Việc làm hiện tại --}}
            <h5 class="text-secondary fw-bold mb-3">
                <i class="bi bi-briefcase-fill me-2"></i>Việc làm hiện tại
            </h5>
            <div class="row mb-3 align-items-center">
                <div class="col-md-2 text-center">
                    <img src="{{ asset('assets/admin/images/logo-abc.png') }}" alt="Công ty ABC"
                        class="img-fluid rounded-circle border shadow-sm" style="width:80px;">
                </div>
                <div class="col-md-10">
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Tên công ty:</strong> Công ty TNHH Phần mềm ABC Việt Nam</div>
                        <div class="col-md-6"><strong>Địa chỉ:</strong> Tầng 7, Tòa nhà TechnoSoft, Duy Tân, Cầu Giấy, Hà
                            Nội</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>Chức vụ:</strong> Lập trình viên Backend</div>
                        <div class="col-md-4"><strong>Khu vực:</strong> Doanh nghiệp tư nhân</div>
                        <div class="col-md-4"><strong>Thu nhập:</strong> 12 triệu VNĐ/tháng</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Thời gian có việc:</strong> Dưới 3 tháng sau tốt nghiệp</div>
                        <div class="col-md-6"><strong>Phù hợp ngành đào tạo:</strong> Có</div>
                    </div>
                    <div class="mb-2"><strong>Được nhà trường hỗ trợ:</strong> Có, qua các buổi định hướng nghề nghiệp
                    </div>
                </div>
            </div>

            <hr>

            {{-- PHẦN 3: Thông tin khảo sát --}}
            <h5 class="text-secondary fw-bold mb-3">
                <i class="bi bi-clipboard-check-fill me-2"></i>Thông tin khảo sát
            </h5>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Cách tìm việc:</strong> Tự tìm trên mạng, Tham gia ngày hội việc làm</div>
                <div class="col-md-6"><strong>Khóa học đã tham gia:</strong> Kỹ năng chuyên môn, Quản lý thời gian</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Áp dụng kiến thức:</strong> Tốt (Lập trình, phân tích yêu cầu)</div>
                <div class="col-md-6"><strong>Áp dụng kỹ năng:</strong> Vừa phải (Làm việc nhóm, viết tài liệu)</div>
            </div>
            <div class="mb-2">
                <strong>Kỹ năng mềm cần có:</strong> Giao tiếp chuyên nghiệp, Làm việc nhóm, Giải quyết vấn đề
            </div>
            <div class="mb-2">
                <strong>Giải pháp cải tiến đào tạo:</strong> Tăng cường thực hành dự án, Mời doanh nghiệp tham gia đánh giá
                sinh viên
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.student-info.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
@endsection
