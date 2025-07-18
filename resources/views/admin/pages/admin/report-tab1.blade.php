  <!-- Mẫu báo cáo 1 -->
            <div class="tab-pane fade show active" id="tab1">
                <div class="card shadow-sm border mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-primary me-2">
                                <i class="bi bi-eye"></i> Xem biểu đồ thống kê
                            </a>
                            <a href="#" class="btn btn-success">
                                <i class="bi bi-download"></i> Tải xuống báo cáo
                            </a>
                        </div>

                        <div class="border rounded p-3" style="max-height: 800px; overflow-y: auto;">
                            <div class="text-center mb-4">
                                <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                                <h6 class="mb-1">TÊN ĐƠN VỊ ………………….</h6>
                                <h5 class="fw-bold text-decoration-underline mb-0">
                                    MẪU SỐ 01: BÁO CÁO TÌNH HÌNH VIỆC LÀM CỦA SINH VIÊN TỐT NGHIỆP NĂM 2021
                                </h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle"
                                    style="font-size: 12px; min-width: 2000px;">
                                    <thead class="align-middle">
                                        <tr>
                                            <th rowspan="3">TT</th>
                                            <th rowspan="3">Mã ngành<br><small>(Ghi bằng số theo mã ngành tuyển
                                                    sinh)</small></th>
                                            <th rowspan="3">Tên ngành đào tạo</th>
                                            <th colspan="2" rowspan="2">(4)<br>Số sinh viên tốt nghiệp</th>
                                            <th colspan="2" rowspan="2">(5)<br>Số sinh viên phản hồi</th>
                                            <th colspan="5">Tình hình việc làm</th>
                                            <th rowspan="3">Tỷ lệ có việc làm / phản hồi</th>
                                            <th rowspan="3">Tỷ lệ có việc làm / tốt nghiệp</th>
                                            <th colspan="4" rowspan="2">Khu vực làm việc</th>
                                            <th rowspan="3">Nơi làm việc<br>(Tỉnh/TP)</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Có việc làm</th>
                                            <th rowspan="2">Tiếp tục học</th>
                                            <th rowspan="2">Chưa có việc làm</th>
                                        </tr>
                                        <tr>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th>Tổng số</th>
                                            <th>Nữ</th>
                                            <th>Đúng ngành</th>
                                            <th>Liên quan</th>
                                            <th>Không liên quan</th>
                                            <th>Nhà nước</th>
                                            <th>Tư nhân</th>
                                            <th>Tự tạo</th>
                                            <th>Nước ngoài</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($report1 as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->training_industry_id }}</td>
                                                <td>{{ $row->ten_nganh }}</td>
                                                <td>{{ $row->sv_tot_nghiep ?? '-' }}</td>
                                                <td>{{ $row->sv_nu_tot_nghiep ?? '-' }}</td>
                                                <td>{{ $row->tong_phan_hoi ?? '-' }}</td>
                                                <td>{{ $row->nu_phan_hoi ?? '-' }}</td>
                                                <td>{{ $row->co_viec_lam ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_dung_nganh ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_lien_quan ?? '-' }}</td>
                                                <td>{{ $row->viec_lam_khong_lien_quan ?? '-' }}</td>
                                                <td>{{ $row->tiep_tuc_hoc ?? '-' }}</td>
                                                <td>{{ $row->chua_co_viec ?? '-' }}</td>
                                                <td>{{ $row->ty_le_co_viec_phan_hoi ?? '-' }}%</td>
                                                <td>{{ $row->ty_le_co_viec_tot_nghiep ?? '-' }}%</td>
                                                <td>{{ $row->lam_viec_nha_nuoc ?? '-' }}</td>
                                                <td>{{ $row->lam_viec_tu_nhan ?? '-' }}</td>
                                                <td>{{ $row->tu_tao_viec_lam ?? '-' }}</td>
                                                <td>{{ $row->yeu_to_nuoc_ngoai ?? '-' }}</td>
                                                <td>{{ $row->noi_lam_viec ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="20" class="text-center text-muted">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
