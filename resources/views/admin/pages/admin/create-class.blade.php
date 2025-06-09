@extends('admin.layouts.master')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tạo mới lớp học</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.class') }}">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.class') }}">Lớp học</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
                </ol>
            </nav>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('admin.class') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Form tạo mới lớp học -->
    <form method="POST" action="">
        @csrf

        <div class="mb-3">
            <label for="course" class="form-label">Khóa học</label>
            <input type="text" class="form-control" id="course" name="course" placeholder="Nhập tên khóa học...">
            <small class="text-muted">Tổng số lớp sẽ được quản lý riêng hoặc tính dựa trên khóa này.</small>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Năm học</label>
            <select class="form-select" id="year" name="year">
                <option value="" selected>Chọn năm học</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <!-- Có thể thêm năm khác -->
            </select>
        </div>

        <div class="mb-3">
            <label for="admissions" class="form-label">Số sinh viên nhập học</label>
            <input type="number" class="form-control" id="admissions" name="admissions" min="0" placeholder="Nhập số sinh viên nhập học">
        </div>

        <div class="mb-3">
            <label for="current_students" class="form-label">Số sinh viên hiện tại</label>
            <input type="number" class="form-control" id="current_students" name="current_students" min="0" placeholder="Nhập số sinh viên hiện tại">
        </div>

       <!-- Nút tạo -->
        <div class="mt-4 d-flex justify-content-end">
        <button type="button" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Tạo
        </button>
        </div>
    </form>

</div>
@endsection
