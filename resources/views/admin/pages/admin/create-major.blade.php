@extends('admin.layouts.master')

@section('title', 'Tạo mới ngành đào tạo')

@section('content')
<div class="container py-4">
  <!-- Tiêu đề và breadcrumb -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
    <div>
      <h4 class="fw-bold mb-1">Nghành đào tạo - Tạo mới</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item"><a href="#">Nghành đào tạo</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.major.index') }}" class="btn btn-primary">
      <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
  </div>

  <!-- Form chỉ giao diện, không xử lý -->
  <form>
    <div class="row g-4">
      <!-- Thông tin chung -->
      <div class="col-12 col-md-8">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin chung</h6>
          <div class="mb-3">
            <label class="form-label">Mã nghành đào tạo <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Nhập mã nghành đào tạo">
          </div>
          <div class="mb-3">
            <label class="form-label">Tên nghành đào tạo <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Nhập tên nghành đào tạo">
          </div>
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

    <!-- Nút tạo -->
    <div class="mt-4 d-flex justify-content-end">
      <button type="button" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Tạo
      </button>
    </div>
  </form>
</div>
@endsection
