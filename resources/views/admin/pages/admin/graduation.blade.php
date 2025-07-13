@extends('admin.layouts.master')

@section('title', 'Đợt tốt nghiệp')

@section('content')
    <div class="container py-4">
        <!-- Tiêu đề và breadcrumb -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Tốt nghiệp - Đợt tốt nghiệp</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.graduation.index') }}">Đợt tốt nghiệp</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đợt tốt nghiệp</li>
                    </ol>
                </nav>

                <!-- THÔNG BÁO THÀNH CÔNG -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            {{-- <a href="{{ route('admin.graduation.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Thêm mới
            </a> --}}
        </div>

        <!-- Bảng dữ liệu -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-bordered">
                    <thead class="table-light text-center text-nowrap">
                        <tr>
                            <!-- Cột lọc đợt tốt nghiệp -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Đợt tốt nghiệp</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-dot')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-dot" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="VD: Đợt xét tốt nghiệp tháng 05/2023"
                                                value="{{ request('name') }}">

                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <!-- Cột lọc năm tốt nghiệp -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Năm tốt nghiệp</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-nam')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-nam" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="year" class="form-control" placeholder="VD: 2024"
                                                value="{{ request('year') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <th>Tổng số sinh viên</th>

                            <!-- Sắp xếp theo ngày -->
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Ngày cập nhật</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-ngay')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-ngay"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="mb-2">
                                            <select name="sap_xep" class="form-select">
                                                <option value="">Tất cả</option>
                                                <option value="moi_nhat"
                                                    {{ request('sap_xep') == 'moi_nhat' ? 'selected' : '' }}>Gần nhất
                                                </option>
                                                <option value="cu_nhat"
                                                    {{ request('sap_xep') == 'cu_nhat' ? 'selected' : '' }}>Xa nhất</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- <th class="text-center">Hành động</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($graduations as $graduation)
                            <tr class="text-center">
                                <td>
                                    <a href="{{ route('admin.graduation-student.show', $graduation['id']) }}">
                                        {{ $graduation['name'] }}
                                    </a>

                                </td>

                                {{-- <td><a href="#">{{ $graduation['name'] }}</a></td> --}}
                                <td>{{ $graduation['school_year'] }}</td>
                                <td>{{ $graduation['student_count'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($graduation['created_at'])->format('H:i d/m/Y') }}</td>
                                {{-- <td><a href="#">{{ $graduation['dot_tot_nghiep'] }}</a></td<td>
                                    <a href="{{ route('admin.graduation-student.index', $graduation['id']) }}">
                                        {{ $graduation['dot_tot_nghiep'] }}
                                    </a>
                                </td>

                                <td>{{ $graduation['nam_tot_nghiep'] }}</td>
                                <td>{{ $graduation['tong_sinh_vien'] }}</td>
                                <td>
                                    {{ isset($graduation['created_at']) ? \Carbon\Carbon::parse($graduation['created_at'])->format('H:i d/m/Y') : 'Chưa rõ' }}
                                </td>

                                <td class="text-nowrap">
                                    <a href="{{ route('admin.graduation.edit', $graduation['id']) }}"
                                        class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.graduation.destroy', $graduation['id']) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá đợt {{ $graduation['dot_tot_nghiep'] }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu đợt tốt nghiệp</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($graduations->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-3 px-3 flex-column flex-sm-row gap-2">
                    @if ($showPaginationInfo)
                        <div class="text-muted small">
                            Hiển thị từ {{ $graduations->firstItem() }} đến {{ $graduations->lastItem() }} trong tổng số
                            {{ $graduations->total() }} đợt tốt nghiệp
                        </div>
                    @endif

                    <div class="custom-pagination">
                        @if ($graduations->lastPage() > 1)
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    {{-- Previous --}}
                                    <li class="page-item {{ $graduations->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $graduations->previousPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">&laquo;</a>
                                    </li>

                                    {{-- Page numbers --}}
                                    @for ($i = 1; $i <= $graduations->lastPage(); $i++)
                                        <li class="page-item {{ $graduations->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $graduations->url($i) }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next --}}
                                    <li class="page-item {{ !$graduations->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $graduations->nextPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .filter-popup {
            top: 100%;
            left: 0;
            z-index: 999;
            display: none;
            min-width: 230px;
        }

        .filter-popup.show {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('show'));
            const el = document.getElementById(id);
            el.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.filter-popup') && !event.target.closest('.bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('show'));
            }
        });
    </script>
@endpush
