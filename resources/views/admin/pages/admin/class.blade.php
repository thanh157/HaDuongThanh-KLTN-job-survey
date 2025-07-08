@extends('admin.layouts.master')

@section('title', 'Lớp học')

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

        /* .class-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: #0d6efd;
        } */

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

        .class-card p,
        .class-card ul,
        .class-card li {
            color: #212529;
            font-size: 14px;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }

        .class-card ul li i {
            color: #212529;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .class-card:hover ul li i {
            transform: scale(1.05);
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

        .search-bar input:focus {
            outline: none;
        }

        .search-bar .search-btn {
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 0 18px;
            height: 44px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            border-radius: 0 99px 99px 0;
        }

        .search-bar .search-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 767.98px) {
            form.ms-auto {
                width: 100% !important;
            }
        }
    </style>

    <div class="container py-4">
        <!-- Tiêu đề và Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Quản lí chung - Lớp học</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách lớp học</li>
                    </ol>
                </nav>
            </div>

            <!-- Thanh tìm kiếm -->
            <form method="GET" class="ms-auto" style="width: 100%; max-width: 400px;">
                <div class="input-group shadow-sm search-bar">
                    <input type="text" name="search" class="form-control ps-4"
                        placeholder="Tìm kiếm theo khóa hoặc năm..." value="{{ request('search') }}">
                    <button class="btn search-btn" type="submit">
                        <i class="bi bi-search fs-5"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Danh sách lớp học -->
        <div class="row gy-4">
            @php
                $keyword = request('search');
                $filtered = collect($classes)->filter(function ($class) use ($keyword) {
                    if (!$keyword) {
                        return true;
                    }
                    return stripos($class['khoa'], $keyword) !== false || stripos($class['nam'], $keyword) !== false;
                });
            @endphp

            @forelse ($filtered as $class)
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('admin.class.by-khoa', ['khoa' => $class['id']]) }}" class="text-decoration-none">
                        <div class="card class-card h-100">
                            <div class="card-body position-relative">
                                <h5 class="mb-2">{{ $class['khoa'] }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-calendar3 me-1"></i> Năm: {{ $class['nam'] }}
                                </p>
                                <ul class="list-unstyled small mb-0">
                                    <li class="mb-1"><i class="bi bi-diagram-3-fill text-secondary me-2"></i> Tổng số lớp:
                                        {{ $class['tong_so_lop'] }}</li>
                                    <li class="mb-1"><i class="bi bi-person-plus-fill text-success me-2"></i> Nhập học:
                                        {{ $class['nhap_hoc'] }}</li>
                                    <li><i class="bi bi-people-fill text-info me-2"></i> Hiện tại: {{ $class['hien_tai'] }}
                                    </li>
                                </ul>
                                <div class="access-text">Truy cập →</div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle me-1"></i> Không tìm thấy lớp học nào phù hợp.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
