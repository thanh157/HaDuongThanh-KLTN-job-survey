@extends('admin.layouts.master')

@section('title', 'Tạo mới đợt khảo sát việc làm')

@section('content')

<div class="container py-4">
  <!-- Tiêu đề và breadcrumb -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
    <div>
      <h4 class="fw-bold mb-1">Đợt khảo sát - Tạo mới</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item"><a href="#">Đợt khảo sát việc làm</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.survey.index') }}" class="btn btn-primary">
      <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>
  </div>

  <!-- Form chỉ giao diện -->
  <form>
    <div class="row g-4">
      <!-- Cột trái -->
      <div class="col-12 col-md-8">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin chung</h6>
          <div class="mb-3">
            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Tiêu đề đợt khảo sát việc làm">
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="3" placeholder="Nội dung mô tả"></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Thời gian bắt đầu khảo sát <span class="text-danger">*</span></label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Thời gian kết thúc khảo sát <span class="text-danger">*</span></label>
              <input type="date" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <!-- Cột phải -->
      <div class="col-12 col-md-4">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin tốt nghiệp</h6>
          <div class="mb-3">
            <label class="form-label">Năm tốt nghiệp</label>
            <select class="form-select">
              <option selected disabled>-- Chọn năm --</option>
              @for ($i = now()->year; $i >= 2000; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Các đợt tốt nghiệp</label>
            <select class="form-select">
              <option selected disabled>-- Chọn đợt --</option>
              <option value="1">Đợt 1</option>
              <option value="2">Đợt 2</option>
              <option value="3">Đợt 3</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Nút -->
    <div class="mt-4 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Tạo
      </button>
    </div>
  </form>
</div>
@endsection
