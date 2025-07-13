@extends('admin.layouts.master')

@section('title', 'Tạo mới đợt khảo sát việc làm')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            min-height: 38px;
            max-height: 80px; /* hoặc 100px tùy độ dài */
            overflow-y: auto;
            padding-bottom: 4px;
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            white-space: normal;
            overflow-x: hidden;
            flex-wrap: wrap;
            max-height: 100px;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/admin/js/survey/index.js') }}"></script>
@endpush

@section('content')

    <div class="container py-4">
        <!-- Tiêu đề và breadcrumb -->
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Đợt khảo sát - Tạo mới</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="#">Đợt khảo sát việc làm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
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

    <!-- Form chỉ giao diện -->
        <form action="{{ route('admin.survey.store') }}" method="post">
            @method('post')
            @csrf
            <div class="row g-4">
                <!-- Cột trái -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin chung</h6>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title"
                                   placeholder="Tiêu đề đợt khảo sát việc làm" required value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Nội dung mô tả">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bắt đầu<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="start_time" required value="{{ old('start_time') }}">


                                @error('start_time')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kết thúc<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="end_time" required value="{{ old('end_time') }}">

                                @error('end_time')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin tốt nghiệp</h6>

                        <div class="mb-3">
                            <label class="form-label">Năm tốt nghiệp <span class="text-danger">*</span></label>
                            <select class="form-select" name="school_year" required id="school_year">
                                <option selected disabled value="">-- Chọn năm --</option>
                                @foreach($namTotNghiep as $nam)
                                    <option {{ old('school_year') == $nam ? "selected" : "" }} value="{{ $nam }}">{{ $nam }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Đợt tốt nghiệp <span class="text-danger">*</span></label>
                            <select class="form-select" name="graduation_id[]" required multiple id="graduation_id">
                            </select>
                        </div>
                        <small class="text-danger"><i>Vui lòng chọn cẩn thận vì bạn không thể sửa 'thông tin tốt nghiệp' này</i></small>
                    </div>

                </div>
            </div>

            <!-- Nút -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Tạo
                </button>
            </div>
        </form>
    </div>
@endsection
