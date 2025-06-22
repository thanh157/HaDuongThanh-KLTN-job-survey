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

        <!-- Bộ lọc -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="year" class="form-label">Năm tốt nghiệp</label>
                <select id="year" class="form-select">
                    <option value="">-- Chọn năm --</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="region" class="form-label">Vùng miền</label>
                <select id="region" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <option value="bac">Miền Bắc</option>
                    <option value="trung">Miền Trung</option>
                    <option value="nam">Miền Nam</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="position" class="form-label">Vị trí việc làm</label>
                <select id="position" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <option value="dev">Developer</option>
                    <option value="tester">Tester</option>
                    <option value="data">Data Analyst</option>
                    <option value="sysadmin">System Admin</option>
                    <option value="pm">Project Manager</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="jobArea" class="form-label">Khu vực làm việc</label>
                <select id="jobArea" class="form-select">
                    <option value="">-- Tất cả --</option>
                    <option value="trongnuoc">Trong nước</option>
                    <option value="ngoainuoc">Ngoài nước</option>
                </select>
            </div>
            <div class="col-md-12 text-end">
                <button type="button" id="showReportBtn" class="btn btn-success px-4">Xem biểu đồ</button>
            </div>
        </form>

        <!-- Khu vực báo cáo -->
        <div id="reportSection" style="display: none;">
            <div class="row charts-bar-section">
                <div class="col-md-6"><canvas id="chart1" class="chart-canvas"></canvas></div>
                <div class="col-md-6"><canvas id="chart2" class="chart-canvas"></canvas></div>
            </div>
            <div class="row charts-pie-section">
                <div class="col-md-4"><canvas id="chart3" class="chart-canvas"></canvas></div>
                <div class="col-md-4"><canvas id="chart4" class="chart-canvas"></canvas></div>
                <div class="col-md-4"><canvas id="chart5" class="chart-canvas"></canvas></div>
            </div>
        </div>
    </div>

    <style>
        .chart-canvas {
            width: 100% !important;
            height: 350px !important;
            /* chiều cao canvas */
        }

        /* Đường kẻ phân cách nhóm biểu đồ cột và tròn */
        .charts-bar-section {
            border-bottom: 3px solid #b7b8b9;
            /* màu xanh Bootstrap primary */
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .charts-pie-section {
            padding-top: 1.5rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('showReportBtn').addEventListener('click', function() {
            document.getElementById('reportSection').style.display = 'block';
            renderCharts();
        });

        function renderCharts() {
            const nganhCNTT = ['Khoa học MT', 'Trí tuệ NT', 'CN thông tin', 'Mạng MT & truyền thông', 'CN phần mềm'];
            const phanHoi = [75, 70, 85, 68, 80];
            const coViec = [65, 60, 75, 55, 72];
            const chuaCoViec = [10, 10, 10, 13, 8];
            const dungNganh = [45, 40, 60, 43, 55];
            const lienQuan = [15, 12, 10, 10, 12];
            const khongLienQuan = [5, 8, 5, 2, 5];
            const tiepTucHoc = [3, 5, 4, 5, 3];
            const trongNuoc = [60, 55, 70, 50, 60];
            const ngoaiNuoc = [5, 5, 5, 5, 12];

            new Chart(document.getElementById('chart1'), {
                type: 'bar',
                data: {
                    labels: nganhCNTT,
                    datasets: [{
                            label: 'Có việc làm',
                            data: coViec,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        },
                        {
                            label: 'Chưa có việc làm',
                            data: chuaCoViec,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'So sánh sinh viên có và chưa có việc làm'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0,
                                font: {
                                    size: 12
                                },
                                autoSkip: false,
                                maxTicksLimit: nganhCNTT.length,
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('chart2'), {
                type: 'bar',
                data: {
                    labels: nganhCNTT,
                    datasets: [{
                            label: 'Đúng ngành',
                            data: dungNganh,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)'
                        },
                        {
                            label: 'Liên quan',
                            data: lienQuan,
                            backgroundColor: 'rgba(255, 205, 86, 0.7)'
                        },
                        {
                            label: 'Không liên quan',
                            data: khongLienQuan,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Mức độ liên quan ngành của việc làm'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0,
                                font: {
                                    size: 12
                                },
                                autoSkip: false,
                                maxTicksLimit: nganhCNTT.length,
                            }
                        }
                    }
                }
            });

            new Chart(document.getElementById('chart3'), {
                type: 'pie',
                data: {
                    labels: ['Trong nước', 'Ngoài nước'],
                    datasets: [{
                        data: [trongNuoc.reduce((a, b) => a + b, 0), ngoaiNuoc.reduce((a, b) => a + b, 0)],
                        backgroundColor: ['#4bc0c0', '#ff6384']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Khu vực làm việc'
                        }
                    }
                }
            });

            new Chart(document.getElementById('chart4'), {
                type: 'pie',
                data: {
                    labels: ['Tiếp tục học', 'Chưa có việc làm'],
                    datasets: [{
                        data: [tiepTucHoc.reduce((a, b) => a + b, 0), chuaCoViec.reduce((a, b) => a + b,
                            0)],
                        backgroundColor: ['rgba(255, 206, 86, 0.7)', 'rgba(255, 99, 132, 0.7)']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Tình trạng khác'
                        }
                    }
                }
            });

            new Chart(document.getElementById('chart5'), {
                type: 'pie',
                data: {
                    labels: ['Developer', 'Tester', 'Data Analyst', 'Sys Admin', 'Project Manager'],
                    datasets: [{
                        data: [90, 30, 25, 20, 35],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Chức vụ của sinh viên làm việc'
                        }
                    }
                }
            });
        }
    </script>
@endsection
