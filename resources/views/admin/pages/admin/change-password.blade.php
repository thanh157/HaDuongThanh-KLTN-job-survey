@extends('admin.layouts.master')

@section('title', 'Thay đổi mật khẩu')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Hệ Thống - Tài khoản</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.infor-account.change-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="current_password" class="form-label fw-semibold">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" name="current_password" id="current_password"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label for="new_password" class="form-label fw-semibold">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                        </div>

                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                required>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.infor-account.index') }}" class="btn btn-primary me-2">
                            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-key me-1"></i> Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
