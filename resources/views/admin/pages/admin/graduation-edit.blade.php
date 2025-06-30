@extends('admin.layouts.master')

@section('title', 'Sửa đợt tốt nghiệp')

@section('content')
    <div class="container py-4">
        <!-- Tiêu đề và breadcrumb -->
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Tốt nghiệp - Sửa đợt tốt nghiệp</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.graduation.index') }}">Đợt tốt nghiệp</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
                    </ol>
                </nav>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

            </div>

            <a href="{{ route('admin.graduation.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.graduation.update', $item['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- Cột trái -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin đợt tốt nghiệp</h6>
                        <div class="mb-3">
                            <label class="form-label">Đợt tốt nghiệp <span class="text-danger">*</span></label>
                            <input type="text" name="dot_tot_nghiep" class="form-control"
                                value="{{ $item['dot_tot_nghiep'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tổng số sinh viên <span class="text-danger">*</span></label>
                            <input type="number" name="tong_sinh_vien" class="form-control"
                                value="{{ $item['tong_sinh_vien'] }}" required>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Năm tốt nghiệp</h6>
                        <div class="mb-3">
                            <label class="form-label">Chọn năm tốt nghiệp <span class="text-danger">*</span></label>
                            <select class="form-select" name="nam_tot_nghiep" required>
                                <option disabled>-- Chọn năm --</option>
                                @for ($i = now()->year + 1; $i >= 2000; $i--)
                                    <option value="{{ $i }}"
                                        {{ $item['nam_tot_nghiep'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
@endsection
