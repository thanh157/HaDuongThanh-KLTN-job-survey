@php
    $auth = app(\App\Services\SsoService::class)->getDataUser();
@endphp
<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <!-- Toggle sidebar button for mobile -->
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <!-- Logo -->
        <div class="navbar-brand flex-1 flex-lg-0" style="flex-grow: 1; max-width: 200px;">
            <img src="{{ asset('assets/admin/images/logo-vnua-white.png') }}" alt="Logo"
                style="width: 100%; height: auto;">
        </div>

        <!-- (Giữ nguyên nếu có ô tìm kiếm) -->
        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <!-- Search giữ nguyên nếu có -->
        </div>

        <!-- Nút điều hướng bên phải -->
        <ul class="nav flex-row justify-content-end order-1 order-lg-2 align-items-center">


            <!-- Nút Trang chủ -->
            <li class="nav-item me-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="navbar-nav-link rounded-pill d-flex align-items-center px-3 py-2"
                    style="background-color: #28a745; color: white; font-weight: 600;">
                    <i class="ph-house me-2" style="font-size: 1.25rem;"></i>
                    <span>Trang chủ</span>
                </a>
            </li>

            <!-- Dropdown tài khoản -->
            <li class="nav-item dropdown">
                <a href="#"
                    class="navbar-nav-link dropdown-toggle d-flex align-items-center px-2 py-1 rounded-pill"
                    data-bs-toggle="dropdown" style="background-color: #0d6efd; color: white;">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-user text-dark"></i>
                    </div>
                    @if (auth()->check())
                        <div class="d-none d-xl-block text-start">
                            <div class="fw-bold text-white" style="font-size: 14px;">{{ $auth['full_name'] }}</div>
                            <div class="text-white-50" style="font-size: 12px;">{{ $auth['email'] }}</div>
                        </div>
                    @endif
                </a>

                <!-- Dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li><a href="{{ route('admin.infor-account.index') }}" class="dropdown-item"><i
                                class="fa-solid fa-user-cog me-2"></i>Thông tin tài khoản</a></li>
                    <li><a href="{{ route('admin.infor-account.change-password') }}" class="dropdown-item"><i
                                class="fa-solid fa-lock me-2"></i>Đổi mật khẩu</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('handleLogout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="ph-sign-out me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
