@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa lớp học')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Lớp học - Chỉnh sửa</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>
                <a href="{{ route('admin.class.index') }}" class="btn btn-primary me-2">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
        </div>

        <!-- Form chỉnh sửa -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form>
                    {{-- Giả lập dữ liệu sau khi import từ file --}}
                    @php
                        $class = [
                            'class_name' => 'DHTI69B',
                            'course' => '69',
                            'year' => '2024',
                            'student_total' => '28',
                        ];
                    @endphp

                    <div class="mb-3">
                        <label for="class_name" class="form-label">Tên lớp</label>
                        <input type="text" id="class_name" class="form-control" value="{{ $class['class_name'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="course" class="form-label">Khóa</label>
                        <input type="text" id="course" class="form-control" value="{{ $class['course'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Năm nhập học</label>
                        <input type="number" id="year" class="form-control" value="{{ $class['year'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="student_total" class="form-label">Số sinh viên hiện tại</label>
                        <input type="number" id="student_total" class="form-control" value="{{ $class['student_total'] }}">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
