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

    <div class="container py-4">
        <div class="google-form-style ">
            <!-- Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
                <h6 class="fw-bold mb-1 text-uppercase">Bộ Nông Nghiệp và Phát Triển Nông Thôn</h6>
                <p class="mb-1 text-uppercase fw-semibold">Học Viện Nông Nghiệp Việt Nam</p>
                <small class="text-muted fst-italic">Thị trấn Trâu Quỳ, huyện Gia Lâm, TP Hà Nội | ĐT: 024.62617586 – Fax:
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

            <!-- Form Start -->
            <form>
                <div class="form-section">
                    <h6 class="fw-bold">Phần I. Thông tin cá nhân</h6>

                    <div class="mb-3">
                        <label for="ho_ten">1. Họ và tên</label>
                        <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                               placeholder="Nhập họ và tên đầy đủ" value="{{ $response->full_name }}" readonly>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">3. Giới tính</label>
                            <input type="text" class="form-control" value="{{$response->gender == 'male' ? 'Nam' : 'Nữ' }}" readonly>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">4. Ngày sinh</label>
                            <input type="date" class="form-control" value="{{ $response->dob }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ma_sv">4. Mã sinh viên</label>
                        <input type="text" class="form-control" value="{{ $response->code_student }}" placeholder="Nhập mã sinh viên" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">5. Số căn cước công dân</label>
                        <input type="text" class="form-control mb-2" placeholder="Nhập số CCCD" value="{{ $response->identification_card_number }}" readonly>
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" class="form-control mb-2" value="{{ $response->identification_issuance_date }}">
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" class="form-control" placeholder="Nhập nơi cấp" value="{{ $response->identification_issuance_place }}" readonly>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">6. Khóa học</label>
                            <input type="text" class="form-control" id="khoa_hoc" name="khoa_hoc" value="{{ $response->course }}"
                                   placeholder="Khóa học sẽ tự động hiển thị" readonly>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">7. Tên ngành đào tạo</label>
                            <input type="text" class="form-control" readonly value="{{ !empty($major[$response->training_industry_id]) ? $major[$response->training_industry_id] : "" }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">8. Số điện thoại</label>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại" value="{{ $response->phone_number }}" readonly>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">9. Email</label>
                            <input type="email" class="form-control" placeholder="Nhập email" value="{{ $response->email }}" readonly>
                        </div>
                    </div>

                    <!-- 10. Tình trạng việc làm hiện tại -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">10. Anh/Chị vui lòng cho biết tình trạng việc làm hiện tại</label>
                        @php $tinh_trang = config('config.tinh_trang'); @endphp
                        @foreach ($tinh_trang as $index => $value)
                            <div class="form-check mb-2">
                                <input class="form-check-input" disabled type="radio" name="employment_status"
                                       id="tt_{{ $index }}" value="{{ $index }}" {{ $index == $response->employment_status ? "checked" : "" }}>
                                <label class="form-check-label fw-normal"
                                       for="tt_{{ $index }}">{{ $value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">11. Tên đơn vị tuyển dụng</label>
                        <input type="text" class="form-control" placeholder="Nhập tên công ty / tổ chức" value="{{ $response->recruit_partner_name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">12. Địa chỉ đơn vị</label>
                        <input type="text" class="form-control mb-1" placeholder="Nhập địa chỉ cụ thể" value="{{ $response->recruit_partner_address }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">13. Thời gian tuyển dụng</label>
                        <input type="date" class="form-control" value="{{ $response->recruit_partner_date }}" name="recruit_partner_date" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">14. Chức vụ, vị trí việc làm</label>
                        <input type="text" class="form-control"
                               placeholder="VD: Nhân viên kinh doanh, Trưởng phòng sale..." readonly name="recruit_partner_position" value="{{ $response->recruit_partner_position }}" >
                    </div>
                </div>

                {{-- PHẦN II: NỘI DUNG KHẢO SÁT --}}
                <h6 class="mb-4 fw-bold">Phần II: Nội dung khảo sát</h6>

                <!-- 15. Khu vực làm việc -->
                <div class="mb-4">
                    <label class="form-label fw-bold">15. Đơn vị Anh/Chị đang làm việc thuộc khu vực nào?</label>
                    @foreach (config('config.work_area') as $index => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="work_area"
                                   id="kv_{{ $index }}" value="{{ $index }}" disabled {{ $response->work_area == $index ? "checked" : "" }}>
                            <label class="form-check-label fw-normal"
                                   for="kv_{{ $index }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 16. Thời gian có việc sau tốt nghiệp -->
                <div class="mb-4">
                    <label class="form-label fw-bold">16. Sau khi tốt nghiệp, Anh/Chị có việc làm từ khi nào?</label>
                    @foreach (config('config.employed_since') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="employed_since"
                                   id="tg_{{ $key }}" value="{{ $key }}" disabled {{ $response->employed_since == $key ? "checked" : "" }}>
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
                            <input class="form-check-input" type="radio" name="trained_field"
                                   id="nganh_{{ $key }}" value="{{ $key }}" disabled {{ $response->trained_field == $key ? "checked" : "" }}>
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
                                   id="trinhdo_{{ $key }}" value="{{ $key }}" disabled {{ $response->professional_qualification_field == $key ? "checked" : "" }}>
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
                            <input class="form-check-input" type="radio" name="level_knowledge_acquired"
                                   id="kt_{{ $key }}" value="{{ $key }}" disabled {{ $response->level_knowledge_acquired == $key ? "checked" : "" }}>
                            <label class="form-check-label fw-normal"
                                   for="kt_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 20. Mức lương khởi điểm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">20. Mức lương khởi điểm (triệu đồng/tháng)</label>
                    <input type="text" class="form-control" name="starting_salary" placeholder="10" value="{{ $response->starting_salary }}" readonly>
                </div>

                <!-- 21. Mức thu nhập hiện tại -->
                <div class="mb-4">
                    <label class="form-label fw-bold">21. Mức thu nhập bình quân/tháng hiện nay (triệu đồng)</label>
                    @foreach (config('config.average_income') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" disabled type="radio" name="average_income" {{ $response->average_income == $key ? "checked" : "" }}
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
                    @php
                        $tim_viec = config('config.recruitment_type');
                        $recruit = json_decode($response->recruitment_type, true);
                    @endphp
                    @foreach ($tim_viec as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="recruitment_type[]" disabled
                                   id="ht_{{ $index }}" value="{{ $index }}" {{ in_array($index, $recruit['value']) ? "checked" : "" }}>
                            <label class="form-check-label fw-normal"
                                   for="ht_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach
                    @if (!empty($recruit['content_other']))
                        <div id="job_search_method_other_wrapper" class="mt-2">
                            <input type="text" name="job_search_method_other" id="job_search_method_other" readonly
                                   class="form-control" placeholder="" value="{{ $recruit['content_other'] }}">
                        </div>
                    @endif
                </div>

                <!-- 23. Hình thức tuyển -->
                <div class="mb-4">
                    @php
                        $job_search_method_value = json_decode($response->job_search_method, true);
                    @endphp
                    <label class="form-label fw-bold">23. Anh/Chị được tuyển theo hình thức nào?</label>
                    @foreach (config('config.job_search_method') as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="job_search_method" disabled
                                   id="ht_tuyen_{{ $key }}" value="{{ $key }}" {{ in_array($key, $job_search_method_value['value']) ? "checked" : "" }}>
                            <label class="form-check-label fw-normal"
                                   for="ht_tuyen_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                    @if (!empty($job_search_method_value['content_other']))
                        <div id="job_search_method_other_wrapper" class="mt-2">
                            <input type="text" name="job_search_method_other" id="job_search_method_other" readonly
                                   class="form-control" placeholder="" value="{{ $job_search_method_value['content_other'] }}">
                        </div>
                    @endif
                </div>

                <!-- 24. Kỹ năng mềm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">24. Trong quá trình làm việc, Anh/Chị cần những kỹ năng mềm nào sau
                        đây? <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php
                        $ky_nang = config('config.soft_skills_required');
                        $soft_skills_required = json_decode($response->soft_skills_required, true);
                    @endphp
                    @foreach ($ky_nang as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="soft_skills_required[]" disabled
                                   id="kn_{{ $index }}" value="{{ $index }}" {{ in_array($index, $soft_skills_required['value']) ? "checked" : "" }}>
                            <label class="form-check-label fw-normal"
                                   for="kn_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach
                    @if (!empty($soft_skills_required['content_other']))
                        <div id="job_search_method_other_wrapper" class="mt-2">
                            <input type="text" name="job_search_method_other" id="job_search_method_other" readonly
                                   class="form-control" placeholder="" value="{{ $soft_skills_required['content_other'] }}">
                        </div>
                    @endif
                </div>

                <!-- 25. Khóa học nâng cao -->
                <div class="mb-4">
                    <label class="form-label fw-bold">25. Sau khi được tuyển dụng, Anh/Chị có phải tham gia khóa học nâng
                        cao nào dưới đây để đáp ứng công việc không? <span class="fw-normal">(Có thể chọn nhiều lựa
                            chọn)</span></label>
                    @php
                        $nang_cao = config('config.must_attended_courses');
                        $must_attended_courses = json_decode($response->must_attended_courses, true);
                    @endphp
                    @foreach ($nang_cao as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="must_attended_courses[]" disabled
                                    {{ in_array($index, $must_attended_courses['value']) ? "checked" : "" }}
                                   id="nc_{{ $index }}" value="{{ $index }}">
                            <label class="form-check-label fw-normal"
                                   for="nc_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach
                    @if (!empty($must_attended_courses['content_other']))
                        <div id="job_search_method_other_wrapper" class="mt-2">
                            <input type="text" name="job_search_method_other" id="job_search_method_other" readonly
                                   class="form-control" placeholder="" value="{{ $must_attended_courses['content_other'] }}">
                        </div>
                    @endif
                </div>

                <!-- 26. Giải pháp nâng tỷ lệ có việc làm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">26. Theo Anh/Chị, những giải pháp nào sau đây giúp tăng tỷ lệ có việc
                        làm đúng ngành của sinh viên tốt nghiệp từ chương trình đào tạo mà Anh/Chị đã học? <span
                            class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php
                        $giai_phap = config('config.solutions_get_job');
                        $solutions_get_job = json_decode($response->solutions_get_job, true);
                    @endphp
                    @foreach ($giai_phap as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="solutions_get_job[]" disabled
                                {{ in_array($index, $solutions_get_job['value']) ? "checked" : "" }}
                                   id="gp_{{ $index }}" value="{{ $index }}">
                            <label class="form-check-label fw-normal"
                                   for="gp_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach
                    @if (!empty($solutions_get_job['content_other']))
                        <div id="job_search_method_other_wrapper" class="mt-2">
                            <input type="text" name="job_search_method_other" id="job_search_method_other" readonly
                                   class="form-control" placeholder="" value="{{ $solutions_get_job['content_other'] }}">
                        </div>
                    @endif
                </div>
            </form>

            <div>
                <button class="btn btn-primary" onclick="downloadPdf()">Xuất PDF</button>
            </div>

        </div>
    </div>

    <script>
        function downloadPdf() {
            const link = document.createElement('a');
            link.href = '{{ route('export_pdf_v2', ['resultId' => $response->id]) }}';
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endsection
