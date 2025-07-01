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
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Mã SV</td>
                            <td>Họ tên</td>
                            <td>Email</td>
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
