@extends('admin.layouts.master')

@section('title', 'Tạo mới Vai trò')

@section('content')
<div class="container py-4">
  <!-- Tiêu đề và breadcrumb -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
    <div>
      <h4 class="fw-bold mb-1">Vai trò - Tạo mới</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item"><a href="#">Vai trò</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.role.index') }}" class="btn btn-primary">
      <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
  </div>

  <!-- Hiển thị thông báo lỗi -->
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Hiển thị thông báo thành công -->
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- Hiển thị thông báo lỗi -->
  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <!-- Form tạo vai trò -->
  <form action="{{ route('admin.role.store') }}" method="POST">
    @csrf
    <div class="row g-4">
      <!-- Thông tin chung -->
      <div class="col-12 col-md-8">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin chung</h6>
          <div class="mb-3">
            <label class="form-label">Tên <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Nhập tên Vai trò" name="name" value="{{ old('name') }}">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả </label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      placeholder="Nhập mô tả Vai trò" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
