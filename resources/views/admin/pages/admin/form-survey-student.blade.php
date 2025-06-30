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
                <h5 class="fw-bold text-center">PHIẾU KHẢO SÁT TỰ ĐÁNH GIÁ MỨC ĐỘ HÀI LÒNG VỀ VIỆC LÀM <br> CỦA SINH VIÊN
                    TỐT NGHIỆP NĂM 2023</h5>
                <p class="text-justify">
                    Nhằm đánh giá hiệu quả của chương trình đào tạo và làm căn cứ để nâng cao chất lượng giáo dục, Học viện
                    Nông nghiệp Việt Nam đang tiến hành khảo sát tình hình việc làm của sinh viên đã tốt nghiệp năm 2023,
                    cũng như mức độ phù hợp giữa công việc hiện tại và chuyên ngành đã học.
                </p>
                <p class="text-justify">
                    Chúng tôi rất mong nhận được sự hợp tác từ Anh/Chị trong việc cung cấp thông tin một cách trung thực và
                    đầy đủ. Tất cả các thông tin trong phiếu khảo sát sẽ được sử dụng chỉ cho mục đích nghiên cứu và đảm bảo
                    bảo mật tuyệt đối.
                </p>
                <p class="text-justify">
                    Sự đóng góp của Anh/Chị có ý nghĩa rất lớn trong việc nâng cao chất lượng đào tạo của Học viện.
                </p>
                <p class="text-end mt-2">
                    <small class="text-muted fst-italic">Thời gian khảo sát: 01/02/2025 – 23/12/2025</small>
                </p>
            </div>

            <!-- Form Start -->
            <form>
                <div class="form-section">
                    <h6 class="fw-bold">Phần I. Thông tin cá nhân</h6>

                    <div class="mb-3">
                        <label for="ho_ten">1. Họ và tên</label>
                        <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                            placeholder="Nhập họ và tên đầy đủ">
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">3. Giới tính</label>
                            <input type="text" class="form-control" placeholder="Nam / Nữ">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">4. Ngày sinh</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ma_sv">4. Mã sinh viên</label>
                        <input type="text" class="form-control" id="ma_sv" name="ma_sv" value="637084"
                            placeholder="Nhập mã sinh viên" oninput="setKhoaHocFromMaSV()">

                    </div>

                    <div class="mb-3">
                        <label class="form-label">5. Số căn cước công dân</label>
                        <input type="text" class="form-control mb-2" placeholder="Nhập số CCCD">
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" class="form-control mb-2">
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" class="form-control" placeholder="Nhập nơi cấp">
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">6. Khóa học</label>
                            <input type="text" class="form-control" id="khoa_hoc" name="khoa_hoc"
                                placeholder="Khóa học sẽ tự động hiển thị">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="major" class="form-label">Ngành đào tạo</label>
                            <select class="form-select" name="major" id="major" required>
                                <option value="">-- Chọn ngành đào tạo --</option>

                                @isset($majors)
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                                    @endforeach

                                @endisset

                            </select>
                        </div>

                        {{-- <select class="form-select" name="major" id="major" required>
                            <option value="">-- Chọn ngành đào tạo --</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major['id'] }}">{{ $major['name'] }}</option>
                            @endforeach
                        </select> --}}

                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">8. Số điện thoại</label>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label">9. Email</label>
                            <input type="email" class="form-control" placeholder="Nhập email">
                        </div>
                    </div>

                    {{-- chưa api major được --}}
                    <!-- 10. Tình trạng việc làm hiện tại -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">10. Anh/Chị vui lòng cho biết tình trạng việc làm hiện tại của
                            Anh/chị</label>
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
                        <input type="text" class="form-control" placeholder="Nhập tên công ty / tổ chức">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">12. Địa chỉ cơ quan</label>
                        <div class="form-text mb-3">vd: Khu 2 Hoàng Khương, Thanh Ba, Phú Thọ</div>
                        <input type="text" class="form-control mb-1" placeholder="Nhập địa chỉ cụ thể">
                        <label class="form-label">Địa chỉ đơn vị thuộc Tỉnh/Thành phố</label>
                        <input type="text" class="form-control" placeholder="Nhập Tỉnh/Thành phố">
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">13. Thời gian tuyển dụng</label>
                        <input type="text" class="form-control" placeholder="Nhập năm tuyển dụng (vd: 2025)">
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">13. Chức vụ, vị trí việc làm</label>
                        <input type="text" class="form-control"
                            placeholder="VD: Nhân viên kinh doanh, Trưởng phòng sale...">
                    </div>
                </div>

                {{-- PHẦN II: NỘI DUNG KHẢO SÁT --}}
                <h6 class="mb-4 fw-bold">Phần II: Nội dung khảo sát</h6>

                <!-- 15. Khu vực làm việc -->
                <div class="mb-4">
                    <label class="form-label fw-bold">14. Đơn vị Anh/Chị đang làm việc thuộc khu vực nào?</label>
                    @foreach (['Khu vực nhà nước', 'Khu vực tư nhân', 'Có yếu tố nước ngoài', 'Tự tạo việc làm'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="khu_vuc_lam_viec"
                                id="kv_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="kv_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 16. Thời gian có việc sau tốt nghiệp -->
                <div class="mb-4">
                    <label class="form-label fw-bold">15. Sau khi tốt nghiệp, Anh/Chị có việc làm từ khi nào?</label>
                    @foreach (['Dưới 3 tháng', 'Từ 3 tháng đến 6 tháng', 'Từ 6 tháng đến 12 tháng', 'Trên 12 tháng'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="thoigian_co_viec"
                                id="tg_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="tg_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 17. Công việc có phù hợp với ngành đào tạo -->
                <div class="mb-4">
                    <label class="form-label fw-bold">16. Công việc Anh/Chị đang làm có phù hợp với ngành đào tạo
                        không?</label>
                    @foreach (['Đúng ngành đào tạo', 'Liên quan đến ngành đào tạo', 'Không liên quan đến ngành đào tạo'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="phuhop_nganh"
                                id="nganh_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="nganh_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- <!-- 18. Công việc có phù hợp với trình độ chuyên môn -->
                <div class="mb-4">
                    <label class="form-label fw-bold">17. Công việc Anh/Chị đang đảm nhận có phù hợp với trình độ chuyên
                        môn không?</label>
                    @foreach (['Chưa phù hợp với trình độ chuyên môn', 'Phù hợp với trình độ chuyên môn'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="phuhop_trinhdo"
                                id="trinhdo_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="trinhdo_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div> --}}

                <!-- 19. Kiến thức kỹ năng từ trường có phù hợp công việc -->
                <div class="mb-4">
                    <label class="form-label fw-bold">17. Anh/Chị có học được kiến thức/kỹ năng cần thiết từ trường cho
                        công việc theo nghành tốt nghiệp không?</label>
                    @foreach (['Đã học được', 'Không học được', 'Chỉ học được một phần'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="kienthuc_tu_truong"
                                id="kt_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="kt_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- <!-- 20. Mức lương khởi điểm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">18. Mức thu nhập bình quân/tháng tính theo VNĐ của Anh/chị hiện nay</label>
                    <input type="text" class="form-control" name="luong_khoidiem" placeholder="10">
                </div> --}}

                <!-- 21. Mức thu nhập hiện tại -->
                <div class="mb-4">
                    <label class="form-label fw-bold">18. Mức thu nhập bình quân/tháng theo VNĐ của anh/chị hiện
                        nay?</label>
                    @foreach (['Dưới 5 triệu', 'từ 5 triệu đến 10 triệu', 'Từ trên 10 triệu đến 15 triệu', 'Trên 15 triệu'] as $key => $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="thu_nhap_hientai"
                                id="tn_{{ $key }}" value="{{ $item }}">
                            <label class="form-check-label fw-normal"
                                for="tn_{{ $key }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- 22. Hình thức tìm được việc làm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        19. Anh/Chị tìm được việc làm thông qua những hình thức nào?
                        <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span>
                    </label>
                    @php
                        $tim_viec = [
                            'Do Học viện/Khoa giới thiệu',
                            'Bạn bè, người quen giới thiệu',
                            'Tự tìm việc làm',
                            'Tự tạo việc làm',
                            'Hình thức khác',
                        ];
                    @endphp
                    @foreach ($tim_viec as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                id="ht_{{ $index }}" value="{{ $value }}"
                                @if ($value === 'Hình thức khác') onchange="toggleOtherInput(this)" @endif>
                            <label class="form-check-label fw-normal"
                                for="ht_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach

                    <!-- Ô nhập hiện khi chọn 'Hình thức khác' -->
                    <div id="other_input_box" class="mt-2" style="display: none;">
                        <label class="form-label fw-normal" for="other_input">Vui lòng ghi rõ:</label>
                        <input type="text" class="form-control" name="hinh_thuc_khac" id="other_input"
                            placeholder="Nhập hình thức khác...">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">20. Mức độ Anh/Chị áp dụng kiến thức, kỹ năng đã được đào tạo vào
                        thực tế công việc?</label>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start">Nội dung áp dụng</th>
                                    <th>Áp dụng rất nhiều</th>
                                    <th>Áp dụng tương đối nhiều</th>
                                    <th>Áp dụng ít</th>
                                    <th>Áp dụng rất ít</th>
                                    <th>Không áp dụng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $muc_do = ['rất nhiều', 'tương đối nhiều', 'ít', 'rất ít', 'không áp dụng'];
                                    $noi_dung = ['Kiến thức', 'Kỹ năng'];
                                @endphp

                                @foreach ($noi_dung as $key => $nd)
                                    <tr>
                                        <td class="text-start">{{ $nd }}</td>
                                        @foreach ($muc_do as $index => $md)
                                            <td>
                                                <input class="form-check-input" type="radio"
                                                    name="muc_do_{{ strtolower(str_replace(' ', '_', $nd)) }}"
                                                    value="{{ $md }}"
                                                    id="{{ $nd }}_{{ $index }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- 24. Kỹ năng mềm -->
                <div class="mb-4">
                    <label class="form-label fw-bold">21. Trong quá trình làm việc, Anh/Chị cần những kỹ năng mềm nào
                        sau
                        đây? <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span></label>
                    @php $ky_nang = ['Kỹ năng giao tiếp', 'Kỹ năng lãnh đạo', 'Kỹ năng thuyết trình', 'Kỹ năng Tiếng Anh', 'Kỹ năng làm việc nhóm', 'Kỹ năng tin học', 'Kỹ năng viết báo cáo tài liệu', 'Khác']; @endphp
                    @foreach ($ky_nang as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="ky_nang_mem[]"
                                id="kn_{{ $index }}" value="{{ $value }}"
                                @if ($value === 'Khác') onchange="toggleOtherInput(this, 'ky_nang_khac_box')" @endif>
                            <label class="form-check-label fw-normal"
                                for="kn_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach

                    <!-- Textbox cho 'Khác' -->
                    <div id="ky_nang_khac_box" class="mt-2" style="display: none;">
                        <label class="form-label fw-normal" for="ky_nang_khac">Vui lòng ghi rõ kỹ năng khác:</label>
                        <input type="text" class="form-control" name="ky_nang_khac" id="ky_nang_khac"
                            placeholder="Nhập kỹ năng khác...">
                    </div>

                </div>

                <!-- 25. Khóa học nâng cao -->
                <div class="mb-4">
                    <label class="form-label fw-bold">22. Sau khi được tuyển dụng, Anh/Chị có phải tham gia khóa học
                        nâng
                        cao nào dưới đây để đáp ứng công việc không? <span class="fw-normal">(Có thể chọn nhiều lựa
                            chọn)</span></label>
                    @php $nang_cao = ['Nâng cao kiến thức chuyên môn', 'Nâng cao kỹ năng chuyên môn nghiệp vụ', 'Nâng cao về kỹ năng công nghệ thông tin', 'Nâng cao kỹ năng ngoại ngữ', 'Phát triển kỹ năng quản lý', 'Tiếp tục học lên cao', 'Khác']; @endphp
                    @foreach ($nang_cao as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="khoa_hoc_nang_cao[]"
                                id="nc_{{ $index }}" value="{{ $value }}"
                                @if ($value === 'Khác') onchange="toggleOtherInput(this, 'nang_cao_khac_box')" @endif>
                            <label class="form-check-label fw-normal"
                                for="nc_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach

                    <!-- Textbox cho 'Khác' -->
                    <div id="nang_cao_khac_box" class="mt-2" style="display: none;">
                        <label class="form-label fw-normal" for="nang_cao_khac">Vui lòng ghi rõ khóa học khác:</label>
                        <input type="text" class="form-control" name="nang_cao_khac" id="nang_cao_khac"
                            placeholder="Nhập khóa học khác...">
                    </div>

                </div>

                <!-- 23. Giải pháp nâng tỷ lệ có việc làm đúng ngành -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        23. Theo Anh/Chị, những giải pháp nào sau đây giúp tăng tỷ lệ có việc làm đúng ngành của sinh
                        viên
                        tốt nghiệp từ chương trình đào tạo mà Anh/Chị đã học?
                        <span class="fw-normal">(Có thể chọn nhiều đáp án)</span>
                    </label>

                    @php
                        $giai_phap = [
                            'Học viện tổ chức chương trình để cựu sinh viên chia sẻ kinh nghiệm tìm việc làm cho sinh viên',
                            'Học viện tổ chức các buổi trao đổi giữa sinh viên với các đơn vị sử dụng lao động',
                            'Đơn vị sử dụng lao động tham gia vào quá trình đào tạo',
                            'Chương trình đào tạo được điều chỉnh và cập nhật theo nhu cầu của thị trường lao động',
                            'Tăng cường các hoạt động thực hành và chuyên môn tại cơ sở',
                            'Khác',
                        ];
                    @endphp

                    @foreach ($giai_phap as $index => $value)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="giai_phap_viec_lam[]"
                                id="gp_{{ $index }}" value="{{ $value }}"
                                @if ($value === 'Khác') onchange="toggleOtherInput(this, 'giai_phap_khac_box')" @endif>
                            <label class="form-check-label fw-normal"
                                for="gp_{{ $index }}">{{ $value }}</label>
                        </div>
                    @endforeach

                    <!-- Ô nhập hiện ra khi tích 'Khác' -->
                    <div id="giai_phap_khac_box" class="mt-2" style="display: none;">
                        <label class="form-label fw-normal" for="giai_phap_khac">Các giải pháp khác (xin ghi
                            rõ)</label>
                        <textarea class="form-control" name="giai_phap_khac" id="giai_phap_khac" rows="3"
                            placeholder="Nhập giải pháp khác..."></textarea>
                    </div>
                </div>


                <!-- Lời kết -->
                <div class="text-center mt-4">
                    {{-- <p class="fw-semibold mb-1"></p> --}}
                    <p class="text-muted fst-italic mb-3">Xin trân trọng cảm ơn!</p>
                </div>

        </div>

        <!-- Submit button -->
        <div class="text-end mt-3">
            <a href="{{ route('admin.survey.form-survey') }}" class="btn btn-success px-4 shadow-sm">
                <i class="bi bi-send me-1"></i> Gửi phản hồi
            </a>
        </div>


        </form>
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
