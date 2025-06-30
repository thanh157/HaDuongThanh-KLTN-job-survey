@extends('admin.layouts.master')

@section('title', 'Thêm đợt tốt nghiệp')

@section('content')
<div class="container py-4">
  <!-- Tiêu đề và breadcrumb -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
    <div>
      <h4 class="fw-bold mb-1">Tốt nghiệp - Thêm đợt tốt nghiệp</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.graduation.index') }}">Đợt tốt nghiệp</a></li>
          <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
        </ol>
      </nav>

      @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger mt-3">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <a href="{{ route('admin.graduation.index') }}" class="btn btn-primary">
      <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
  </div>

  <!-- Form -->
  <form action="{{ route('admin.graduation.store') }}" method="POST">
    @csrf
    <div class="row g-4">
      <!-- Cột trái -->
      <div class="col-12 col-md-8">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin đợt tốt nghiệp</h6>

          <div class="mb-3">
            <label class="form-label">Đợt tốt nghiệp <span class="text-danger">*</span></label>
            <input type="text" name="dot_tot_nghiep" class="form-control" placeholder="VD: T12/2024" required value="{{ old('dot_tot_nghiep') }}">
            @error('dot_tot_nghiep')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Tổng số sinh viên <span class="text-danger">*</span></label>
            <input type="number" name="tong_sinh_vien" class="form-control" min="0" required value="{{ old('tong_sinh_vien') }}">
            @error('tong_sinh_vien')
              <small class="text-danger">{{ $message }}</small>
            @enderror
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
              <option disabled {{ old('nam_tot_nghiep') ? '' : 'selected' }}>-- Chọn năm --</option>
              @for ($i = now()->year + 1; $i >= 2000; $i--)
                <option value="{{ $i }}" {{ old('nam_tot_nghiep') == $i ? 'selected' : '' }}>{{ $i }}</option>
              @endfor
            </select>
            @error('nam_tot_nghiep')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Nút -->
    <div class="mt-4 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Thêm mới
      </button>
    </div>
  </form>
</div>
@endsection
