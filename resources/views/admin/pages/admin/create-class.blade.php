@extends('admin.layouts.master')

@section('title', 'Tạo mới lớp học')

@section('content')
    <div class="container py-4">
        <!-- Tiêu đề và breadcrumb -->
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Lớp học - Tạo mới</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.class.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Form tạo mới lớp học -->
        <form method="POST" action="">
            @csrf
            <div class="row g-4">
                <!-- Thông tin chung -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin chung</h6>

                        <div class="mb-3">
                            <label for="course" class="form-label">Khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="course" name="course"
                                placeholder="Nhập tên khóa học...">
                            <small class="text-muted">Tổng số lớp sẽ được quản lý riêng hoặc tính dựa trên khóa này.</small>
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Năm học <span class="text-danger">*</span></label>
                            <select class="form-select" id="year" name="year">
                                <option value="" selected>Chọn năm học</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <!-- Có thể thêm năm khác -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admissions" class="form-label">Số sinh viên nhập học</label>
                            <input type="number" class="form-control" id="admissions" name="admissions" min="0"
                                placeholder="Nhập số sinh viên nhập học">
                        </div>

                        <div class="mb-3">
                            <label for="current_students" class="form-label">Số sinh viên hiện tại</label>
                            <input type="number" class="form-control" id="current_students" name="current_students"
                                min="0" placeholder="Nhập số sinh viên hiện tại">
                        </div>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Trạng thái</h6>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option selected disabled>-- Chọn trạng thái --</option>
                                <option value="hoat_dong">Hoạt động</option>
                                <option value="an">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút tạo -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Tạo
                </button>
            </div>
        </form>
    </div>
@endsection
