@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Khảo sát - Khảo sát việc làm</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.survey.index') }}">Khảo sát việc làm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kết quả khảo sát</li>
                </ol>
            </nav>
            <br>

            <div>
                - Năm khảo sat: {{ $schoolYear }} <br>
                - Đợt khảo sát:
                <ul>
                    @foreach($allDotTotNghiep as $item)
                    <li><a target="_blank" href="{{ route('admin.graduation-student.show', ['id' => $item->id]) }}">{{ $item->name }}</a></li>
                    @endforeach
                </ul>
                - Số lượt khảo sát:
                @php
                    $totalPhanHoi = App\Models\EmploymentSurveyResponse::where('survey_period_id', $survey->id)->count();
                    $countDot = $survey->graduations()->pluck('id')->toArray();
                    $countStudent = \App\Models\GraduationStudent::query()->whereIn('graduation_id', $countDot)->count();
                @endphp

                <strong class="text-primary">
                    {{ $totalPhanHoi }} / {{ $countStudent }}
                </strong>
            </div>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('admin.survey.create') }}" class="btn btn-primary mt-2 mt-sm-0">
                <i class="bi bi-plus-lg me-1"></i> Tạo mới
            </a>
        </div>
    </div>

    @include('admin.layouts.noti')
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-bordered">
                <thead>
                <tr>
                    <td><strong>STT</strong></td>
                    <td><strong>Mã sv</strong></td>
                    <td><strong>Email</strong></td>
                    <td><strong>Name</strong></td>
                    <td>Ngày phản hồi</td>
                    <td><strong>Hành động</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->code_student  }}</td>
                        <td>{{ $item->email  }}</td>
                        <td>{{ $item->full_name  }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : "" }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.survey.result_detail', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-primary" title="Chi tiết"
                               style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 4px">
                                <i class="bi bi-info"></i>
                            </a>
                            <!-- Nút Export PDF -->
                            <button class="btn btn-sm btn-outline-primary"
                                    title="Xuất PDF"
                                    onclick="downloadPdf({{ $item->id }})"
                                    style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 4px">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($data->count())
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    function downloadPdf(resultId) {
        const link = document.createElement('a');
        link.href = "{{ route('export_pdf_v2', ['resultId' => '__ID__']) }}".replace('__ID__', resultId);

        console.log(link.href, '//link.href')

        link.setAttribute('download', '');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
