@extends('admin.layouts.master')

@section('title', 'Form khảo sát')

@section('content')
    <div class="container py-4">
        <!-- Tiêu đề và breadcrumb -->
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Đợt khảo sát việc làm - Chỉnh sửa</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="#">Đợt khảo sát việc làm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-2">
                <a href="{{ route('admin.survey.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <a href="{{ route('admin.survey.form-survey') }}" class="btn btn-success">
                    <i class="bi bi-eye me-1"></i> Xem chi tiết Form
                </a>
            </div>
        </div>

        <!-- Form -->
        <form>
            <div class="row g-4">
                <!-- Khối trái -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin chung</h6>

                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Nhập tiêu đề khảo sát">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="Nhập mô tả chi tiết đợt khảo sát..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Thời gian bắt đầu khảo sát <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Thời gian kết thúc khảo sát <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Năm tốt nghiệp <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="Nhập năm tốt nghiệp">
                        </div>

                        <hr>

                        

                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Trạng thái</h6>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select">
                                <option selected disabled>-- Chọn trạng thái --</option>
                                <option value="hoat_dong">Hoạt động</option>
                                <option value="an">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút cập nhật -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
@endsection
