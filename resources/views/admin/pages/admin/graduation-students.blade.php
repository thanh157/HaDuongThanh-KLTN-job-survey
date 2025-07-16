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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-0">Danh sách sinh viên - {{ $graduation['name'] }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.graduation.index') }}">Đợt tốt nghiệp</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách sinh viên</li>
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
                                                placeholder="VD: abc@sv.vnua.edu.vn" value="{{ request('email') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>
                            <th>Ngày sinh</th>
                            <th>Ngày cập nhật</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td>{{ $student['code'] ?? '—' }}</td>
                                <td>{{ $student['full_name'] ?? '—' }}</td>
                                <td>{{ $student['email'] ?? '—' }}</td>
                                <td>{{ $student['dob'] ? date('d-m-Y', strtotime($student['dob'])) : '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($student['created_at'])->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-danger">Không có sinh viên trong đợt này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
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
