@extends('admin.layouts.master')

@section('title', 'Báo cáo - Mẫu số 03')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="mb-1 fw-bold">Báo cáo - Thống kê</h5>
                <nav style="--bs-breadcrumb-divider: '>'; font-size: 14px;">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Báo cáo - Thống kê</a></li>
                        <li class="breadcrumb-item active">Biểu đồ thống kê</li>
                    </ol>
                </nav>
            </div>
        </div>

        <form id="filterForm" class="row g-3 mb-4">
            <!-- Nhóm: Bắt buộc -->
            <div class="col-md-3">
                <label for="survey_period" class="form-label">Đợt khảo sát <span class="text-danger">*</span></label>
                <select id="survey_period" class="form-select" required>
                    <option value="">-- Chọn đợt khảo sát --</option>
                    <option value="dot1">Khảo sát T6/2023</option>
                    <option value="dot2">Khảo sát T12/2023</option>
                </select>
            </div>

            <!-- Nhóm: Thông tin sinh viên -->
            <div class="col-md-3">
                <label class="form-label">Sinh viên khảo sát</label>
                <select class="form-select filter-option" data-chart="chart_surveyed">
                    <option value="">-- Tất cả --</option>
                    <option value="yes">Đã khảo sát</option>
                    <option value="no">Chưa khảo sát</option>
                </select>
            </div>

            <!-- Nhóm: Việc làm -->
            <div class="col-md-3">
                <label class="form-label">Tình trạng việc làm</label>
                <select class="form-select filter-option" data-chart="chart_employment_status">
                    <option value="">-- Tất cả --</option>
                    <option value="co_viec">Đã có việc</option>
                    <option value="chua_co_viec">Chưa có việc</option>
                    <option value="tiep_tuc_hoc">Tiếp tục học</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Thời gian có việc</label>
                <select class="form-select filter-option" data-chart="chart_employment_time">
                    <option value="">-- Tất cả --</option>
                    <option value="lt3">Dưới 3 tháng</option>
                    <option value="3to6">3 - 6 tháng</option>
                    <option value="6to12">6 - 12 tháng</option>
                    <option value="gt12">Trên 12 tháng</option>
                </select>
            </div>

            <!-- Nhóm: Cơ quan công tác -->
            <div class="col-md-3">
                <label class="form-label">Tên cơ quan công tác</label>
                <select class="form-select filter-option" data-chart="chart_company_name">
                    <option value="">-- Chọn cơ quan --</option>
                    <option value="FPT Software">FPT Software</option>
                    <option value="VNPT">VNPT</option>
                    <option value="VinGroup">VinGroup</option>
                    <option value="EVN">EVN</option>
                    <option value="Mobifone">Mobifone</option>
                    <option value="Viettel">Viettel</option>
                    <option value="CMC Corporation">CMC Corporation</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Khu vực đơn vị làm việc</label>
                <select class="form-select filter-option" data-chart="chart_work_sector">
                    <option value="">-- Tất cả --</option>
                    <option value="state">Nhà nước</option>
                    <option value="private">Tư nhân</option>
                    <option value="foreign">Có yếu tố nước ngoài</option>
                    <option value="self_employed">Tự tạo việc làm</option>
                </select>
            </div>

            <!-- Nhóm: Thông tin nghề nghiệp -->
            <div class="col-md-3">
                <label class="form-label">Chức danh công việc</label>
                <select class="form-select filter-option" data-chart="chart_job_position">
                    <option value="">-- Tất cả --</option>
                    <option value="dev">Developer</option>
                    <option value="tester">Tester</option>
                    <option value="data">Data Analyst</option>
                    <option value="sysadmin">System Admin</option>
                    <option value="pm">Project Manager</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Liên quan ngành đào tạo</label>
                <select class="form-select filter-option" data-chart="chart_job_relevance">
                    <option value="">-- Tất cả --</option>
                    <option value="dung_nganh">Đúng ngành</option>
                    <option value="lien_quan">Liên quan</option>
                    <option value="khong_lien_quan">Không liên quan</option>
                </select>
            </div>

            <!-- Nhóm: Thu nhập -->
            <div class="col-md-3">
                <label class="form-label">Thu nhập hiện tại</label>
                <select class="form-select filter-option" data-chart="chart_income">
                    <option value="">-- Tất cả --</option>
                    <option value="lt5m">Dưới 5 triệu</option>
                    <option value="5to10m">5 - 10 triệu</option>
                    <option value="10to15m">Trên 10 - 15 triệu</option>
                    <option value="gt15m">Trên 15 triệu</option>
                </select>
            </div>
        </form>

        <div id="reportSection" class="row g-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const surveyPeriodSelect = document.getElementById('survey_period');
        const reportSection = document.getElementById('reportSection');

        const mockData = {
            chart_surveyed: {
                type: 'pie',
                labels: ["Đã khảo sát", "Chưa khảo sát"],
                data: [120, 30]
            },
            chart_employment_status: {
                type: 'pie',
                labels: ["Đã có việc", "Chưa có việc", "Tiếp tục học"],
                data: [80, 20, 50]
            },
            chart_employment_time: {
                type: 'bar',
                labels: ["<3 tháng", "3-6 tháng", "6-12 tháng", ">12 tháng"],
                data: [30, 40, 25, 15]
            },
            chart_company_name: {
                type: 'pie',
                labels: ["FPT Software", "VNPT", "VinGroup", "EVN", "Mobifone"],
                data: [40, 20, 15, 10, 5],
                // horizontal: true
            },
            chart_work_sector: {
                type: 'pie',
                labels: ["Nhà nước", "Tư nhân", "Nước ngoài", "Tự tạo việc làm"],
                data: [50, 60, 20, 10]
            },
            chart_job_position: {
                type: 'pie',
                labels: ["Developer", "Tester", "Data Analyst", "System Admin", "PM"],
                data: [30, 15, 10, 5, 10]
            },
            chart_job_relevance: {
                type: 'pie',
                labels: ["Đúng ngành", "Liên quan", "Không liên quan"],
                data: [60, 30, 10]
            },
            chart_income: {
                type: 'bar',
                labels: ["<5 triệu", "5-10 triệu", "10-15 triệu", ">15 triệu"],
                data: [10, 50, 25, 15]
            }
        };

        function renderChart(canvas, chartId) {
            const ctx = canvas.getContext('2d');
            const dataset = mockData[chartId];
            const chartType = dataset.horizontal ? 'bar' : dataset.type;

            return new Chart(ctx, {
                type: chartType,
                data: {
                    labels: dataset.labels,
                    datasets: [{
                        label: 'Số lượng',
                        data: dataset.data,
                        backgroundColor: [
                            '#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2', '#20c997', '#fd7e14'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    animation: false,
                    indexAxis: dataset.horizontal ? 'y' : 'x',
                    plugins: {
                        legend: {
                            position: dataset.type === 'bar' ? 'top' : 'bottom'
                        },
                        tooltip: {
                            enabled: true
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: dataset.type === 'bar' || dataset.horizontal ? {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    } : {}
                }
            });
        }

        document.querySelectorAll('.filter-option').forEach(select => {
            select.addEventListener('change', function() {
                const chartId = this.dataset.chart;

                if (!surveyPeriodSelect.value) {
                    alert('Vui lòng chọn đợt khảo sát trước khi lọc dữ liệu.');
                    this.value = '';
                    return;
                }

                if (!chartId || !mockData[chartId]) return;

                const existingChart = document.getElementById(chartId);
                if (!existingChart) {
                    const div = document.createElement('div');
                    div.classList.add('col-md-6');
                    div.id = chartId;

                    const canvasId = chartId + '_canvas';
                    div.innerHTML = `
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Biểu đồ: ${this.options[this.selectedIndex].text}</span>
                            <button type="button" class="btn-close" onclick="document.getElementById('${chartId}').remove()"></button>
                        </div>
                        <div class="card-body">
                            <canvas id="${canvasId}" width="400" height="400"></canvas>
                        </div>
                    </div>
                `;
                    reportSection.appendChild(div);
                    renderChart(document.getElementById(canvasId), chartId);
                }
            });
        });
    </script>



@endsection
