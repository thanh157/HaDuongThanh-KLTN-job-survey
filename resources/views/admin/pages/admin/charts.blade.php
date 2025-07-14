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

    <form id="filterForm" class="row g-3 mb-4" action="{{ route('admin.charts.index') }}" method="GET">
{{--        @csrf--}}
        @method('GET')

        <div class="col-md-3">
            <label for="survey_period" class="form-label">Chọn thuộc tính <span class="text-danger">*</span></label>
            <select name="select" class="form-select" required>
                <option value="">-- Chọn --</option>
                <option value="employment_status" {{ request('select') == 'employment_status' ? "selected" : "" }}>tình trạng việc làm hiện tại</option>
                <option value="work_area" {{ request('select') == 'work_area' ? "selected" : "" }}>Đơn vị Anh/Chị đang làm việc thuộc khu vực nào</option>
                <option value="employed_since" {{ request('select') == 'employed_since' ? "selected" : "" }}>Sau khi tốt nghiệp, Có việc làm từ khi nào</option>
                <option value="trained_field" {{ request('select') == 'trained_field' ? "selected" : "" }}>Có phù hợp với ngành đào tạo không</option>
                <option value="professional_qualification_field" {{ request('select') == 'professional_qualification_field' ? "selected" : "" }}>CV phù hợp chuyên môn</option>
                <option value="level_knowledge_acquired" {{ request('select') == 'level_knowledge_acquired' ? "selected" : "" }}>Có học được kĩ năng</option>
                <option value="average_income" {{ request('select') == 'average_income' ? "selected" : "" }}>Thu nhập (triệu đồng)</option>
                <option value="recruitment_type" {{ request('select') == 'recruitment_type' ? "selected" : "" }}>Hình thức tìm việc</option>
                <option value="job_search_method" {{ request('select') == 'job_search_method' ? "selected" : "" }}>được tuyển theo hình thức nào</option>
                <option value="soft_skills_required" {{ request('select') == 'soft_skills_required' ? "selected" : "" }}>Kỹ năng mềm</option>
                <option value="must_attended_courses" {{ request('select') == 'must_attended_courses' ? "selected" : "" }}>Tham gia khóa học nâng cao nào</option>
                <option value="solutions_get_job" {{ request('select') == 'solutions_get_job' ? "selected" : "" }}>Giải pháp tăng tỉ lệ đúng ngành</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" style="width: 100px">Send</button>
        </div>
    </form>
    <div class="row">
    @foreach ($charts as $index => $chart)
            <div class="col-md-6">
                <canvas id="chart{{ $index }}"></canvas>
            </div>
    @endforeach
    </div>
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
    const chartsData = @json($charts);
    chartsData.forEach((chart, index) => {
        console.log(chart.name, chart.data);

        const ctx = document.getElementById('chart' + index).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(chart.data),
                datasets: [{
                    label: 'Số lượng sinh viên',
                    data: Object.values(chart.data),
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: chart.name,
                        font: {
                            size: 14 // 👈 Tiêu đề nhỏ hơn
                        }
                    },
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 } // 👈 Trục y nhỏ
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 } // 👈 Trục x nhỏ
                        },
                        categoryPercentage: 0.5, // 👈 Thu hẹp mỗi cột
                        barPercentage: 0.7 // 👈 Giảm độ rộng của cột
                    }
                }
            }

        });
    });
</script>
@endsection
