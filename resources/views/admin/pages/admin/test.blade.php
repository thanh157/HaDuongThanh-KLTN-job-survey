{{-- Phần I: Thông tin cá nhân --}}
                        <h6 class="mb-3">Phần 1: Thông tin cá nhân</h6>

                        <div class="mb-3">
                            <label class="form-label">1. Mã sinh viên</label>
                            <input type="text" class="form-control" placeholder="Nhập mã sinh viên">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">2. Họ và tên</label>
                            <input type="text" class="form-control" placeholder="Nhập họ và tên">
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
                                <input type="text" class="form-control" placeholder="Nhập khóa học">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">7. Tên ngành đào tạo</label>
                                <input type="text" class="form-control" placeholder="Nhập tên ngành">
                            </div>
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

                        <div class="mb-3">
                            <label class="form-label">10. Anh/Chị vui lòng cho biết tình trạng việc làm hiện tại</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vieclam_hientai" id="da_co_viec"
                                    value="Đã có việc làm">
                                <label class="form-check-label" for="da_co_viec">Đã có việc làm</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vieclam_hientai" id="dang_hoc"
                                    value="Đang học tiếp hoặc học văn bằng 2">
                                <label class="form-check-label" for="dang_hoc">Đang học tiếp/học văn bằng 2</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vieclam_hientai" id="chua_co_viec"
                                    value="Chưa có việc làm">
                                <label class="form-check-label" for="chua_co_viec">Chưa có việc làm</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="vieclam_hientai" id="chua_di_lam"
                                    value="Chưa đi làm">
                                <label class="form-check-label" for="chua_di_lam">Chưa đi làm</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">11. Tên đơn vị tuyển dụng</label>
                            <input type="text" class="form-control" placeholder="Nhập tên công ty / tổ chức">
                        </div>

                        <!-- 12. Địa chỉ đơn vị -->
                        <div class="mb-3">
                            <label class="form-label">12. Địa chỉ đơn vị</label>
                            <div class="form-text mb-3">vd: Khu 2 Hoàng Khương, Thanh Ba, Phú Thọ</div>
                            <input type="text" class="form-control mb-1" placeholder="Nhập địa chỉ cụ thể">

                            <label class="form-label">Địa chỉ đơn vị thuộc Tỉnh/Thành phố</label>
                            <input type="text" class="form-control" placeholder="Nhập Tỉnh/Thành phố">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">13. Thời gian tuyển dụng</label>
                            <input type="text" class="form-control" placeholder="Nhập năm tuyển dụng (vd: 2025)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">14. Chức vụ, vị trí việc làm</label>
                            <input type="text" class="form-control"
                                placeholder="VD: Nhân viên kinh doanh, Trưởng phòng sale...">
                        </div>

                        {{-- Phần II: Nội dung khảo sát --}}
                        <h6 class="mb-3">Phần II: Nội dung khảo sát</h6>
                        <!-- 15. Khu vực làm việc -->
                        <div class="mb-3">
                            <label class="form-label">15. Đơn vị Anh/Chị đang làm việc thuộc khu vực nào?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="khu_vuc_lam_viec" id="kvnn"
                                    value="Nhà nước">
                                <label class="form-check-label" for="kvnn">Khu vực nhà nước</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="khu_vuc_lam_viec" id="kvtntn"
                                    value="Tư nhân">
                                <label class="form-check-label" for="kvtntn">Khu vực tư nhân</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="khu_vuc_lam_viec" id="kvefdi"
                                    value="Có yếu tố nước ngoài">
                                <label class="form-check-label" for="kvefdi">Có yếu tố nước ngoài</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="khu_vuc_lam_viec" id="kvstart"
                                    value="Tự tạo việc làm">
                                <label class="form-check-label" for="kvstart">Tự tạo việc làm</label>
                            </div>
                        </div>

                        <!-- 16. Thời gian có việc sau tốt nghiệp -->
                        <div class="mb-3">
                            <label class="form-label">16. Sau khi tốt nghiệp, Anh/Chị có việc làm từ khi nào?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thoigian_co_viec" id="tgduoi3"
                                    value="Dưới 3 tháng">
                                <label class="form-check-label" for="tgduoi3">Dưới 3 tháng</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thoigian_co_viec" id="tg3_6"
                                    value="Từ 3-6 tháng">
                                <label class="form-check-label" for="tg3_6">Từ 3 tháng đến 6 tháng</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thoigian_co_viec" id="tg6_12"
                                    value="Từ 6-12 tháng">
                                <label class="form-check-label" for="tg6_12">Từ 6 tháng đến 12 tháng</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="thoigian_co_viec" id="tgtren12"
                                    value="Trên 12 tháng">
                                <label class="form-check-label" for="tgtren12">Trên 12 tháng</label>
                            </div>
                        </div>

                        <!-- 17. Công việc có phù hợp với ngành đào tạo -->
                        <div class="mb-3">
                            <label class="form-label">17. Công việc Anh/Chị đang làm có phù hợp với ngành đào tạo
                                không?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuhop_nganh" id="phuhop_dung"
                                    value="Đúng ngành">
                                <label class="form-check-label" for="phuhop_dung">Đúng ngành đào tạo</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuhop_nganh" id="phuhop_lienquan"
                                    value="Liên quan">
                                <label class="form-check-label" for="phuhop_lienquan">Liên quan đến ngành đào tạo</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuhop_nganh"
                                    id="phuhop_khonglienquan" value="Không liên quan">
                                <label class="form-check-label" for="phuhop_khonglienquan">Không liên quan đến ngành đào
                                    tạo</label>
                            </div>
                        </div>

                        <!-- 18. Công việc có phù hợp với trình độ chuyên môn -->
                        <div class="mb-3">
                            <label class="form-label">18. Công việc Anh/Chị đang đảm nhận có phù hợp với trình độ chuyên
                                môn không?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuhop_trinhdo" id="trinhdo_chua"
                                    value="Chưa phù hợp">
                                <label class="form-check-label" for="trinhdo_chua">Chưa phù hợp với trình độ chuyên
                                    môn</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="phuhop_trinhdo" id="trinhdo_phuhop"
                                    value="Phù hợp">
                                <label class="form-check-label" for="trinhdo_phuhop">Phù hợp với trình độ chuyên
                                    môn</label>
                            </div>
                        </div>

                        <!-- 19. Kiến thức kỹ năng từ trường có phù hợp công việc -->
                        <div class="mb-3">
                            <label class="form-label">19. Anh/Chị có học được kiến thức/kỹ năng cần thiết từ trường cho
                                công việc không?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kienthuc_tu_truong" id="kt_hocduoc"
                                    value="Đã học được">
                                <label class="form-check-label" for="kt_hocduoc">Đã học được</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kienthuc_tu_truong"
                                    id="kt_khonghocduoc" value="Không học được">
                                <label class="form-check-label" for="kt_khonghocduoc">Không học được</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kienthuc_tu_truong" id="kt_motphan"
                                    value="Chỉ học được 1 phần">
                                <label class="form-check-label" for="kt_motphan">Chỉ học được 1 phần</label>
                            </div>
                        </div>

                        <!-- 20. Mức lương khởi điểm -->
                        <div class="mb-3">
                            <label class="form-label">20. Mức lương khởi điểm (triệu đồng/tháng)</label>
                            <input type="text" class="form-control" name="luong_khoidiem" placeholder="10">
                        </div>

                        <!-- 21. Mức thu nhập hiện tại -->
                        <div class="mb-3">
                            <label class="form-label">21. Mức thu nhập bình quân/tháng hiện nay (triệu đồng)</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thu_nhap_hientai" id="tn_duoi5"
                                    value="Dưới 5 triệu">
                                <label class="form-check-label" for="tn_duoi5">Dưới 5 triệu</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thu_nhap_hientai" id="tn_5_10"
                                    value="5 - 10 triệu">
                                <label class="form-check-label" for="tn_5_10">Từ 5 triệu - 10 triệu</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="thu_nhap_hientai" id="tn_10_15"
                                    value="10 - 15 triệu">
                                <label class="form-check-label" for="tn_10_15">Từ 10 triệu - 15 triệu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="thu_nhap_hientai" id="tn_tren15"
                                    value="Trên 15 triệu">
                                <label class="form-check-label" for="tn_tren15">Trên 15 triệu</label>
                            </div>
                        </div>

                        <!-- 22. Hình thức tìm được việc làm -->
                        <div class="mb-4">
                            <label class="form-label">
                                22. Anh/Chị tìm được việc làm thông qua những hình thức nào?
                                <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span>
                            </label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                    id="ht_1" value="Do Học viện/Khoa giới thiệu">
                                <label class="form-check-label" for="ht_1">Do Học viện/Khoa giới thiệu</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                    id="ht_2" value="Bạn bè, người quen giới thiệu">
                                <label class="form-check-label" for="ht_2">Bạn bè, người quen giới thiệu</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                    id="ht_3" value="Tự tìm việc làm">
                                <label class="form-check-label" for="ht_3">Tự tìm việc làm</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                    id="ht_4" value="Tự tạo việc làm">
                                <label class="form-check-label" for="ht_4">Tự tạo việc làm</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hinh_thuc_tim_viec[]"
                                    id="ht_5" value="Khác">
                                <label class="form-check-label" for="ht_5">Khác</label>
                            </div>
                        </div>

                        <!-- 23. Hình thức tuyển -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">23. Anh/Chị được tuyển theo hình thức nào?</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hinh_thuc_tuyen" id="thi_tuyen"
                                    value="Thi tuyển">
                                <label class="form-check-label" for="thi_tuyen">Thi tuyển</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hinh_thuc_tuyen" id="xet_tuyen"
                                    value="Xét tuyển">
                                <label class="form-check-label" for="xet_tuyen">Xét tuyển</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hinh_thuc_tuyen" id="hop_dong"
                                    value="Hợp đồng">
                                <label class="form-check-label" for="hop_dong">Hợp đồng</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="hinh_thuc_tuyen" id="dieu_dong"
                                    value="Điều động">
                                <label class="form-check-label" for="dieu_dong">Điều động</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hinh_thuc_tuyen" id="khac_tuyen"
                                    value="Khác">
                                <label class="form-check-label" for="khac_tuyen">Khác</label>
                            </div>
                        </div>

                        <!-- 24. Kỹ năng mềm -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                24. Trong quá trình làm việc, Anh/Chị cần những kỹ năng mềm nào sau đây?
                                <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span>
                            </label>

                            @php $ky_nang = ['Kỹ năng giao tiếp', 'Kỹ năng lãnh đạo', 'Kỹ năng thuyết trình', 'Kỹ năng Tiếng Anh', 'Kỹ năng làm việc nhóm', 'Kỹ năng tin học', 'Kỹ năng viết báo cáo tài liệu', 'Kỹ năng hội nhập quốc tế', 'Khác']; @endphp

                            @foreach ($ky_nang as $index => $value)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="ky_nang_mem[]"
                                        id="kn_{{ $index }}" value="{{ $value }}">
                                    <label class="form-check-label"
                                        for="kn_{{ $index }}">{{ $value }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- 25. Khóa học nâng cao -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                25. Sau khi được tuyển dụng, Anh/Chị có phải tham gia khóa học nâng cao nào dưới đây để đáp
                                ứng công việc không?
                                <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span>
                            </label>

                            @php $nang_cao = ['Nâng cao kiến thức chuyên môn', 'Nâng cao kỹ năng chuyên môn nghiệp vụ', 'Nâng cao về kỹ năng công nghệ thông tin', 'Nâng cao kỹ năng ngoại ngữ', 'Phát triển kỹ năng quản lý', 'Tiếp tục học lên cao', 'Khác']; @endphp

                            @foreach ($nang_cao as $index => $value)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="khoa_hoc_nang_cao[]"
                                        id="nc_{{ $index }}" value="{{ $value }}">
                                    <label class="form-check-label"
                                        for="nc_{{ $index }}">{{ $value }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- 26. Giải pháp nâng tỷ lệ có việc làm -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                26. Theo Anh/Chị, những giải pháp nào sau đây giúp tăng tỷ lệ có việc làm đúng ngành
                                của sinh viên tốt nghiệp từ chương trình đào tạo mà Anh/Chị đã học?
                                <span class="fw-normal">(Có thể chọn nhiều lựa chọn)</span>
                            </label>

                            @php $giai_phap = ['Học viện tổ chức các buổi trao đổi, chia sẻ kinh nghiệm việc làm giữa cựu sinh viên và sinh viên', 'Học viện tổ chức các buổi gặp gỡ với đơn vị sử dụng lao động', 'Đơn vị sử dụng lao động tham gia vào quá trình đào tạo', 'Chương trình đào tạo được cập nhật theo nhu cầu thị trường', 'Tăng cường các hoạt động thực hành và chuyên môn tại cơ sở', 'Khác']; @endphp

                            @foreach ($giai_phap as $index => $value)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="giai_phap_viec_lam[]"
                                        id="gp_{{ $index }}" value="{{ $value }}">
                                    <label class="form-check-label"
                                        for="gp_{{ $index }}">{{ $value }}</label>
                                </div>
                            @endforeach
                            <div class="mb-4">
                                <label class="form-label fw-bold">Các giải pháp khác (nếu có, xin ghi rõ)</label>
                                <textarea class="form-control" name="giai_phap_khac" rows="3" placeholder="Nhập ý kiến của bạn tại đây..."></textarea>
                            </div>

                            <!-- Reminder to review -->
                            <div class="alert alert-warning mt-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Vui lòng kiểm tra kỹ thông tin trước khi gửi. Mỗi sinh viên chỉ được gửi phiếu khảo sát một
                                lần.
                            </div>

                            <!-- Cảm ơn -->
                            <div class="text-center mt-4">
                                <p class="fw-semibold mb-1">Xin trân trọng cảm ơn sự hợp tác của Anh/Chị!</p>
                                <p class="text-muted fst-italic mb-3">Kính chúc Anh/Chị sức khỏe và thành công!</p>
                            </div>
                        </div>