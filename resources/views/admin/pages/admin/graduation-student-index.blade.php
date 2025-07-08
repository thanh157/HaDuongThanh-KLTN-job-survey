@extends('admin.layouts.master')

@section('title', 'Danh sách sinh viên tốt nghiệp')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Danh sách sinh viên - Đợt {{ $graduationId }}</h4>
        <a href="{{ route('admin.graduation-student.create', $graduationId) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Thêm sinh viên
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th>Ngành</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student['ma_sv'] }}</td>
                            <td>{{ $student['ho_ten'] }}</td>
                            <td>{{ $student['lop'] }}</td>
                            <td>{{ $student['nganh'] }}</td>
                            <td>{{ $student['email'] }}</td>
                            <td>{{ $student['sdt'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($student['created_at'])->format('H:i d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Chưa có sinh viên nào trong đợt này.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
