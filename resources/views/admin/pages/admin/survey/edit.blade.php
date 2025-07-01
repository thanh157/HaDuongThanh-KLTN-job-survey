@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa đợt khảo sát việc làm')

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb và tiêu đề -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Đợt khảo sát - Chỉnh sửa</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="#">Đợt khảo sát việc làm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.survey.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif

    <!-- Form -->
        <form action="{{ route('admin.survey.update', $survey->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- Bên trái -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin chung</h6>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="title" required value="{{ $survey->title }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3">{{ $survey->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bắt đầu khảo sát</label>
                                <input type="date" class="form-control" name="start_time" required
                                       value="{{ \Carbon\Carbon::parse($survey->start_time)->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kết thúc khảo sát</label>
                                <input type="date" class="form-control" name="end_time" required
                                       value="{{ \Carbon\Carbon::parse($survey->end_time)->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bên phải -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin tốt nghiệp</h6>
                        <div class="mb-3">
                            <label class="form-label">Đợt tốt nghiệp</label>
                            <select class="form-select" name="graduation_id" required>
                                <option disabled value="">-- Chọn đợt --</option>
                                @foreach($dotTotNghiep as $dot)
                                    <option value="{{ $dot->id }}" {{ $survey->graduation_id == $dot->id ? 'selected' : '' }}>
                                        {{ $dot->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
@endsection
