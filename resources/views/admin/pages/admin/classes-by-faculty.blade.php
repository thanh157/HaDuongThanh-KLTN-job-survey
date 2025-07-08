{{-- @extends('admin.layouts.master')

@section('title', 'Lớp học theo khoa')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Danh sách lớp học</h4>

    <!-- Tìm kiếm -->
    <form method="GET" class="mb-4" style="max-width: 400px;">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Tìm kiếm lớp học..." value="{{ request('q') }}">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <!-- Danh sách lớp -->
    <div class="row">
        @forelse ($classes as $class)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $class['name'] }}</h5>
                        <p><i class="bi bi-calendar-event me-1"></i> Niên khóa: {{ $class['school_year'] }}</p>
                        <p><i class="bi bi-people-fill me-1"></i> Số SV: {{ $class['student_count'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Không tìm thấy lớp học nào.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection --}}
