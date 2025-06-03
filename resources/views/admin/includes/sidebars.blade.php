<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section px-3 py-2 d-flex align-items-center">
            <i class="fa-solid fa-table fa-beat-fade me-3 fs-5 text-white"></i>
            <h6 class="my-auto text-white fw-bold">STUDENT VNUA</h6>

            {{-- <div class="d-flex align-items-center">
                <input type="checkbox" id="toggleTheme" />
                <label for="toggleTheme" class="ms-2">

                </label>
            </div> --}}
        </div>
        <!-- /sidebar header -->

        <!-- Quan li chungchung -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- 1 -->
                <li class="nav-item-header pt-0 mt-3">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">QUẢN LÍ CHUNG</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                {{-- bang dk --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>
                            Bảng điều khiển
                        </span>
                    </a>
                </li>
                {{-- bo mon --}}
                <li class="nav-item">
                     <a href="{{ route('admin.department') }}" class="nav-link">
                        <i class="fa-solid fa-building"></i>
                        <span>
                            Bộ môn
                        </span>
                    </a>
                </li>
                {{-- nghanh dao tao --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-industry"></i>
                        <span>
                            Nghành đào tạo
                        </span>
                    </a>
                </li>
                {{-- lop hoc --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-book"></i>
                        <span>
                            Lớp học
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /quanlichung -->

        <!-- SINH VIEN -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Club list -->
                <li class="nav-item-header pt-0 mt-3">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">SINH VIÊN</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                {{-- dssvssv --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-users"></i>
                        <span>
                            Danh sách sinh viên
                        </span>
                    </a>
                </li>
                {{-- dtndtn --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>
                            Đợt tốt nghiệp
                        </span>
                    </a>
                </li>
                {{-- cc --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>
                            Cảnh cáo
                        </span>
                    </a>
                </li>
                {{-- nh --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-ban"></i>
                        <span>
                            Nghỉ học
                        </span>
                    </a>
                </li>
                {{-- xntt --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>
                            Xác nhận thông tin
                        </span>
                    </a>
                </li>
                {{-- pa --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-comments"></i>
                        <span>
                            Phản ánh
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /sinh vien -->

        <!-- KHAO SAT -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- 3 -->
                <li class="nav-item-header pt-0 mt-3">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">KHẢO SÁT</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                {{-- ksvl --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        <span>
                            Khảo sát việc làm
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /khao sat -->

        <!-- BÁO CÁO - THỐNG KÊ -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- 3 -->
                <li class="nav-item-header pt-0 mt-3">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">BÁO CÁO-THỐNG KÊ</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                {{-- bd --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        <span>
                            Biểu đồ thống kê
                        </span>
                    </a>
                </li>
                {{-- bcth --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-table-list"></i>
                        <span>
                            Báo cáo tổng hợp
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        {{-- /baocao-thongke --}}

        <!-- HỆ THỐNG -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- 3 -->
                <li class="nav-item-header pt-0 mt-3">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">HỆ THỐNG</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                {{-- tk --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-user"></i>
                        <span>
                            Tài khoản
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /he thong -->
    </div>
    <!-- /sidebar content -->

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
    <!-- /User (ACCOUNT) -->

</div>
<!-- /main sidebar -->
