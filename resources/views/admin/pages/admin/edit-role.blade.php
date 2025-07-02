@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa Vai trò')

@section('content')
<div class="container py-4">
  <!-- Tiêu đề và breadcrumb -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
    <div>
      <h4 class="fw-bold mb-1">Vai trò - Chỉnh sửa</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Vai trò</a></li>
          <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
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

  <!-- Form chỉnh sửa vai trò -->
  <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="col-12">
      <!-- Thông tin chung -->
      <div class="col-12 ">
        <div class="card p-4 shadow-sm h-100">
          <h6 class="mb-3">Thông tin chung</h6>
          <div class="mb-3">
            <label class="form-label">Tên <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Nhập tên Vai trò" name="name" value="{{ old('name', $role->name) }}">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả </label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      placeholder="Nhập mô tả Vai trò" name="description" rows="3">{{ old('description', $role->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      <div class="col-12">
          <div class="card">
              <div class="card-header bold">
                  <i class="ph-buildings"></i>
                  Quyền
              </div>
              <div class="card-body">
                  @foreach ($groupPermissions as $group)
                      <div class="row">
                          <div class="col">
                              <div class="card">
                                  <div class="card-header">
                                      <div class="form-check">
                                          <label class="form-check-label" for="group-{{ $group->id }}">{{ $group->name }}</label>
                                      </div>
                                  </div>
                                  <div class="card-body">
                                      <div class="row">
                                          @foreach ($group->permissions as $item)
                                              <div class="col-12 col-sm-6 col-md-3">
                                                  <div class="form-check">
                                                      <input type="checkbox" name="permissions[]" {{ $role->permissions->contains($item->id) ? 'checked' : '' }} class="form-check-input" value="{{ $item->id }}" id="permission-{{ $item->id }}">
                                                      <label class="form-check-label" for="permission-{{ $item->id }}">{{ $item->name }}</label>
                                                  </div>
                                              </div>
                                          @endforeach
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </div>

      <!-- Thông tin bổ sung -->
    </div>

    <!-- Nút cập nhật -->
    <div class="mt-4 d-flex justify-content-end gap-2">
      <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
        <i class="bi bi-x-circle me-1"></i> Hủy
      </a>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Cập nhật
      </button>
    </div>
  </form>
</div>
@endsection
