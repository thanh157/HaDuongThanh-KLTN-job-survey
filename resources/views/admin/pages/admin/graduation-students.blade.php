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
            <h4 class="fw-bold mb-0">Danh sách sinh viên - {{ $graduation['name'] }}</h4>
            <a href="{{ route('admin.graduation.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.graduation.index') }}">Đợt tốt nghiệp</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách sinh viên</li>
            </ol>
        </nav>
        <br>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <td>STT</td>
                            <td>Mã SV</td>
                            <td>Họ tên</td>
                            <td>Email</td>
                            <td>Ngày sinh</td>
                            <td>Ngày tạo</td>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td> {{-- STT --}}
                                <td>{{ $student['code'] ?? '—' }}</td>
                                <td>{{ $student['full_name'] ?? '—' }}</td>
                                <td>{{ $student['email'] ?? '—' }}</td>
                                <td>{{ $student['dob'] ? date('d-m-Y', strtotime($student['dob'])) : '—' }}</td>
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
