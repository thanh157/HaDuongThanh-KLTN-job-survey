@extends('admin.layouts.master')

@section('title', 'Biểu đồ thống kê')

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
        <div class="col-md-3">
            <label for="survey_period" class="form-label">Đợt khảo sát <span class="text-danger">*</span></label>
            <select id="survey_period" class="form-select" required>
                <option value="">-- Chọn đợt khảo sát --</option>
                @foreach ($graduations as $grad)
                    <option value="{{ $grad['id'] }}">{{ $grad['name'] }} - {{ $grad['school_year'] }}</option>
                @endforeach
            </select>
        </div>

        @php
            $filters = [
                ['label' => 'Sinh viên khảo sát', 'chart' => 'chart_surveyed', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Tình trạng việc làm', 'chart' => 'chart_employment_status', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Thời gian có việc', 'chart' => 'chart_employment_time', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Tên cơ quan công tác', 'chart' => 'chart_company_name', 'placeholder' => '-- Chọn cơ quan --'],
                ['label' => 'Khu vực đơn vị làm việc', 'chart' => 'chart_work_sector', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Chức danh công việc', 'chart' => 'chart_job_position', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Liên quan ngành đào tạo', 'chart' => 'chart_job_relevance', 'placeholder' => '-- Tất cả --'],
                ['label' => 'Thu nhập hiện tại', 'chart' => 'chart_income', 'placeholder' => '-- Tất cả --'],
            ];
        @endphp

        @foreach ($filters as $filter)
            <div class="col-md-3">
                <label class="form-label">{{ $filter['label'] }}</label>
                <div class="form-control filter-click" data-chart="{{ $filter['chart'] }}"
                    style="height: 38px; display: flex; align-items: center; cursor: pointer;">
                    {{ $filter['placeholder'] }}
                </div>
            </div>
        @endforeach
    </form>

    <div id="reportSection" class="row g-4"></div>
</div>

<style>
    .active-filter {
        background-color: #e9f7ef !important;
        border: 2px solid #28a745;
        font-weight: 600;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const surveyPeriodSelect = document.getElementById('survey_period');
    const reportSection = document.getElementById('reportSection');

    async function fetchChartData(chartId, surveyPeriodId) {
        const response = await fetch(`/admin/chart-statistics/data?survey_period_id=${surveyPeriodId}&chart=${chartId}`);
        if (!response.ok) {
            alert('Không thể tải dữ liệu biểu đồ!');
            return null;
        }
        return await response.json();
    }

    async function renderChart(canvas, chartId, surveyPeriodId) {
        const ctx = canvas.getContext('2d');
        const dataset = await fetchChartData(chartId, surveyPeriodId);
        if (!dataset) return;

        const chartType = dataset.horizontal ? 'bar' : dataset.type;

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: dataset.labels,
                datasets: [{
                    label: 'Số lượng',
                    data: dataset.data,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2', '#20c997', '#fd7e14'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
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
                scales: (dataset.type === 'bar' || dataset.horizontal) ? {
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

    function removeChart(chartId) {
        const chartEl = document.getElementById(chartId);
        if (chartEl) chartEl.remove();
        const filterDiv = document.querySelector(`[data-chart="${chartId}"]`);
        if (filterDiv) filterDiv.classList.remove('active-filter');
    }

    document.querySelectorAll('.filter-click').forEach(div => {
        div.addEventListener('click', function () {
            const chartId = this.dataset.chart;
            const surveyPeriodId = surveyPeriodSelect.value;

            if (!surveyPeriodId) {
                alert('Vui lòng chọn đợt khảo sát trước khi lọc dữ liệu.');
                return;
            }

            const existingChart = document.getElementById(chartId);
            if (!existingChart) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('col-md-6');
                wrapper.id = chartId;

                const canvasId = `${chartId}_canvas`;
                wrapper.innerHTML = `
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Biểu đồ: ${this.innerText}</span>
                            <button type="button" class="btn-close" onclick="removeChart('${chartId}')"></button>
                        </div>
                        <div class="card-body">
                            <canvas id="${canvasId}" width="400" height="400"></canvas>
                        </div>
                    </div>`;
                reportSection.appendChild(wrapper);
                renderChart(document.getElementById(canvasId), chartId, surveyPeriodId);
                this.classList.add('active-filter');
            }
        });
    });
</script>
@endsection
