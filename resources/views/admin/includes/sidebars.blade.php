<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <style>
        .nav-item-header {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #ccc;
            margin: 20px 0 10px 0;
            padding-left: 0.75rem;
            border-left: 3px solid #0d6efd;
            background-color: rgba(255, 255, 255, 0.05);
            padding-top: 6px;
            padding-bottom: 6px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        /* Chỉ lấp lánh khi có class active-section */
        .nav-item-header.active-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            animation: shine 2s infinite;
            pointer-events: none;
        }

        @keyframes shine {
            0% {
                left: -75%;
            }

            100% {
                left: 125%;
            }
        }

        .nav-item-header:hover {
            transform: scale(1.02);
            color: #fff;
        }

        .nav-item-header.active-section {
            border-left-color: #ffc107 !important;
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #ffc107 !important;
        }

        .nav-link.active {
            background-color: #213a56 !important;
            color: #fff !important;
        }

        .nav-link.active i {
            color: #fff !important;
        }

        .nav-link i {
            color: #adb5bd;
        }

        .nav-link {
            transition: background-color 0.2s, color 0.2s;
        }
    </style>

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section px-3 py-2 d-flex align-items-center">
            <i class="fa-solid fa-graduation-cap me-3 fs-5 text-white"></i>
            <h6 class="my-auto text-white fw-bold">STUDENT VNUA</h6>
        </div>

        <!-- Quản lí chung -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li
                    class="nav-item-header
            {{ request()->routeIs('admin.dashboard*') ||
            request()->routeIs('admin.department.*') ||
            request()->routeIs('admin.major.*') ||
            request()->routeIs('admin.class.*') ||
            request()->route() === null ||
            request()->is('admin') ||
            request()->path() == '/'
                ? 'active-section'
                : '' }}">
                    <span>Quản lí chung</span>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard*') ||
                        request()->route() === null ||
                        request()->is('admin') ||
                        request()->path() == '/'
                            ? 'active'
                            : '' }}">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Bảng điều khiển</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.department.index') }}"
                        class="nav-link {{ request()->routeIs('admin.department.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building"></i>
                        <span>Bộ môn</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.major.index') }}"
                        class="nav-link {{ request()->routeIs('admin.major.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-laptop-code"></i>
                        <span>Ngành đào tạo</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.class.index') }}"
                        class="nav-link {{ request()->routeIs('admin.class.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-rectangle"></i>
                        <span>Lớp học</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tốt nghiệp -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header {{ request()->routeIs('admin.graduation.*') ? 'active-section' : '' }}">
                    <span>Tốt nghiệp</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.graduation.index') }}"
                        class="nav-link {{ request()->routeIs('admin.graduation.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Đợt tốt nghiệp</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Khảo sát -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header {{ request()->routeIs('admin.survey.*') ? 'active-section' : '' }}">
                    <span>Khảo sát</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.survey.index') }}"
                        class="nav-link {{ request()->routeIs('admin.survey.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-question"></i>
                        <span>Khảo sát việc làm</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.survey.form-survey') }}" class="nav-link {{ request()->routeIs('admin.survey.form-survey') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-question"></i>
                        <span>Câu hỏi cố định</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Báo cáo - Thống kê -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li
                    class="nav-item-header {{ request()->routeIs('admin.charts.*') || request()->routeIs('admin.report.*') ? 'active-section' : '' }}">
                    <span>Báo cáo - Thống kê</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.charts.index') }}"
                        class="nav-link {{ request()->routeIs('admin.charts.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-column"></i>
                        <span>Biểu đồ thống kê</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.report.index') }}"
                        class="nav-link {{ request()->routeIs('admin.report.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Báo cáo tổng hợp</span>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Hệ thống -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header {{ request()->routeIs('admin.infor-account.*') ? 'active-section' : '' }}">
                    <span>Hệ thống</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.infor-account.index') }}"
                        class="nav-link {{ request()->routeIs('admin.infor-account.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-cog"></i>
                        <span>Tài khoản</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.role.index') }}"
                        class="nav-link {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                        <i class="ph-shield"></i>
                        <span>Vai trò</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- User (ACCOUNT) -->
    <div class="sidebar-section mt-3 pt-3 border-top">
        <div class="sidebar-section-body px-3 py-2 d-flex align-items-center">
            <div class="me-3">
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-user text-dark"></i>
                </div>
            </div>
            <div>
                <div class="fw-bold text-white" style="font-size: 16px;">Supper Admin CNTT</div>
                <div class="text-white-50" style="font-size: 13px;">admincntt@vnua.edu.vn</div>
            </div>
        </div>
    </div>
</div>
<!-- /main sidebar -->
