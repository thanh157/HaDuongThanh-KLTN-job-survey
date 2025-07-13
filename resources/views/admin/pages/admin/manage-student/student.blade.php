@extends('admin.layouts.master')

@section('title', 'Danh sách cựu sinh viên')

@section('content')

    <style>
        tr[data-link] {
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        tr[data-link]:hover {
            background-color: #f0f4f8;
        }

        .view-detail-badge {
            position: absolute;
            top: 6px;
            right: 12px;
            background-color: rgba(13, 110, 253, 0.95);
            color: #fff;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            display: none;
            z-index: 2;
            pointer-events: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        tr[data-link]:hover .view-detail-badge {
            display: inline-block;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Quản lý thông tin cựu sinh viên</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.student.index') }}">Danh sách cựu sinh viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin tốt nghiệp</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center position-relative">
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
                                                placeholder="VD: example@vnua.edu.vn" value="{{ request('email') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <th>Ngày cập nhật</th>

                            {{-- Đợt tốt nghiệp --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Đợt tốt nghiệp</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1"
                                        onclick="toggleFilter('filter-graduation')" style="cursor:pointer;"></i>
                                    <div id="filter-graduation"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <input type="text" name="graduation_name" class="form-control mb-2"
                                            placeholder="VD: tháng 6/2024" value="{{ request('graduation_name') }}">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- Năm --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Năm</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1" onclick="toggleFilter('filter-year')"
                                        style="cursor:pointer;"></i>
                                    <div id="filter-year"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <input type="text" name="school_year" class="form-control mb-2"
                                            placeholder="VD: 2023" value="{{ request('school_year') }}">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- Ra trường --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Ra trường</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1"
                                        onclick="toggleFilter('filter-graduated-year')" style="cursor:pointer;"></i>
                                    <div id="filter-graduated-year"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <input type="number" name="graduated_years_ago" class="form-control mb-2"
                                            placeholder="VD: 2" value="{{ request('graduated_years_ago') }}">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            {{-- Số QĐ --}}
                            <th>
                                <form method="GET" class="position-relative d-inline-block">
                                    <span>Số QĐ</span>
                                    <i class="bi bi-funnel-fill text-primary ms-1"
                                        onclick="toggleFilter('filter-certification')" style="cursor:pointer;"></i>
                                    <div id="filter-certification"
                                        class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                        <input type="text" name="certification" class="form-control mb-2"
                                            placeholder="VD: 123/QĐ-HVN" value="{{ request('certification') }}">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($allStudents as $index => $item)
                           <tr data-link onclick="window.location='{{ route('admin.student.detail', ['id' => $item['id']]) }}';"

                                class="position-relative">
                                <td>
                                    {{ $allStudents->firstItem() + $index }}
                                    <div class="view-detail-badge">👁 Click để xem thông tin</div>
                                </td>
                                <td>{{ $item['code'] ?? '—' }}</td>
                                <td>{{ $item['full_name'] ?? '—' }}</td>
                                <td>{{ $item['email'] ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i') }}</td>
                                <td>{{ $item['graduation_name'] }}</td>
                                <td>{{ $item['school_year'] }}</td>
                                <td>{{ now()->year - (int) $item['school_year'] }} năm</td>
                                <td>{{ $item['certification'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">Không có sinh viên tốt nghiệp nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $allStudents->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
