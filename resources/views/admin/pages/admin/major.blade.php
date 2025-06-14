@extends('admin.layouts.master')

@section('title', 'Ngành đào tạo')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Quản lí chung - Ngành đào tạo</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Nghành đào tạo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách nghành đào tạo</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('admin.major.create-major') }}" class="btn btn-primary mt-2 mt-sm-0">
                    <i class="bi bi-plus-lg me-1"></i> Tạo mới
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-bordered">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <!-- Mã ngành đào tạo -->
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Mã ngành đào tạo</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ma')"></i>
                                    <div id="filter-ma" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="ma_nghanh_dao_tao" class="form-control"
                                                placeholder="vd: DT001">
                                        </div>
                                    </div>
                                </form>
                            </th>

                            <!-- Tên ngành đào tạo -->
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Tên ngành đào tạo</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ten')"></i>
                                    <div id="filter-ten" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="ten_nghanh_dao_tao" class="form-control"
                                                placeholder="vd: Công nghệ phần mềm...">
                                        </div>
                                    </div>
                                </form>
                            </th>

                            <!-- Trạng thái -->
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Trạng thái</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-trangthai')"></i>
                                    <div id="filter-trangthai"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select class="form-select" name="trang_thai">
                                            <option value="">Tất cả</option>
                                            <option value="hoat_dong">Hoạt động</option>
                                            <option value="an">Ẩn</option>
                                        </select>
                                    </div>
                                </form>
                            </th>

                            <!-- Ngày tạo -->
                            <th>
                                <form method="GET" action="" class="position-relative d-inline-block">
                                    <span>Ngày tạo</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ngay')"></i>
                                    <div id="filter-ngay"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select class="form-select" name="sap_xep">
                                            <option value="moi_nhat">Gần nhất</option>
                                            <option value="cu_nhat">Xa nhất</option>
                                        </select>
                                    </div>
                                </form>
                            </th>

                            <!-- Hành động -->
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Dữ liệu mẫu -->
                        <tr>
                            <td>7480102</td>
                            <td>Khoa học máy tính</td>
                            <td><span class="badge bg-success">HOẠT ĐỘNG</span></td>
                            <td>23:56 30/11/2024</td>
                            <td class="text-center">
                                <a href="{{ route('admin.major.edit-major', ['id' => 1]) }}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>7480102</td>
                            <td>Mạng máy tính và truyền thông dữ liệu</td>
                            <td><span class="badge bg-success">HOẠT ĐỘNG</span></td>
                            <td>20:46 11/11/2024</td>
                            <td class="text-center">
                                <a href="{{ route('admin.major.edit-major', ['id' => 2]) }}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>7480201</td>
                            <td>Công nghệ thông tin</td>
                            <td><span class="badge bg-success">HOẠT ĐỘNG</span></td>
                            <td>20:19 16/11/2024</td>
                            <td class="text-center">
                                <a href="{{ route('admin.major.edit-major', ['id' => 3]) }}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
