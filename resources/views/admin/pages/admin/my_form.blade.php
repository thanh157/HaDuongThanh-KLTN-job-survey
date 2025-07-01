@extends('admin.layouts.no-master')

@section('title', 'Form-student')

@section('content')
    <style>
        body {
            background-color: #f1f3f4;
        }

        .google-form-style {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .google-form-style .form-section {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .google-form-style label {
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .google-form-style input {
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        .google-form-style input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }
    </style>


    <!-- 🧾 Form khảo sát chính (ẩn lúc đầu) -->


    <div class="container py-4">
        <div class="google-form-style ">
            <!-- Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
                <h6 class="fw-bold mb-1 text-uppercase">Bộ Nông Nghiệp và Phát Triển Nông Thôn</h6>
                <p class="mb-1 text-uppercase fw-semibold">Học Viện Nông Nghiệp Việt Nam</p>
                <small class="text-muted fst-italic">Thị trấn Trâu Quỳ, huyện Gia Lâm, TP Hà Nội | ĐT: 024.62617586
                    –
                    Fax:
                    024.62617586</small>
            </div>

            <!-- Title -->
            <div class="form-section">
                <h5 class="fw-bold text-center">{{ $survey->title }}</h5>
                <p class="text-justify">
                    {{ $survey->description }}
                </p>
                <p class="text-end mt-2">
                    <small class="text-muted fst-italic">Thời gian khảo sát: {{ $survey->start_time }} – {{ $survey->end_time }}</small>
                </p>
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

            <!-- Form Start -->
            <form action="{{ route("survey.submit") }}" method="POST" id="form-wrapper">
                @csrf
                @method('POST')
                @include('admin.layouts.noti')

                <!-- Gắn thêm -->
                <input type="hidden" name="survey_id" value="{{ $survey->id }}">
                <input type="hidden" name="student_id" id="student_id" value="">
                    <input type="hidden" name="mssv_verified" value="{{ old('mssv_verified') }}">


                    <div class="form-section">
                    <h6 class="fw-bold">Phần I. Thông tin cá nhân</h6>

                    <div class="mb-3">
                        <label for="ho_ten">1. Họ và tên</label>
                        <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ và tên đầy đủ" value="{{ old('ho_ten') }}">
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">3. Giới tính</label>
                            <input type="text" class="form-control" placeholder="Nam / Nữ" name="gender">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">4. Ngày sinh</label>
                            <input type="date" class="form-control" name="birthday">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ma_sv">4. Mã sinh viên</label>
                        <input type="text" class="form-control" id="ma_sv" name="ma_sv" value="{{ old('ma_sv') }}"
                               placeholder="Nhập mã sinh viên" oninput="setKhoaHocFromMaSV()">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">5. Số căn cước công dân</label>
                        <input type="text" class="form-control mb-2" placeholder="Nhập số CCCD" name="cccd">
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" class="form-control mb-2" name="ngay_cap">
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" class="form-control" placeholder="Nhập nơi cấp" name="noi_cap">
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">6. Khóa học</label>
                            <input type="text" class="form-control" id="khoa_hoc" name="khoa_hoc"
                                   placeholder="Khóa học sẽ tự động hiển thị">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="major" class="form-label">Ngành đào tạo</label>
                            <select class="form-select" name="major" id="major">
                                <option value="">-- Chọn ngành đào tạo --</option>

                                @isset($majors)
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                                    @endforeach
                                @endisset

                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">8. Số điện thoại</label>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">9. Email</label>
                            <input type="email" class="form-control" placeholder="Nhập email" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                {{-- chưa api major được --}}
                <!-- 10. Tình trạng việc làm hiện tại -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">10. Anh/Chị vui lòng cho biết tình trạng việc làm hiện tại của Anh/chị</label>
                        @php $tinh_trang = ['Đã có việc làm', 'Tiếp tục học', 'Chưa có việc làm']; @endphp
                        @foreach ($tinh_trang as $index => $value)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vieclam_hientai"
                                       id="tt_{{ $index }}" value="{{ $value }}">
                                <label class="form-check-label fw-normal"
                                       for="tt_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">11. Cơ quan công tác</label>
                        <input type="text" class="form-control" placeholder="Nhập tên công ty / tổ chức" name="coquan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">12. Địa chỉ cơ quan</label>
                        <div class="form-text mb-3">vd: Khu 2 Hoàng Khương, Thanh Ba, Phú Thọ</div>
                        <input type="text" class="form-control mb-1" placeholder="Nhập địa chỉ cụ thể" name="dia_chi_co_quan">
                        <label class="form-label">Địa chỉ đơn vị thuộc Tỉnh/Thành phố</label>
                        <input type="text" class="form-control" placeholder="Nhập Tỉnh/Thành phố" name="thanhpho">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">13. Chức vụ, vị trí việc làm</label>
                        <input type="text" class="form-control"
                               placeholder="VD: Nhân viên kinh doanh, Trưởng phòng sale..." name="chucvu">
                    </div>
                </div>

                {{-- PHẦN II: NỘI DUNG KHẢO SÁT --}}
                <h6 class="mb-4 fw-bold">Phần II: Nội dung khảo sát</h6>

                <div class="p2">
                    @foreach($survey->questions as $qIndex => $question)
                        <div class="form-section mb-4">
                            <label class="form-label fw-semibold">{{ $loop->iteration }}
                                . {{ $question->question_text }}</label>

                            @if($question->type === 'single')
                                @foreach($question->options as $optIndex => $option)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="answers[{{ $question->id }}]"
                                               id="q{{ $question->id }}_{{ $optIndex }}"
                                               value="{{ $option['text'] }}"
                                               data-is-other="{{ $option['is_other'] ? 'true' : 'false' }}">
                                        <label class="form-check-label" for="q{{ $question->id }}_{{ $optIndex }}">
                                            {{ $option['text'] }}
                                        </label>
                                        @if($option['is_other'])
                                            <input type="text"
                                                   class="form-control mt-2 d-none other-input"
                                                   name="answers_other[{{ $question->id }}]"
                                                   placeholder="Vui lòng ghi rõ lý do...">
                                        @endif
                                    </div>
                                @endforeach
                            @elseif($question->type === 'multiple')
                                @foreach($question->options as $optIndex => $option)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="answers[{{ $question->id }}][]"
                                               id="q{{ $question->id }}_{{ $optIndex }}"
                                               value="{{ $option['text'] }}"
                                               data-is-other="{{ $option['is_other'] ? 'true' : 'false' }}">
                                        <label class="form-check-label" for="q{{ $question->id }}_{{ $optIndex }}">
                                            {{ $option['text'] }}
                                        </label>
                                        @if($option['is_other'])
                                            <input type="text"
                                                   class="form-control mt-2 d-none other-input"
                                                   name="answers_other[{{ $question->id }}][]"
                                                   placeholder="Vui lòng ghi rõ lý do...">
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Lời kết -->
                <div class="text-center mt-4">
                    {{-- <p class="fw-semibold mb-1"></p> --}}
                    <p class="text-muted fst-italic mb-3">Xin trân trọng cảm ơn!</p>
                </div>

                <!-- Submit button -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="bi bi-send me-1"></i> Gửi phản hồi
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- 🛡️ Modal nhập MSSV -->
    <div class="modal fade" id="mssvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <h5 class="modal-title">Xác thực Sinh viên</h5>
                <div class="modal-body">
                    <input type="text" id="input-mssv" class="form-control" placeholder="Nhập MSSV">
                    <div class="text-danger small d-none" id="mssv-error"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="verify-mssv-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOtherInput(checkbox, targetId = 'other_input_box') {
            const inputBox = document.getElementById(targetId);
            const inputField = inputBox?.querySelector('input, textarea');
            if (checkbox.checked) {
                inputBox.style.display = 'block';
            } else {
                inputBox.style.display = 'none';
                if (inputField) inputField.value = '';
            }
        }

        function setKhoaHocFromMaSV() {
            const maSV = document.getElementById('ma_sv').value;
            const khoaHocInput = document.getElementById('khoa_hoc');

            if (maSV.length >= 2 && !isNaN(maSV)) {
                const khoa = maSV.substring(0, 2);
                khoaHocInput.value = 'Khóa ' + khoa;
            } else {
                khoaHocInput.value = '';
            }
        }
    </script>
@endsection

@push('script')
    <script>
        $(document).on('change', 'input[type=radio], input[type=checkbox]', function () {

            console.log('xxx')

            const $input = $(this);
            const isOther = $input.data('is-other') === true || $input.data('is-other') === 'true';

            // Với radio: ẩn tất cả các ô "Khác" cùng nhóm trước
            if ($input.attr('type') === 'radio') {
                const name = $input.attr('name');
                $(`input[name="${name}"]`).each(function () {
                    $(this).closest('.form-check').find('.other-input').addClass('d-none');
                });
            }

            // Nếu là "Khác" và được chọn → show ô nhập
            if (isOther && $input.is(':checked')) {
                $input.closest('.form-check').find('.other-input').removeClass('d-none').focus();
            } else if (!isOther && $input.attr('type') === 'radio') {
                // Nếu chọn lại đáp án thường → ẩn lại
                $input.closest('.form-check').find('.other-input').addClass('d-none');
            }

            // Với checkbox: toggle ô input ngay cùng nhóm theo checked
            if ($input.attr('type') === 'checkbox' && isOther) {
                const otherInput = $input.closest('.form-check').find('.other-input');
                if ($input.is(':checked')) {
                    otherInput.removeClass('d-none').focus();
                } else {
                    otherInput.addClass('d-none');
                }
            }
        });
    </script>

    !-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const verified = '{{ old('mssv_verified') }}';
            if (!verified) {
                const modalEl = document.getElementById('mssvModal');
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }
        });

        $(document).ready(function () {
            const graduationId = {{ $survey->graduation_id }};

            $('#verify-mssv-btn').on('click', function () {
                const mssv = $('#input-mssv').val().trim();
                const $error = $('#mssv-error');
                $error.addClass('d-none');

                if (!mssv) {
                    $error.text('Vui lòng nhập Mã số sinh viên').removeClass('d-none');
                    return;
                }

                $.ajax({
                    url: '/api/khao-sat/verify-student',
                    method: 'POST',
                    data: {
                        mssv: mssv,
                        graduation_id: graduationId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (res.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('mssvModal'));
                            modal.hide();
                            $('#form-wrapper').fadeIn();

                            // Đổ dữ liệu vào form
                            const data = res.student;
                            if (data) {
                                $('#ho_ten').val(data.ho_ten);
                                $('#ma_sv').val(data.ma_sv);
                                $('#email').val(data.email);
                                $('#student_id').val(data.id);
                                // Các input khác nếu có
                            }

                            // Truyền 1 hidden input flag
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'mssv_verified',
                                value: '1'
                            }).appendTo("form");

                            $('#p2').find('input[type=radio], input[type=checkbox], input[type=text], textarea').prop('checked', false).val('');
                        } else {
                            $error.text(res.message || 'MSSV không hợp lệ').removeClass('d-none');
                        }
                    },
                    error: function () {
                        $error.text('Đã có lỗi xảy ra, vui lòng thử lại.').removeClass('d-none');
                    }
                });
            });
        });
    </script>


@endpush
