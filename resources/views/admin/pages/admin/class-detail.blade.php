@extends('admin.layouts.master')

@section('title', 'Chi tiết lớp học')

@section('content')
    <div class="container py-4 d-flex flex-column flex-grow-1">

        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="mb-1 fw-bold">Quản lí chung - Lớp học</h5>
                <nav style="--bs-breadcrumb-divider: '>'; font-size: 14px;">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Lớp học</a></li>
                        <li class="breadcrumb-item active">Danh sách khóa 47</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="bg-light px-3 py-2 rounded shadow-sm text-center border">
                    <div class="fw-semibold text-dark">Khóa <span class="text-primary">47</span></div>
                    <small class="text-muted">Năm: 2002</small>
                </div>
                <a href="#" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bi bi-plus-lg me-1"></i> Tạo mới
                </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <ul class="nav nav-tabs border-bottom" style="gap: 10px;">
                <li class="nav-item"><a class="nav-link {{ request('loai') === null ? 'active' : '' }}" href="?loai=tatca">Tất cả các lớp (10 lớp)</a></li>
                <li class="nav-item"><a class="nav-link {{ request('loai') === 'chung' ? 'active' : '' }}" href="?loai=chung">Lớp chung (0 lớp)</a></li>
                <li class="nav-item"><a class="nav-link {{ request('loai') === 'chua_phan_loai' ? 'active' : '' }}" href="?loai=chua_phan_loai">Lớp chưa phân loại (0 lớp)</a></li>
            </ul>
            <form method="GET" action="" class="d-flex gap-2">
                <select name="search_type" class="form-select">
                    <option value="lop" {{ request('search_type') === 'lop' ? 'selected' : '' }}>Theo lớp</option>
                    <option value="gvcn" {{ request('search_type') === 'gvcn' ? 'selected' : '' }}>Theo giáo viên chủ nhiệm</option>
                    <option value="covan" {{ request('search_type') === 'covan' ? 'selected' : '' }}>Theo cố vấn học tập</option>
                </select>
                <input type="text" name="search_value" class="form-control" placeholder="Từ khóa tìm kiếm..." value="{{ request('search_value') }}">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <!-- Bảng -->
        <div class="card shadow-sm flex-grow-1 d-flex flex-column">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Lớp</th>
                            <th>Giáo viên chủ nhiệm</th>
                            <th>Cố vấn học tập</th>
                            <th>Số lượng sinh viên</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $loai = request('loai');
                            $searchType = request('search_type');
                            $searchValue = request('search_value');

                            $filteredData = collect([]);
                            for ($i = 1; $i <= 15; $i++) {
                                $lop = 'K66CNTT' . $i;
                                $gvcn = 'Nguyễn Văn ' . chr(64 + ($i % 26));
                                $coVan = 'Trần Thị ' . chr(64 + ($i % 26));

                                if ($loai === 'chung' && $i % 3 !== 0) continue;
                                if ($loai === 'chua_phan_loai' && $i % 3 !== 1) continue;

                                if ($searchValue) {
                                    $val = strtolower($searchValue);
                                    if ($searchType === 'lop' && stripos($lop, $val) === false) continue;
                                    if ($searchType === 'gvcn' && stripos($gvcn, $val) === false) continue;
                                    if ($searchType === 'covan' && stripos($coVan, $val) === false) continue;
                                }

                                $filteredData->push([
                                    'lop' => $lop,
                                    'gvcn' => $gvcn,
                                    'covan' => $coVan,
                                    'sv' => rand(35, 55),
                                    'status' => $i % 2 == 0,
                                    'created_at' => now()->format('d/m/Y')
                                ]);
                            }

                            $perPage = 5;
                            $page = request()->get('page', 1);
                            $paginatedData = $filteredData->forPage($page, $perPage);
                        @endphp
                        @forelse ($paginatedData as $item)
                            <tr>
                                <td>{{ $item['lop'] }}</td>
                                <td>{{ $item['gvcn'] }}</td>
                                <td>{{ $item['covan'] }}</td>
                                <td>{{ $item['sv'] }} SV</td>
                                <td>
                                    <span class="badge {{ $item['status'] ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item['status'] ? 'ĐANG HOẠT ĐỘNG' : 'ẨN' }}
                                    </span>
                                </td>
                                <td>{{ $item['created_at'] }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="bi bi-pencil-square"></i></a>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có dữ liệu phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-auto pt-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <nav>
                    <ul class="pagination mb-0">
                        @php $totalPages = ceil($filteredData->count() / $perPage); @endphp
                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ $page - 1 }}">«</a>
                        </li>
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $page == $totalPages ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ $page + 1 }}">»</a>
                        </li>
                    </ul>
                </nav>
                <a href="{{ route('admin.class.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>

    </div>

    <!-- CSS popup + responsive -->
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

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            table thead {
                font-size: 12px;
            }

            table tbody tr td {
                font-size: 13px;
                white-space: nowrap;
            }

            .breadcrumb {
                font-size: 13px !important;
            }

            .btn {
                font-size: 13px;
                padding: 6px 10px;
            }
        }

        .pagination .page-link {
            padding: 6px 10px;
        }

        .nav-tabs .nav-link {
            font-size: 14px;
            padding: 6px 12px;
        }
    </style>

    <!-- JS hiển thị bộ lọc -->
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
