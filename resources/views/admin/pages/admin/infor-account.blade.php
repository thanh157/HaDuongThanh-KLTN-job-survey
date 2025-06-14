@extends('admin.layouts.master')

@section('title', 'Thông tin tài khoản')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Hệ Thống - Tài khoản</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-4">
                    <!-- Avatar + Tên + Vai trò -->
                    <div class="col-lg-4 text-center border-end">
                        <img src="{{ asset('assets/admin/images/infor.png') }}" alt="Avatar"
                            class="rounded-circle mb-3 img-fluid" style="width: 140px; height: 140px; object-fit: cover;">
                        <h5 class="mb-1">Nguyễn Văn A</h5>
                        <span class="badge bg-success">Supper Admin</span>

                        <div class="d-grid gap-2 col-10 mx-auto mt-4">
                           <label class="btn btn-outline-primary btn-sm m-0" for="avatarInput">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Sửa ảnh
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-trash me-1"></i> Xoá ảnh
                            </a>
                        </div>
                    </div>

                    <!-- Thông tin chi tiết -->
                    <div class="col-lg-8">
                        <div class="row g-3">
                            @php
                                $info = [
                                    'Tên đăng nhập' => 'admin123',
                                    'Email' => 'admin@vnua.edu.vn',
                                    'Họ và tên' => 'Nguyễn Văn A',
                                    'Ngày sinh' => '01/01/1990',
                                    'Giới tính' => 'Nam',
                                    'Số điện thoại' => '0123456789',
                                    'Địa chỉ' => 'Khu A - Đại học Nông nghiệp',
                                    'Khoa' => 'Công nghệ thông tin',
                                    'Lớp' => 'CNTT-K45',
                                    'Chuyên ngành' => 'Hệ thống thông tin',
                                    'Quyền' => 'Supper Admin',
                                    'Ngày tạo tài khoản' => '01/01/2024',
                                ];
                            @endphp

                            @foreach ($info as $label => $value)
                                <div class="col-sm-6">
                                    <div class="small text-muted">{{ $label }}:</div>
                                    <div class="fw-semibold">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Nút chức năng -->
                        <div class="text-end mt-4">
                            <a href="{{ route('admin.infor-account.edit-profile') }}" class="btn btn-primary me-2">
                                <i class="fa-solid fa-pen me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.infor-account.change-password') }}" class="btn btn-primary">
                                <i class="fa-solid fa-key me-1"></i> Đổi mật khẩu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
