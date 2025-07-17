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
                    <small class="text-muted fst-italic">Thời gian khảo sát: {{ $survey->start_time }} –
                        {{ $survey->end_time }}</small>
                </p>
                @if ($outDate)
                    <div class="text-danger">Đã hết hạn khảo sát</div>
                @endif
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

            <form action="{{ route('survey.submit') }}" method="POST" id="form-wrapper">
                @csrf
                @method('POST')
                @include('admin.layouts.noti')
                <input type="hidden" name="mssv_verified" value="{{ old('mssv_verified') }}">

                <input type="hidden" name="survey_id" value="{{ $survey->id }}">
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div class="form-section">
                    <h6 class="fw-bold">Phần I. Thông tin cá nhân</h6>

                    <div class="mb-3">
                        <label for="ma_sv">1. Mã sinh viên</label>
                        <input type="text" class="form-control" id="code_student" name="code_student" value="622222"
                            readonly required placeholder="Nhập mã sinh viên">
                    </div>

                    <div class="mb-3">
                        <label for="ho_ten">2. Họ và tên</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required
                            placeholder="Nhập họ và tên đầy đủ">
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">3. Giới tính</label>
                            <input type="text" class="form-control" placeholder="Nam / Nữ" name="gender" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">4. Ngày sinh</label>
                            <input type="date" class="form-control" name="dob">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">5. Số căn cước công dân</label>
                        <input type="text" class="form-control mb-2" placeholder="Nhập số CCCD"
                            name="identification_card_number" required>
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" class="form-control mb-2" name="identification_issuance_date" required>
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" class="form-control" placeholder="Nhập nơi cấp"
                            name="identification_issuance_place" required>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">6. Khóa học</label>
                            <input type="text" class="form-control" placeholder="Nhập khóa học" name="course" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">7. Tên ngành đào tạo</label>
                            <select name="training_industry_id" class="form-control" required>
                                <option value="" readonly="readonly">-- select --</option>
                                @foreach ($major as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">8. Số điện thoại</label>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="phone_number"
                                required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">9. Email</label>
                            <input type="email" class="form-control" placeholder="Nhập email" name="email" required>
                        </div>
                    </div>

                    <!-- 10. Tình trạng việc làm hiện tại -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">10. Anh/Chị vui lòng cho biết tình trạng việc làm hiện
                            tại</label>
                        @php $tinh_trang = config('config.tinh_trang'); @endphp
                        @foreach ($tinh_trang as $index => $value)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="employment_status" required
                                    id="tt_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal"
                                    for="tt_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">11. Tên đơn vị tuyển dụng</label>
                        <input type="text" class="form-control" placeholder="Nhập tên công ty / tổ chức"
                            name="recruit_partner_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">12. Địa chỉ đơn vị</label>
                        <div class="form-text mb-3">vd: Khu 2 Hoàng Khương, Thanh Ba, Phú Thọ</div>
                        <input type="text" class="form-control mb-1" placeholder="Nhập địa chỉ cụ thể"
                            name="recruit_partner_address" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">13. Thời gian tuyển dụng</label>
                        <input type="date" class="form-control" placeholder="Nhập năm tuyển dụng (vd: 2025)"
                            name="recruit_partner_date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">14. Chức vụ, vị trí việc làm</label>
                        <input type="text" class="form-control"
                            placeholder="VD: Nhân viên kinh doanh, Trưởng phòng sale..." name="recruit_partner_position"
                            required>
                    </div>
                </div>

                {{-- PHẦN II: NỘI DUNG KHẢO SÁT --}}
                <h6 class="mb-4 fw-bold">Phần II: Nội dung khảo sát</h6>

                <!-- 15. Khu vực làm việc -->
                <div class="mb-4">
                    <label class="form-label fw-bold">15. Đơn vị Anh/Chị đang làm việc thuộc khu vực nào?</label>
                    @foreach (config('config.work_area') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="work_area" required
                                id="kv_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="kv_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 16. Thời gian có việc sau tốt nghiệp -->
                <div class="mb-4">
                    <label class="form-label fw-bold">16. Sau khi tốt nghiệp, Anh/Chị có việc làm từ khi nào?</label>
                    @foreach (config('config.employed_since') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="employed_since" required
                                id="tg_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="tg_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 17. Công việc có phù hợp với ngành đào tạo -->
                <div class="mb-4">
                    <label class="form-label fw-bold">17. Công việc Anh/Chị đang làm có phù hợp với ngành đào tạo
                        không?</label>
                    @foreach (config('config.trained_field') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="trained_field" required
                                id="nganh_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="nganh_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 18. Công việc có phù hợp với trình độ chuyên môn -->
                <div class="mb-4">
                    <label class="form-label fw-bold">18. Công việc Anh/Chị đang đảm nhận có phù hợp với trình độ chuyên
                        môn không?</label>
                    @foreach (config('config.professional_qualification_field') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="professional_qualification_field"
                                required id="trinhdo_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="trinhdo_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 19. Kiến thức kỹ năng từ trường có phù hợp công việc -->
                <div class="mb-4">
                    <label class="form-label fw-bold">19. Anh/Chị có học được kiến thức/kỹ năng cần thiết từ trường cho
                        công việc không?</label>
                    @foreach (config('config.level_knowledge_acquired') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="level_knowledge_acquired" required
                                id="kt_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="kt_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 20. Mức lương khởi điểm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">20. Mức lương khởi điểm (triệu đồng/tháng)</label>
                    <input type="text" class="form-control" name="starting_salary" placeholder="10" required>
                </div>

                <!-- 21. Mức thu nhập hiện tại -->
                <div class="mb-4">
                    <label class="form-label fw-bold">21. Mức thu nhập bình quân/tháng hiện nay (triệu đồng)</label>
                    @foreach (config('config.average_income') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="average_income" required
                                id="tn_{{ $key }}" value="{{ $key }}">
                            <label class="form-check-label fw-normal"
                                for="tn_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 22. Hình thức tìm được việc làm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">22. Anh/Chị tìm được việc làm thông qua những hình thức nào? <span
                            class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php $tim_viec = config('config.recruitment_type'); @endphp
                    @foreach ($tim_viec as $index => $value)
                        @if ($value == 'Khác')
                            <div class="form-check mb-2">
                                <input class="form-check-input recruitment_type_other" type="checkbox"
                                    name="recruitment_type[]" id="ht_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal" for="ht_{{ $index }}">Khác</label>
                            </div>
                        @else
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="recruitment_type[]"
                                    id="ht_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal"
                                    for="ht_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endif
                    @endforeach
                    {{-- Input ghi chú nếu chọn "Khác" --}}
                    <div id="recruitment_type_other_wrapper" style="display: none;" class="mt-2">
                        <input type="text" name="recruitment_type_other" id="recruitment_type_other"
                            class="form-control" placeholder="Nhập ghi chú cụ thể...">
                    </div>

                    <div id="recruitment_type_error" class="text-danger small d-none"></div>
                </div>

                <!-- 23. Hình thức tuyển -->
                <div class="mb-4">
                    <label class="form-label fw-bold">23. Anh/Chị được tuyển theo hình thức nào?</label>
                    @foreach (config('config.job_search_method') as $key => $item)
                        @if ($item == 'Khác')
                            <div class="form-check mb-2">
                                <input class="form-check-input job_search_method_other" type="checkbox"
                                    name="job_search_method[]" id="ht23_{{ $key }}"
                                    value="{{ $key }}">
                                <label class="form-check-label fw-normal" for="ht23_{{ $key }}">Khác</label>
                            </div>
                        @else
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="job_search_method[]"
                                    id="ht23_{{ $key }}" value="{{ $key }}">
                                <label class="form-check-label fw-normal"
                                    for="ht23_{{ $key }}">{{ $item }}</label>
                            </div>
                        @endif
                    @endforeach
                    {{-- Input ghi chú nếu chọn "Khác" --}}
                    <div id="job_search_method_other_wrapper" style="display: none;" class="mt-2">
                        <input type="text" name="job_search_method_other" id="job_search_method_other"
                            class="form-control" placeholder="">
                    </div>
                    <div id="job_search_method_error" class="text-danger small d-none"></div>
                </div>

                <!-- 24. Kỹ năng mềm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">24. Trong quá trình làm việc, Anh/Chị cần những kỹ năng mềm nào sau
                        đây? <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php $ky_nang = config('config.soft_skills_required'); @endphp
                    @foreach ($ky_nang as $index => $value)
                        @if ($value == 'Khác')
                            <div class="form-check mb-2">
                                <input class="form-check-input soft_skills_required_other" type="checkbox"
                                    name="soft_skills_required[]" id="ht_{{ $index }}"
                                    value="{{ $index }}">
                                <label class="form-check-label fw-normal" for="ht_{{ $index }}">Khác</label>
                            </div>
                        @else
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="soft_skills_required[]"
                                    id="kn_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal"
                                    for="kn_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endif
                    @endforeach
                    {{-- Input ghi chú nếu chọn "Khác" --}}
                    <div id="soft_skills_required_other_wrapper" style="display: none;" class="mt-2">
                        <input type="text" name="soft_skills_required_other" id="soft_skills_required_other"
                            class="form-control" placeholder="Nhập ghi chú cụ thể...">
                    </div>
                    <div id="soft_skills_required_error" class="text-danger small d-none"></div>
                </div>

                <!-- 25. Khóa học nâng cao -->
                <div class="mb-4">
                    <label class="form-label fw-bold">25. Sau khi được tuyển dụng, Anh/Chị có phải tham gia khóa học nâng
                        cao nào dưới đây để đáp ứng công việc không? <span class="fw-normal">(Có thể chọn nhiều lựa
                            chọn)</span></label>
                    @php $nang_cao = config('config.must_attended_courses'); @endphp
                    @foreach ($nang_cao as $index => $value)
                        @if ($value == 'Khác')
                            <div class="form-check mb-2">
                                <input class="form-check-input must_attended_courses_other" type="checkbox"
                                    name="must_attended_courses[]" id="ht_{{ $index }}"
                                    value="{{ $index }}">
                                <label class="form-check-label fw-normal" for="ht_{{ $index }}">Khác</label>
                            </div>
                        @else
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="must_attended_courses[]"
                                    id="nc_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal"
                                    for="nc_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endif
                    @endforeach
                    <div id="must_attended_courses_other_wrapper" style="display: none;" class="mt-2">
                        <input type="text" name="must_attended_courses_other" id="must_attended_courses_other"
                            class="form-control" placeholder="Nhập ghi chú cụ thể...">
                    </div>
                    <div id="must_attended_courses_error" class="text-danger small d-none"></div>
                </div>

                <!-- 26. Giải pháp nâng tỷ lệ có việc làm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">26. Theo Anh/Chị, những giải pháp nào sau đây giúp tăng tỷ lệ có việc
                        làm đúng ngành của sinh viên tốt nghiệp từ chương trình đào tạo mà Anh/Chị đã học? <span
                            class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php $giai_phap = config('config.solutions_get_job'); @endphp
                    @foreach ($giai_phap as $index => $value)
                        @if ($value == 'Khác')
                            <div class="form-check mb-2">
                                <input class="form-check-input solutions_get_job_other" type="checkbox"
                                    name="solutions_get_job[]" id="ht26_{{ $index }}"
                                    value="{{ $index }}">
                                <label class="form-check-label fw-normal" for="ht26_{{ $index }}">Khác</label>
                            </div>
                        @else
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="solutions_get_job[]"
                                    id="ht26_{{ $index }}" value="{{ $index }}">
                                <label class="form-check-label fw-normal"
                                    for="ht26_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endif
                    @endforeach
                    <div id="solutions_get_job_other_wrapper" style="display: none;" class="mt-2">
                        <input type="text" name="solutions_get_job_other" id="solutions_get_job_other"
                            class="form-control" placeholder="Nhập giải pháp khác của bạn tại đây...">
                    </div>
                    <div id="solutions_get_job_error" class="text-danger small d-none"></div>
                </div>

                <div>
                    <!-- Reminder to review -->
                    <div class="alert alert-warning mt-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Vui lòng kiểm tra kỹ thông tin trước khi gửi. Mỗi sinh viên chỉ được gửi phiếu khảo sát một lần.
                    </div>

                    <!-- Cảm ơn -->
                    <div class="text-center mt-4">
                        <p class="fw-semibold mb-1">Xin trân trọng cảm ơn sự hợp tác của Anh/Chị!</p>
                        <p class="text-muted fst-italic mb-3">Kính chúc Anh/Chị sức khỏe và thành công!</p>
                    </div>
                </div>

                @if (!$outDate)
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                @endif
            </form>
        </div>
    </div>


    <!-- 🛡️ Modal nhập MSSV -->
    <div class="modal fade" id="mssvModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <h5 class="modal-title">Xác thực Sinh viên <small style="font-size: 12px"><i>(điền ít nhất 2
                            input)</i></small></h5>

                <div class="text-danger small d-none" id="total-error"></div>

                <div class="modal-body">
                    <label for="">Mã sv <span class="text-danger">*</span></label>
                    <input type="text" id="input-mssv" class="form-control" placeholder="Nhập MSSV" name="m_mssv">
                    <div class="text-danger small d-none" id="mssv-error"></div>
                </div>
                <div class="modal-body">
                    <label for="">Email</label>
                    <input type="email" id="email" name="m_email" class="form-control" placeholder="Nhập email">
                    <div class="text-danger small d-none" id="email-error"></div>
                </div>
                <div class="modal-body">
                    <label for="">Phone</label>
                    <input type="text" id="phone" name="m_phone" class="form-control" placeholder="Nhập phone">
                    <div class="text-danger small d-none" id="phone-error"></div>
                </div>
                <div class="modal-body">
                    <label for="">CCCD</label>
                    <input type="text" id="citizen_identification" name="m_citizen_identification"
                        class="form-control" placeholder="Nhập CCCD">
                    <div class="text-danger small d-none" id="cccd-error"></div>
                </div>
                <div class="modal-body">
                    <label for="">Ngày sinh</label>
                    <input type="date" id="dob" class="form-control" name="m_dob">
                    <div class="text-danger small d-none" id="dob-error"></div>
                </div>
                <div class="modal-body">
                    <label for="">Ngành đào tạo</label>
                    @php
                        $major = \App\Models\Major::query()->get();
                    @endphp
                    <select name="m_training_industry_id" id="" class="form-control">
                        <option value="" readonly>--- Chọn ngành đào tạo ---</option>
                        @foreach ($major as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger small d-none" id="training_industry_id-error"></div>
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
        $(document).on('change', 'input[type=radio], input[type=checkbox]', function() {
            const $input = $(this);
            const isOther = $input.data('is-other') === true || $input.data('is-other') === 'true';

            // Với radio: ẩn tất cả các ô "Khác" cùng nhóm trước
            if ($input.attr('type') === 'radio') {
                const name = $input.attr('name');
                $(`input[name="${name}"]`).each(function() {
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verified = '{{ old('mssv_verified') }}';
            console.log(verified, '//verified')
            if (!verified) {
                const modalEl = document.getElementById('mssvModal');
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            }
        });

        $(document).ready(function() {
            $('#verify-mssv-btn').on('click', function() {
                const survey_id = $('input[name="survey_id"]').val().trim();
                const mssv = $('input[name="m_mssv"]').val().trim();
                const email = $('input[name="m_email"]').val().trim();
                const phone = $('input[name="m_phone"]').val().trim();
                const dob = $('input[name="m_dob"]').val().trim();
                const cccd = $('input[name="m_citizen_identification"]').val().trim();
                const nganh = $('select[name="m_training_industry_id"]').val().trim();

                const $error = $('#mssv-error');
                const $totalError = $('#total-error');
                $error.addClass('d-none');

                let filled = 0;

                if (email !== '') filled++;
                if (phone !== '') filled++;
                if (cccd !== '') filled++;
                if (dob !== '') filled++;
                if (nganh !== '') filled++;

                // if (!mssv) {
                //     $error.text('Vui lòng nhập Mã số sinh viên').removeClass('d-none');
                //     // return;
                // }

                if (mssv === '') {
                    alert('Vui lòng nhập mã sinh viên (MSSV).');
                    e.preventDefault();
                    return;
                }

                if (filled < 1) {
                    alert('Vui lòng nhập thêm ít nhất 1 thông tin ngoài MSSV để xác thực.');
                    e.preventDefault();
                }

                $.ajax({
                    url: '/api/khao-sat/verify-student',
                    method: 'POST',
                    data: {
                        survey_id: survey_id,
                        mssv: mssv,
                        email: email,
                        phone: phone,
                        dob: dob,
                        citizen_identification: cccd,
                        training_industry_id: nganh,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'mssvModal'));
                            modal.hide();
                            $('#form-wrapper').fadeIn();

                            // Đổ dữ liệu vào form
                            const data = res.student;
                            if (data) {
                                $('input[name="code_student"]').val(data.code);
                                $('input[name="full_name"]').val(data.full_name);
                                $('input[name="email"]').val(data.email);
                                $('input[name="phone_number"]').val(data.phone);
                                $('input[name="gender"]').val(data.gender);
                                $('input[name="dob"]').val(data.dob);
                                // Các input khác nếu có
                            }

                            // Truyền 1 hidden input flag
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'mssv_verified',
                                value: '1'
                            }).appendTo("form");

                            $('#p2').find(
                                'input[type=radio], input[type=checkbox], input[type=text], textarea'
                                ).prop('checked', false).val('');
                        } else {
                            $totalError.text(res.message || 'Không hợp lệ').removeClass(
                                'd-none');
                        }
                    },
                    error: function() {
                        $totalError.text('Đã có lỗi xảy ra, vui lòng thử lại.').removeClass(
                            'd-none');
                    }
                });
            });

            // 22
            $('.recruitment_type_other').on('change', function() {
                const wrapper = $('#recruitment_type_other_wrapper');
                const input = $('#recruitment_type_other');

                if ($(this).is(':checked')) {
                    wrapper.show();
                } else {
                    wrapper.hide();
                    input.val(''); // 👈 Reset nội dung đã nhập
                }
            });
            // 23
            $('.job_search_method_other').on('change', function() {
                const wrapper = $('#job_search_method_other_wrapper');
                const input = $('#job_search_method_other');

                if ($(this).is(':checked')) {
                    wrapper.show();
                } else {
                    wrapper.hide();
                    input.val(''); // 👈 Reset nội dung đã nhập
                }
            });

            // 24
            $('.soft_skills_required_other').on('change', function() {
                const wrapper = $('#soft_skills_required_other_wrapper');
                const input = $('#soft_skills_required_other');

                if ($(this).is(':checked')) {
                    wrapper.show();
                } else {
                    wrapper.hide();
                    input.val(''); // 👈 Reset nội dung đã nhập
                }
            });

            // 25
            $('.must_attended_courses_other').on('change', function() {
                const wrapper = $('#must_attended_courses_other_wrapper');
                const input = $('#must_attended_courses_other');

                if ($(this).is(':checked')) {
                    wrapper.show();
                } else {
                    wrapper.hide();
                    input.val(''); // 👈 Reset nội dung đã nhập
                }
            });

            // 26
            $('.solutions_get_job_other').on('change', function() {
                const wrapper = $('#solutions_get_job_other_wrapper');
                const input = $('#solutions_get_job_other');

                if ($(this).is(':checked')) {
                    wrapper.show();
                } else {
                    wrapper.hide();
                    input.val(''); // 👈 Reset nội dung đã nhập
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const otherGroups = [{
                    checkboxClass: '.recruitment_type_other',
                    wrapperId: '#recruitment_type_other_wrapper',
                    inputId: '#recruitment_type_other',
                    groupName: 'recruitment_type[]',
                    errorId: '#recruitment_type_error'
                },
                {
                    checkboxClass: '.job_search_method_other',
                    wrapperId: '#job_search_method_other_wrapper',
                    inputId: '#job_search_method_other',
                    groupName: 'job_search_method[]',
                    errorId: '#job_search_method_error'
                },
                {
                    checkboxClass: '.soft_skills_required_other',
                    wrapperId: '#soft_skills_required_other_wrapper',
                    inputId: '#soft_skills_required_other',
                    groupName: 'soft_skills_required[]',
                    errorId: '#soft_skills_required_error'
                },
                {
                    checkboxClass: '.must_attended_courses_other',
                    wrapperId: '#must_attended_courses_other_wrapper',
                    inputId: '#must_attended_courses_other',
                    groupName: 'must_attended_courses[]',
                    errorId: '#must_attended_courses_error'
                },
                {
                    checkboxClass: '.solutions_get_job_other',
                    wrapperId: '#solutions_get_job_other_wrapper',
                    inputId: '#solutions_get_job_other',
                    groupName: 'solutions_get_job[]',
                    errorId: '#solutions_get_job_error'
                }
            ];

            // Toggle input "Khác"
            otherGroups.forEach(group => {
                $(group.checkboxClass).on('change', function() {
                    if ($(this).is(':checked')) {
                        $(group.wrapperId).show();
                    } else {
                        $(group.wrapperId).hide();
                        $(group.inputId).val('');
                    }
                });
            });

            // Validate khi submit
            $('#form-wrapper').on('submit', function(e) {
                let hasError = false;

                otherGroups.forEach(group => {
                    const checkedCount = $(`input[name="${group.groupName}"]:checked`).length;
                    const isOtherChecked = $(group.checkboxClass).is(':checked');
                    const otherText = $(group.inputId).val().trim();

                    $(group.errorId).addClass('d-none').text('');

                    if (checkedCount < 1) {
                        $(group.errorId).removeClass('d-none').text(
                            'Vui lòng chọn ít nhất một lựa chọn.');
                        hasError = true;
                    }

                    if (isOtherChecked && otherText === '') {
                        $(group.errorId).removeClass('d-none').text(
                            'Vui lòng nhập ghi chú nếu chọn "Khác".');
                        hasError = true;
                    }
                });

                if (hasError) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
