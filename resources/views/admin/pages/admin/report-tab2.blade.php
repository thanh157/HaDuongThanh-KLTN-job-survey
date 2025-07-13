<div class="tab-pane fade" id="tab2">
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

            <div class="border rounded p-3" style="max-height: 800px; overflow-y: auto;">
                <div class="text-center mb-4">
                    <h6 class="text-uppercase mb-1">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</h6>
                    <h6 class="mb-3">BAN QUẢN LÝ ĐÀO TẠO</h6>
                    <h5 class="fw-bold text-decoration-underline mb-0">
                        MẪU SỐ 02: DANH SÁCH SINH VIÊN TỐT NGHIỆP NĂM 2021
                    </h5>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center align-middle mb-0"
                        style="font-size: 13px; min-width: 1500px;">
                        <thead class="align-middle">
                            <tr>
                                <th rowspan="2">TT</th>
                                <th rowspan="2">Mã sinh viên</th>
                                <th rowspan="2">Họ và tên</th>
                                <th rowspan="2">Nữ</th>
                                <th rowspan="2">Số thẻ CCCD/CMND</th>
                                <th rowspan="2">Mã ngành đào tạo<br><small>(Mã ngành theo Bộ GD&ĐT)</small></th>
                                <th colspan="2">Quyết định tốt nghiệp</th>
                                <th colspan="2">Thông tin liên hệ</th>
                                <th rowspan="2">Hình thức khảo sát</th>
                                <th rowspan="2">Có phản hồi</th>
                                <th rowspan="2">Ngành</th>
                                <th rowspan="2">Khoa</th>
                            </tr>
                            <tr>
                                <th>Số Quyết định</th>
                                <th>Ngày ký</th>
                                <th>Điện thoại</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($students->count())
                                <p class="text-success">Có dữ liệu sinh viên</p>
                            @else
                                <p class="text-danger">Không có dữ liệu</p>
                            @endif


                            @foreach ($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->student_code }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->is_female ? '1' : '' }}</td>
                                    <td>{{ $student->id_number }}</td>
                                    <td>{{ $student->major_code }}</td>
                                    <td>{{ $student->graduation_decision_number }}</td>
                                    <td>{{ $student->graduation_decision_date }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->survey_method }}</td>
                                    <td>{{ $student->has_response ? '1' : '' }}</td>
                                    <td>{{ $student->major_name }}</td>
                                    <td>{{ $student->faculty_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
