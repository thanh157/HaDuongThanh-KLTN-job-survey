@extends('admin.layouts.master')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Hệ Thống - Tài khoản</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa thông tin tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>

        <form action="" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Avatar + Vai trò -->
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
                        <!-- Form chỉnh sửa -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Tên đăng nhập</label>
                                    <input type="text" class="form-control" name="username" value="admin123">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email" value="admin@vnua.edu.vn">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Họ và tên</label>
                                    <input type="text" class="form-control" name="fullname" value="Nguyễn Văn A">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Ngày sinh</label>
                                    <input type="date" class="form-control" name="birthday" value="1990-01-01">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Giới tính</label>
                                    <select class="form-select" name="gender">
                                        <option selected>Nam</option>
                                        <option>Nữ</option>
                                        <option>Khác</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" value="0123456789">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" value="Khu A - Đại học Nông nghiệp">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Khoa</label>
                                    <input type="text" class="form-control" name="faculty" value="Công nghệ thông tin">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Lớp</label>
                                    <input type="text" class="form-control" name="class" value="CNTT-K45">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-semibold">Chuyên ngành</label>
                                    <input type="text" class="form-control" name="major" value="Hệ thống thông tin">
                                </div>
                            </div>

                            <!-- Nút lưu -->
                            <div class="text-end mt-4">
                                <a href="{{ route('admin.infor-account.index') }}" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
