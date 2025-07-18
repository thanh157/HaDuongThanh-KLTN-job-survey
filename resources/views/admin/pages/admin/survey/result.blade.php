@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
<div class="container py-4">
    <!-- Header thông tin khảo sát -->
    <div class="mb-4 border-bottom pb-3">
        <h4 class="fw-bold text-primary mb-2">Khảo sát: {{ $survey->title }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.survey.index') }}">Khảo sát việc làm</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kết quả khảo sát</li>
            </ol>
        </nav>

        <div>
            <p class="mb-1">🔹 <strong>Năm khảo sát:</strong> {{ $schoolYear }}</p>
            <p class="mb-1">🔹 <strong>Đợt khảo sát:</strong></p>
            <ul>
                @foreach($allDotTotNghiep as $item)
                    <li>
                        <a href="{{ route('admin.graduation-student.show', ['id' => $item->id]) }}" target="_blank">
                            {{ $item->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            @php
                $totalPhanHoi = App\Models\EmploymentSurveyResponse::where('survey_period_id', $survey->id)->count();
                $countDot = $survey->graduations()->pluck('id')->toArray();
                $countStudent = \App\Models\GraduationStudent::query()->whereIn('graduation_id', $countDot)->count();
            @endphp
            <p class="mb-0">
                🔹 <strong class="text-success">Số lượt phản hồi:</strong> {{ $totalPhanHoi }} / {{ $countStudent }}
            </p>
        </div>
    </div>

    <!-- Tìm kiếm và quay lại -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
        <!-- Tìm kiếm -->
        <form action="" method="GET" class="d-flex flex-grow-1 flex-md-grow-0 w-100" style="max-width: 500px;">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Tìm theo mã sinh viên hoặc họ tên">
                <button type="submit" class="btn btn-outline-primary px-4">Tìm kiếm</button>
            </div>
        </form>

        <!-- Quay lại -->
        <div>
            @if (request()->has('search'))
                <a href="{{ route('admin.contact-survey.results', $survey->id) }}" class="btn btn-secondary btn-sm">
                    ← Quay lại danh sách
                </a>
            @else
                <a href="{{ route('admin.survey.index') }}" class="btn btn-outline-primary btn-sm">
                    ← Quay lại ds khảo sát
                </a>
            @endif
        </div>
    </div>

    @include('admin.layouts.noti')

    <!-- Bảng dữ liệu -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-nowrap mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã SV</th>
                        <th>Email</th>
                        <th>Họ tên</th>
                        <th>Ngày phản hồi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">
                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $item->code_student }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->full_name }}</td>
                            <td class="text-center">
                                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : '' }}
                            </td>
                            <td class="text-center d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.survey.result_detail', ['id' => $item->id]) }}"
                                    class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                    <i class="bi bi-info-lg"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Xuất PDF"
                                    onclick="downloadPdf({{ $item->id }})">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3"><em>Không có dữ liệu</em></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Phân trang -->
            @if ($data->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Script Export PDF -->
<script>
    function downloadPdf(resultId) {
        const link = document.createElement('a');
        link.href = "{{ route('export_pdf_v2', ['resultId' => '__ID__']) }}".replace('__ID__', resultId);
        link.setAttribute('download', '');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
