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

            <div class="card p-4 shadow-sm mt-4">
                <h6 class="mb-3">Câu hỏi khảo sát</h6>
                <div id="question-list">
                    @foreach($survey->questions as $qIndex => $question)
                        <div class="border p-3 mb-3 position-relative question-block">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="this.closest('.question-block').remove()">
                                <i class="bi bi-x"></i>
                            </button>

                            <div class="mb-2">
                                <label class="form-label">Nội dung câu hỏi</label>
                                <input type="text" name="questions[{{ $qIndex }}][question_text]" class="form-control" required
                                       value="{{ $question->question_text }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Loại câu hỏi</label>
                                <select name="questions[{{ $qIndex }}][type]" class="form-select" required>
                                    <option value="single" {{ $question->type == 'single' ? 'selected' : '' }}>Chọn 1</option>
                                    <option value="multiple" {{ $question->type == 'multiple' ? 'selected' : '' }}>Chọn nhiều</option>
                                </select>
                            </div>

                            <div class="option-area" id="options-{{ $qIndex }}">
                                <label class="form-label">Danh sách lựa chọn</label>
                                <div class="option-group">
                                    @foreach($question->options as $optIndex => $opt)
                                        <div class="d-flex align-items-center mb-2 option-item">
                                            <input type="text" name="questions[{{ $qIndex }}][options][]" class="form-control me-2"
                                                   value="{{ $opt['text'] }}" required>
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="checkbox"
                                                       name="questions[{{ $qIndex }}][is_other][{{ $optIndex }}]" value="1"
                                                    {{ isset($opt['is_other']) && $opt['is_other'] ? 'checked' : '' }}>
                                                <label class="form-check-label">Khác</label>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentNode.remove()">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2"
                                        onclick="addOption({{ $qIndex }})">+ Thêm lựa chọn</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-question-btn">
                    <i class="bi bi-plus-circle me-1"></i> Thêm câu hỏi
                </button>
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


@push('script')
    <script>
        let questionIndex = {{ $survey->questions->count() }};

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
