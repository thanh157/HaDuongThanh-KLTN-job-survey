@extends('admin.layouts.master')

{{-- @section('title', 'Bảng điều khiển') --}}

@section('content')
    <div class="card">

        <!-- 👋 Chào theo thời gian trong ngày -->
        <div class="card-body pt-4 pb-0">
            <div class="alert custom-greeting star-bg d-flex flex-column flex-sm-row align-items-start align-items-sm-center shadow-sm p-3 rounded mb-4"
                role="alert">
                <i class="fa-solid fa-sun me-2 text-warning fs-4 mb-2 mb-sm-0"></i>
                <div>
                    <strong id="greeting" class="fs-4 text-gradient"></strong>
                    <div class="text-muted small">Chúc bạn có một ngày làm việc hiệu quả, Supper Admin CNTT</div>
                </div>
            </div>
        </div>

        <div class="card-body pt-0">

            {{-- Tongquan --}}
            <div class="mb-2">
                <p class="fw-semibold">Tổng quan</p>
                <div class="row">
                    <!-- #1 -->
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="p-3 rounded shadow-sm d-flex flex-column justify-content-between h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold text-muted mb-1 small text-uppercase">PHIẾU ĐÃ KHẢO SÁT</p>
                                    <h4 class="mb-0">280</h4>
                                </div>
                                <i class="fa-solid fa-file-circle-check text-primary"></i>
                            </div>
                            <small class="text-muted mt-2">Tổng số sinh viên đã phản hồi khảo sát</small>
                        </div>
                    </div>
                    <!-- #2 -->
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="p-3 rounded shadow-sm d-flex flex-column justify-content-between h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold text-muted mb-1 small text-uppercase">TỶ LỆ CÓ VIỆC LÀM</p>
                                    <h4 class="mb-0">88%</h4>
                                </div>
                                <i class="fa-solid fa-briefcase text-primary"></i>
                            </div>
                            <small class="text-muted mt-2">Tỷ lệ sinh viên đã có việc làm sau tốt nghiệp</small>
                        </div>
                    </div>
                    <!-- #3 -->
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="p-3 rounded shadow-sm d-flex flex-column justify-content-between h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold text-muted mb-1 small text-uppercase">LỚP HỌC</p>
                                    <h4 class="mb-0">15</h4>
                                </div>
                                <i class="fa-solid fa-users-line text-primary"></i>
                            </div>
                            <small class="text-muted mt-2">Tổng số lớp học có trong hệ thống</small>
                        </div>
                    </div>
                    <!-- #4 -->
                    <div class="col-12 col-sm-6 col-xl-3 mb-3">
                        <div class="p-3 rounded shadow-sm d-flex flex-column justify-content-between h-100 bg-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold text-muted mb-1 small text-uppercase">ĐỢT TỐT NGHIỆP</p>
                                    <h4 class="mb-0">6</h4>
                                </div>
                                <i class="fa-solid fa-calendar-check text-primary"></i>
                            </div>
                            <small class="text-muted mt-2">Số đợt tốt nghiệp đã thực hiện khảo sát</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- chart  --}}
            <div style="max-width: 960px; margin: 30px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <h3 style="text-align: center; margin-bottom: 25px; color: #333;">Thống kê việc làm sinh viên theo đợt tốt
                    nghiệp</h3>

                <div style="text-align: center; margin-bottom: 20px;">
                    <select id="chartType"
                        style="font-size: 16px; padding: 8px 12px; border-radius: 6px; border: 1.5px solid #888; min-width: 280px; cursor: pointer;">
                        <option value="employed">Tỉ lệ có việc làm / tốt nghiệp</option>
                        <option value="location">Làm trong nước / nước ngoài</option>
                        <option value="field">Đúng ngành / trái ngành</option>
                    </select>
                </div>

                <div style="display: flex; justify-content: space-between; gap: 40px; flex-wrap: wrap;">

                    <!-- Pie Chart Container -->
                    <div
                        style="flex: 1 1 320px; max-width: 320px; background: #fff; padding: 16px; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 12px; text-align: center;">
                        <h4 style="margin-bottom: 16px; color: #444;">Biểu đồ tròn tổng hợp</h4>
                        <canvas id="pieChart" width="300" height="300"
                            style="max-width: 100%; height: auto;"></canvas>
                    </div>

                    <!-- Bar Chart Container -->
                    <div
                        style="flex: 2 1 600px; max-width: 600px; background: #fff; padding: 16px; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 12px; text-align: center;">
                        <h4 style="margin-bottom: 16px; color: #444;">Biểu đồ cột theo đợt</h4>
                        <canvas id="barChart" width="580" height="300"
                            style="max-width: 100%; height: auto;"></canvas>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <!-- ✅ Script chào theo thời gian -->
    <script>
        function getGreeting() {
            const hour = new Date().getHours();
            if (hour >= 5 && hour < 12) return "Chào buổi sáng!";
            if (hour >= 12 && hour < 14) return "Chào buổi trưa!";
            if (hour >= 14 && hour < 18) return "Chào buổi chiều!";
            return "Chào buổi tối!";
        }
        document.getElementById("greeting").innerText = getGreeting();
    </script>
@endsection
