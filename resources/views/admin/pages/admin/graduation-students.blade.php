@extends('admin.layouts.master')

@section('title', 'Sinh viên đợt tốt nghiệp')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Danh sách sinh viên - {{ $graduation['name'] }}</h4>
            <a href="{{ route('admin.graduation.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light text-center text-nowrap">
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
                                                placeholder="VD: 621066" value="{{ request('code') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <!-- Tên -->
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
                                                placeholder="VD: 621066@sv.vnua.edu.vn" value="{{ request('email') }}">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Lọc</button>
                                    </div>
                                </form>
                            </th>

                            <th>Ngày tạo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td> {{-- STT --}}
                                <td>{{ $student['code'] ?? '—' }}</td>
                                <td>{{ $student['full_name'] ?? '—' }}</td>
                                <td>{{ $student['email'] ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($student['created_at'])->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Không có sinh viên trong đợt này.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-3">
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
