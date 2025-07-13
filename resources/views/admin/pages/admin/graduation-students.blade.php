@extends('admin.layouts.master')

@section('title', 'Sinh viên đợt tốt nghiệp')

@section('content')
    <style>
        .filter-popup {
            display: none;
            min-width: 250px;
            z-index: 999;
        }

        .filter-popup.active {
            display: block !important;
        }
    </style>

    <div class="container py-4">
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Tốt nghiệp - Đợt tốt nghiệp</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.graduation.student', ['id' => $graduation->id]) }}">Danh sách sinh
                                viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $graduation->name }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.graduation.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th>STT</th>

                            {{-- Mã SV --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Mã SV</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-code')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-code"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="code" class="form-control"
                                                placeholder="VD: 698519" value="{{ request('code') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- Họ tên --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Họ tên</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-name')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-name"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="VD: Nguyễn Văn A" value="{{ request('name') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- Email --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Email</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-email')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-email"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" name="email" class="form-control"
                                                placeholder="VD: a@vnua.edu.vn" value="{{ request('email') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <th>Ngày cập nhật</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td>{{ $student->code ?? '—' }}</td>
                                <td>{{ $student->full_name ?? '—' }}</td>
                                <td>{{ $student->email ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger">Không có sinh viên nào trong đợt này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-3 px-3 flex-column flex-sm-row gap-2">
                    @if ($showPaginationInfo)
                        <div class="text-muted small">
                            Hiển thị từ {{ $students->firstItem() }} đến {{ $students->lastItem() }} trong tổng số
                            {{ $students->total() }} sinh viên
                        </div>
                    @endif

                    <div class="custom-pagination">
                        @if ($students->lastPage() > 1)
                            <nav>
                                <ul class="pagination justify-content-end mb-0">
                                    {{-- Previous --}}
                                    <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $students->previousPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">&laquo;</a>
                                    </li>

                                    {{-- Page numbers --}}
                                    @for ($i = 1; $i <= $students->lastPage(); $i++)
                                        <li class="page-item {{ $students->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $students->url($i) }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next --}}
                                    <li class="page-item {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $students->nextPageUrl() }}{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('active'));
            document.getElementById(id)?.classList.toggle('active');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.filter-popup') && !e.target.closest('.bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('active'));
            }
        });
    </script>
@endsection
