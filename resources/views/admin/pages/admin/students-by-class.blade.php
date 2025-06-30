@extends('admin.layouts.master')

@section('title', 'Danh sách sinh viên lớp ' . $classCode)

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Sinh viên - Lớp {{ $classCode }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.class-by-khoa', ['khoa' => substr($classCode, 0, 3)]) }}">Khóa
                                {{ substr($classCode, 0, 3) }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lớp {{ $classCode }}</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-4 text-end">
                <a href="{{ route('admin.class-by-khoa', ['khoa' => substr($classCode, 0, 3)]) }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th>STT</th>

                            <!-- Mã sinh viên -->
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

                            <!-- Họ tên -->
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

                            <!-- Email -->
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
                                                placeholder="VD: 698519@sv.vnua.edu.vn" value="{{ request('email') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td>{{ $student['code'] }}</td>
                                <td>{{ $student['full_name'] }}</td>
                                <td>{{ $student['email'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($student['created_at'])->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger">Không tìm thấy sinh viên nào trong lớp này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Popup filter CSS --}}
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

    {{-- JS toggle popup --}}
    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('active'));
            document.getElementById(id)?.classList.toggle('active');
        }

        // Tự đóng popup nếu click ra ngoài
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.filter-popup') && !e.target.closest('.bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('active'));
            }
        });
    </script>
@endsection
