@extends('admin.layouts.master')

@section('title', 'Tạo mới đợt khảo sát việc làm')

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
    <script>
        $(document).ready(function() {
            $('#school_year').select2({
                placeholder: "-- Chọn năm tốt nghiệp --"
            });

            $('#graduation_id').select2({
                placeholder: "-- Chọn đợt tốt nghiệp --"
            });

            $('#school_year').on('change', function() {
                const selectedYears = $(this).val() || [];

                // XÓA NHỮNG ĐỢT KHÔNG CÒN THUỘC NĂM ĐÃ CHỌN
                $('#graduation_id option').each(function() {
                    const year = $(this).data('year');
                    if (!selectedYears.includes(year?.toString())) {
                        $(this).remove(); // xoá các đợt không thuộc năm đã chọn
                    }
                });

                // GỌI API để lấy các đợt thuộc năm mới được chọn
                $.ajax({
                    url: "{{ route('admin.contact-survey.get-graduation-ceremonies') }}",
                    method: 'GET',
                    data: {
                        years: selectedYears
                    },
                    success: function(data) {
                        data.forEach(function(item) {
                            // Nếu chưa có đợt tốt nghiệp này thì mới thêm vào
                            const exists = $(
                                    `#graduation_id option[value="${item.id}"]`)
                                .length > 0;
                            if (!exists) {
                                const newOption = new Option(
                                    `${item.name} (${item.school_year})`, item.id,
                                    false, false);
                                $(newOption).attr('data-year', item.school_year);
                                $('#graduation_id').append(newOption);
                            }
                        });

                        $('#graduation_id').trigger('change');
                    },
                    error: function() {
                        alert('Lỗi khi lấy đợt tốt nghiệp!');
                    }
                });
            });
        });
    </script>
@endpush


@section('content')
    <div class="container py-4">
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Đợt khảo sát - Tạo mới</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.contact-survey.index') }}">Đợt khảo sát việc
                                làm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.contact-survey.index') }}" class="btn btn-primary">
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

        <form action="{{ route('admin.contact-survey.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Cột trái -->
                <div class="col-12 col-md-8">
                    <div class="card p-4 shadow-sm h-100">
                        <h6 class="mb-3">Thông tin chung</h6>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="start_time" required
                                    value="{{ old('start_time') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="end_time" required
                                    value="{{ old('end_time') }}">
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
                            <select class="form-select" name="school_year[]" id="school_year" required multiple>
                                @foreach ($namTotNghiep as $nam)
                                    <option {{ collect(old('school_year'))->contains($nam) ? 'selected' : '' }}
                                        value="{{ $nam }}">{{ $nam }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Đợt tốt nghiệp <span class="text-danger">*</span></label>
                            <select class="form-select" name="graduation_id[]" id="graduation_id" required
                                multiple></select>
                        </div>

                        <small class="text-danger"><i>Vui lòng kiểm tra kỹ trước khi tạo!</i></small>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Tạo
                </button>
            </div>
        </form>
    </div>
@endsection
