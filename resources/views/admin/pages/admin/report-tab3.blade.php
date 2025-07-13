<div class="tab-pane fade" id="tab3">
    <div class="card shadow-sm border mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="#" class="btn btn-primary me-2">
                    <i class="bi bi-eye"></i> Xem trước
                </a>
                <a href="#" class="btn btn-success">
                    <i class="bi bi-download"></i> Tải xuống báo cáo
                </a>
            </div>

            <div class="border rounded p-3" style="max-height: 800px; overflow: auto;">
                <div class="text-center mb-4">
                    <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                    <h6 class="mb-3">TÊN ĐƠN VỊ</h6>
                    <h5 class="fw-bold text-decoration-underline mb-0">
                        DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM 2021 PHẢN HỒI VỀ TÌNH HÌNH VIỆC LÀM
                    </h5>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center align-middle mb-0"
                        style="font-size: 13px; min-width: 3400px;">
                        <thead class="align-middle">
                            <tr>
                                <th>TT</th>
                                <th>Mã sinh viên</th>
                                <th>Họ và tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Số thẻ CCCD/CMND</th>
                                <th>Mã ngành đào tạo</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                                <th colspan="3">Tình hình việc làm</th>
                                <th>Tiếp tục học</th>
                                <th>Chưa có việc làm</th>
                                <th colspan="4">Khu vực làm việc</th>
                                <th>Nơi làm việc (Tỉnh/Tp)</th>
                                <th colspan="4">Thời gian có việc làm sau tốt nghiệp</th>
                                <th colspan="4">Thu nhập bình quân/1 tháng</th>
                                <th colspan="3">Kiến thức, kỹ năng từ nhà trường</th>
                                <th colspan="5">Hình thức tìm việc làm</th>
                                <th colspan="5">Mức độ áp dụng kiến thức</th>
                                <th colspan="5">Mức độ áp dụng kỹ năng</th>
                                <th colspan="8">Kỹ năng mềm cần thiết cho công việc</th>
                                <th colspan="7">Khóa học đã tham gia sau khi tốt nghiệp</th>
                                <th colspan="6">Giải pháp nâng cao tỷ lệ việc làm đúng ngành đào tạo</th>
                            </tr>
                            <tr>
                                <th colspan="3"></th>
                                <th colspan="7"></th>
                                <th>Đúng ngành</th>
                                <th>Liên quan</th>
                                <th>Không liên quan</th>
                                <th colspan="39"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report3 as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->student_code }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->birth_date }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->id_number }}</td>
                                    <td>{{ $student->major_code }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->job_status_correct }}</td>
                                    <td>{{ $student->job_status_related }}</td>
                                    <td>{{ $student->job_status_unrelated }}</td>
                                    <td>{{ $student->continued_study }}</td>
                                    <td>{{ $student->no_job }}</td>
                                    <td>{{ $student->gov_sector }}</td>
                                    <td>{{ $student->private_sector }}</td>
                                    <td>{{ $student->foreign_involved }}</td>
                                    <td>{{ $student->self_employed }}</td>
                                    <td>{{ $student->workplace_province_code }}</td>
                                    <td>{{ $student->time_under_3m }}</td>
                                    <td>{{ $student->time_3_to_6m }}</td>
                                    <td>{{ $student->time_6_to_12m }}</td>
                                    <td>{{ $student->time_over_12m }}</td>
                                    <td>{{ $student->income_under_5m }}</td>
                                    <td>{{ $student->income_5_to_10m }}</td>
                                    <td>{{ $student->income_10_to_15m }}</td>
                                    <td>{{ $student->income_over_15m }}</td>
                                    <td>{{ $student->skill_learned }}</td>
                                    <td>{{ $student->skill_partial }}</td>
                                    <td>{{ $student->skill_none }}</td>
                                    <td>{{ $student->job_by_school }}</td>
                                    <td>{{ $student->job_by_friends }}</td>
                                    <td>{{ $student->job_by_self }}</td>
                                    <td>{{ $student->job_self_created }}</td>
                                    <td>{{ $student->job_by_other }}</td>
                                    <td>{{ $student->apply_very_high }}</td>
                                    <td>{{ $student->apply_high }}</td>
                                    <td>{{ $student->apply_low }}</td>
                                    <td>{{ $student->apply_very_low }}</td>
                                    <td>{{ $student->apply_none }}</td>
                                    <td>{{ $student->skill_apply_very_high }}</td>
                                    <td>{{ $student->skill_apply_high }}</td>
                                    <td>{{ $student->skill_apply_low }}</td>
                                    <td>{{ $student->skill_apply_very_low }}</td>
                                    <td>{{ $student->skill_apply_none }}</td>
                                    <td>{{ $student->soft_comm }}</td>
                                    <td>{{ $student->soft_lead }}</td>
                                    <td>{{ $student->soft_present }}</td>
                                    <td>{{ $student->soft_english }}</td>
                                    <td>{{ $student->soft_team }}</td>
                                    <td>{{ $student->soft_it }}</td>
                                    <td>{{ $student->soft_report }}</td>
                                    <td>{{ $student->soft_other }}</td>
                                    <td>{{ $student->course_prof }}</td>
                                    <td>{{ $student->course_skill }}</td>
                                    <td>{{ $student->course_it }}</td>
                                    <td>{{ $student->course_eng }}</td>
                                    <td>{{ $student->course_manage }}</td>
                                    <td>{{ $student->course_continue }}</td>
                                    <td>{{ $student->course_other }}</td>
                                    <td>{{ $student->solution_alumni }}</td>
                                    <td>{{ $student->solution_employer }}</td>
                                    <td>{{ $student->solution_train_join }}</td>
                                    <td>{{ $student->solution_curriculum }}</td>
                                    <td>{{ $student->solution_practice }}</td>
                                    <td>{{ $student->solution_other }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
