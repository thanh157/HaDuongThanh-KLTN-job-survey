@extends('admin.layouts.master')

@section('title', 'Lớp thuộc ' . $khoa)

@section('content')
    <style>
        .class-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 16px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            position: relative;
            overflow: hidden;
        }

        .class-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(13, 110, 253, 0.03);
            transition: left 0.5s ease;
            z-index: 0;
        }

        .class-card:hover::before {
            left: 0;
        }

        .class-card h5 {
            color: #0d6efd;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .class-card p {
            color: #212529;
            font-size: 14px;
            font-weight: 400;
            z-index: 1;
            position: relative;
        }

        .class-card .access-text {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            font-size: 14px;
            color: #0d6efd;
            position: absolute;
            bottom: 16px;
            right: 16px;
            z-index: 1;
            font-weight: 500;
        }

        .class-card:hover .access-text {
            opacity: 1;
            transform: translateY(0);
        }

        .search-bar {
            border-radius: 999px;
            overflow: hidden;
            display: flex;
            align-items: center;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        .search-bar input {
            border: none;
            box-shadow: none !important;
            font-size: 14px;
            height: 44px;
        }

        .search-bar .search-btn {
            background: #b1fd0d;
            color: #fff;
            border: none;
            padding: 0 18px;
            height: 44px;
            border-radius: 0 99px 99px 0;
        }

        .search-bar .search-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Lớp học - Khóa {{ $khoa }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Khóa {{ $khoa }}</li>
                    </ol>
                </nav>
            </div>

            <!-- Search -->
            <form method="GET" class="ms-auto" style="width: 100%; max-width: 400px;">
                <div class="input-group shadow-sm search-bar">
                    <input type="text" name="search" class="form-control ps-4" placeholder="Tìm kiếm lớp..."
                        value="{{ request('search') }}">
                    <button class="btn search-btn" type="submit">
                        <i class="bi bi-search fs-5"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row gy-4">
            @forelse ($classes as $class)
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('admin.class.students', ['code' => $class['code']]) }}" class="text-decoration-none">
                        <div class="card class-card h-100">
                            <div class="card-body position-relative">
                                <h5 class="mb-2">{{ $class['code'] }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="bi bi-book me-1"></i> {{ $class['description'] }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar3 me-1"></i> Ngày cập nhật:
                                    {{ \Carbon\Carbon::parse($class['created_at'])->format('d/m/Y') }}
                                </p>
                                <p class="text-muted mb-0 mt-1">
                                    <i class="bi bi-people me-1"></i> Số sinh viên: {{ $class['student_count'] ?? 0 }}
                                </p>

                                <div class="access-text">Xem sinh viên →</div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle me-1"></i> Không có lớp học nào phù hợp với từ khóa bạn tìm.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        @if ($classes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $classes->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <div class="mt-4 text-end">
            <a href="{{ route('admin.class.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>
    </div>
@endsection
