@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa đợt khảo sát việc làm')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            min-height: 38px;
            max-height: 80px;
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                            <input type="text" class="form-control" name="title" required value="{{ $survey->title }}"
                                {{ $survey->isInActive() ? 'readonly' : '' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3" {{ $survey->isInActive() ? 'readonly' : '' }}>{{ $survey->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bắt đầu</label>
                                <input type="datetime-local" class="form-control" name="start_time" required
                                    {{ $survey->isInActive() ? 'readonly' : '' }}
                                    value="{{ old('start_time', \Carbon\Carbon::parse($survey->start_time)->format('Y-m-d\TH:i')) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kết thúc</label>
                                <input type="datetime-local" class="form-control" name="end_time" required
                                    {{ $survey->isInActive() ? 'readonly' : '' }}
                                    value="{{ old('end_time', \Carbon\Carbon::parse($survey->end_time)->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bên phải -->
                <div class="col-12 col-md-4">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin tốt nghiệp</h6>

                        <div class="mb-3">
                            <label class="form-label">Năm tốt nghiệp</label>
                            <select class="form-select" multiple id="school_years"
                                {{ $survey->isInActive() ? 'disabled' : '' }}>
                                @foreach ($namTotNghiep as $year)
                                    <option value="{{ $year }}"
                                        {{ in_array($year, $survey->graduations->pluck('school_year')->unique()->toArray()) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Đợt tốt nghiệp</label>
                            <select class="form-select" multiple name="graduation_id[]" id="graduation_id"
                                {{ $survey->isInActive() ? 'disabled' : '' }}>
                                @foreach ($allDotTotNghiep as $dot)
                                    <option value="{{ $dot->id }}"
                                        {{ in_array($dot->id, $selectedGraduationIds) ? 'selected' : '' }}>
                                        {{ $dot->name }} ({{ $dot->school_year }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <h6 class="mb-3">Trạng thái</h6>
                        <div class="mb-3">
                            <select class="form-select" name="status">
                                <option value="{{ \App\Models\Survey::STATUS_ACTIVE }}"
                                    {{ $survey->status == \App\Models\Survey::STATUS_ACTIVE ? 'selected' : '' }}>Hoạt động</option>
                                <option value="{{ \App\Models\Survey::STATUS_INACTIVE }}"
                                    {{ $survey->status == \App\Models\Survey::STATUS_INACTIVE ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('#school_years').select2();
            $('#graduation_id').select2();

            $('#school_years').on('change', function() {
                const selectedYears = $(this).val() ?? [];

                if (selectedYears.length === 0) {
                    $('#graduation_id').empty().trigger('change');
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.contact-survey.get-graduation-ceremonies') }}',
                    type: 'GET',
                    data: { years: selectedYears },
                    success: function(data) {
                        const currentSelected = $('#graduation_id').val() ?? [];
                        $('#graduation_id').empty();

                        data.forEach(item => {
                            const isSelected = currentSelected.includes(item.id.toString());
                            $('#graduation_id').append(
                                `<option value="${item.id}" ${isSelected ? 'selected' : ''}>
                                    ${item.name} (${item.school_year})
                                 </option>`
                            );
                        });

                        $('#graduation_id').trigger('change');
                    },
                    error: function() {
                        alert('Không thể tải đợt tốt nghiệp. Vui lòng thử lại!');
                    }
                });
            });

            @if ($survey->isInActive())
                $('#school_years, #graduation_id').on('select2:opening', function(e) {
                    e.preventDefault();
                });
            @endif
        });
    </script>
    @endpush

@endsection
