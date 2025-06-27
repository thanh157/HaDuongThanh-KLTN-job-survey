@extends('admin.layouts.master')

@section('title', 'Ngành đào tạo')

@section('content')
    <div class="container py-4">
        <!-- Tiêu đề -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Quản lí chung - Ngành đào tạo</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.major.index') }}">Ngành đào tạo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách ngành đào tạo</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Bảng -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-bordered">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <!-- Mã ngành -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Mã ngành</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ma')"></i>
                                    <div id="filter-ma" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="ma_nganh" class="form-control"
                                                placeholder="VD: 7480102" value="{{ request('ma_nganh') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <!-- Tên ngành -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Tên ngành</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ten')"></i>
                                    <div id="filter-ten" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="ten_nganh" class="form-control"
                                                placeholder="VD: CNTT" value="{{ request('ten_nganh') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <!-- Trạng thái -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Trạng thái</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-trangthai')"></i>
                                    <div id="filter-trangthai"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="mb-2">
                                            <select class="form-select" name="trang_thai">
                                                <option value="">Tất cả</option>
                                                <option value="active"
                                                    {{ request('trang_thai') == 'active' ? 'selected' : '' }}>Hoạt động
                                                </option>
                                                <option value="hidden"
                                                    {{ request('trang_thai') == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <!-- Ngày tạo -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Ngày tạo</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;"
                                        onclick="toggleFilter('filter-ngay')"></i>
                                    <div id="filter-ngay"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="mb-2">
                                            <select class="form-select" name="sap_xep">
                                                <option value="moi_nhat"
                                                    {{ request('sap_xep') == 'moi_nhat' ? 'selected' : '' }}>Mới nhất
                                                </option>
                                                <option value="cu_nhat"
                                                    {{ request('sap_xep') == 'cu_nhat' ? 'selected' : '' }}>Cũ nhất</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($majors as $major)
                            <tr>
                                <td>{{ $major['code'] }}</td>
                                <td>{{ $major['name'] }}</td>
                                <td>
                                    @if ($major['status'] === 'active')
                                        <span class="badge bg-success">HOẠT ĐỘNG</span>
                                    @else
                                        <span class="badge bg-secondary">ẨN</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($major['created_at'])->format('H:i d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có dữ liệu ngành đào tạo</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .filter-popup {
            display: none;
            z-index: 999;
            min-width: 240px;
            top: 100%;
            left: 0;
        }

        .filter-popup.show {
            display: block;
        }
    </style>

    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            const popup = document.getElementById(id);
            if (popup) popup.classList.toggle('show');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.filter-popup') && !e.target.classList.contains('bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            }
        });
    </script>
@endpush
