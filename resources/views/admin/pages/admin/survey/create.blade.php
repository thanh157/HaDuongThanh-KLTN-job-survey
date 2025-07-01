@extends('admin.layouts.master')

@section('title', 'Tạo mới đợt khảo sát việc làm')

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
                                <label class="form-label">Thời gian bắt đầu khảo sát <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_time" required
                                       value="{{ old('start_time') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thời gian kết thúc khảo sát <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="end_time" required
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
                            <label class="form-label">Đợt tốt nghiệp <span class="text-danger">*</span></label>
                            <select class="form-select" name="graduation_id" required>
                                <option selected disabled value="">-- Chọn đợt --</option>
                                @foreach($dotTotNghiep as $dot)
                                    <option
                                        {{ old('graduation_id') == $dot->id ? "selected" : "" }} value="{{ $dot->id }}">{{ $dot->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-4 shadow-sm mt-4">
                <h6 class="mb-3">Câu hỏi khảo sát</h6>
                <div id="question-list"></div>

                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-question-btn">
                    <i class="bi bi-plus-circle me-1"></i> Thêm câu hỏi
                </button>
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


@push('script')
    <script>
        let questionIndex = 0;

        function renderQuestionBlock(index) {
            return `
                <div class="border p-3 mb-3 position-relative question-block">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="this.closest('.question-block').remove()">
                        <i class="bi bi-x"></i>
                    </button>

                    <div class="mb-2">
                        <label class="form-label">Nội dung câu hỏi</label>
                        <input type="text" name="questions[${index}][question_text]" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Loại câu hỏi</label>
                        <select name="questions[${index}][type]" class="form-select" onchange="toggleOptionBlock(this, ${index})" required>
                            <option value="single">Chọn 1</option>
                            <option value="multiple">Chọn nhiều</option>
                        </select>
                    </div>

                    <div class="option-area" id="options-${index}">
                        <label class="form-label">Danh sách lựa chọn</label>
                        <div class="option-group"></div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addOption(${index})">+ Thêm lựa chọn</button>
                    </div>
                </div>`;
        }

        function addOption(qIndex) {
            const optionHTML = `
                <div class="d-flex align-items-center mb-2 option-item">
                    <input type="text" name="questions[${qIndex}][options][]" class="form-control me-2" placeholder="Nội dung lựa chọn" required>
                    <div class="form-check me-2">
                        <input class="form-check-input" type="checkbox" name="questions[${qIndex}][is_other][]" value="1">
                        <label class="form-check-label">Khác</label>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentNode.remove()"><i class="bi bi-trash"></i></button>
                </div>
            `;
            $(`#options-${qIndex} .option-group`).append(optionHTML);
        }

        function toggleOptionBlock(select, index) {
            $(`#options-${index}`).toggle(select.value === 'single' || select.value === 'multiple');
        }

        $('#add-question-btn').on('click', function () {
            $('#question-list').append(renderQuestionBlock(questionIndex));
            addOption(questionIndex); // Thêm 1 option mặc định
            questionIndex++;
        });
    </script>
@endpush
