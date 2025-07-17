@extends('admin.layouts.master')

@section('title', 'Bộ môn')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Quản lí chung - Bộ môn</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.department.index') }}">Bộ môn</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bộ môn</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle table-bordered mb-0">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th>STT</th>
                            {{-- <th>Mã bộ môn</th> --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Tên bộ môn</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-ten')"
                                        style="cursor: pointer;"></i>
                                    <div id="filter-ten" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <input type="text" name="ten_bo_mon" class="form-control mb-2"
                                            placeholder="vd: Tin học" value="{{ request('ten_bo_mon') }}">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                            <th>Mô tả</th>
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Trạng thái</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1"
                                        onclick="toggleFilter('filter-trangthai')" style="cursor: pointer;"></i>
                                    <div id="filter-trangthai"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select name="trang_thai" class="form-select mb-2">
                                            <option value="">Tất cả</option>
                                            <option value="active"
                                                {{ request('trang_thai') == 'active' ? 'selected' : '' }}>
                                                Hoạt động</option>
                                            <option value="hidden"
                                                {{ request('trang_thai') == 'hidden' ? 'selected' : '' }}>
                                                Ẩn</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Ngày cập nhật</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-ngay')"
                                        style="cursor: pointer;"></i>
                                    <div id="filter-ngay"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <select name="sap_xep" class="form-select mb-2">
                                            <option value="">Tất cả</option>
                                            <option value="moi_nhat"
                                                {{ request('sap_xep') == 'moi_nhat' ? 'selected' : '' }}>Mới nhất</option>
                                            <option value="cu_nhat" {{ request('sap_xep') == 'cu_nhat' ? 'selected' : '' }}>
                                                Cũ nhất</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departments['data'] as $index => $department)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                {{-- <td>{{ $department['code'] ?? '---' }}</td> --}}
                                <td>{{ $department['name'] }}</td>
                                <td>{{ $department['description'] ?? '---' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $department['status'] == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $department['status'] == 'active' ? 'HOẠT ĐỘNG' : 'ẨN' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($department['created_at'])->format('H:i d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .filter-popup {
            top: 100%;
            left: 0;
            z-index: 10;
            min-width: 250px;
            display: none;
        }

        .filter-popup.show {
            display: block;
        }

        .breadcrumb {
            font-size: 13px;
        }
    </style>

    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            const popup = document.getElementById(id);
            if (popup) popup.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.filter-popup') && !event.target.classList.contains('bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            }
        });
    </script>
@endsection
