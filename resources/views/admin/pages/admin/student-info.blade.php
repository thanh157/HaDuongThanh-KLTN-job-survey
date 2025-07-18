@extends('admin.layouts.master')

@section('title', 'Danh sách sinh viên đã khảo sát')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Quản lý thông tin cựu sinh viên</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.student-info.index') }}">Thông tin cựu sinh viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin sinh viên đã khảo sát</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!-- Tìm kiếm -->
        <form method="GET" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã SV hoặc họ tên"
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            {{-- <th>ID</th> --}}
                            <th>Mã SV</th>
                            <th>Họ tên</th>
                            <th>Survey</th>
                            <th>Đợt tốt nghiệp</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student as $item)
                            @php
                                $surveyIds = \App\Models\AlumniContact::where('student_code', $item->code)
                                    ->pluck('survey_batch_id')
                                    ->toArray();
                                $surveys = [];
                                if (!empty($surveyIds)) {
                                    $surveys = \App\Models\ContactSurvey::whereIn('id', $surveyIds)->get();
                                }
                            @endphp

                            <tr>
                                <td>{{ ($student->currentPage() - 1) * $student->perPage() + $loop->iteration }}</td>
                                {{-- <td>{{ $item->id }}</td> --}}
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->full_name }}</td>
                                <td>
                                    @foreach ($surveys as $s)
                                        @php
                                            $res = \App\Models\AlumniContact::where('student_code', $item->code)
                                                ->where('survey_batch_id', $s->id)
                                                ->first();
                                        @endphp
                                        @if (!empty($res))
                                            <div><a
                                                    href="{{ route('admin.contact-survey.results', ['id' => $s->id]) }}">{{ $s->title }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $gIds = $surveyIds
                                            ? \App\Models\ContactSurveyGraduation::where(
                                                'contact_survey_id',
                                                $surveyIds,
                                            )
                                                ->pluck('graduation_id')
                                                ->toArray()
                                            : [];
                                        $g = \App\Models\Graduation::whereIn('id', $gIds)->get();
                                    @endphp

                                    @if ($g->isNotEmpty())
                                        @foreach ($g as $itemX)
                                            <div>
                                                <a
                                                    href="{{ route('admin.graduation-student.show', ['id' => $itemX->id]) }}">{{ $itemX->name }}</a>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted fst-italic">Chưa khảo sát</span>
                                    @endif
                                </td>

                                {{-- <td>
                                @php
                                $gIds = $surveyIds ? \App\Models\ContactSurveyGraduation::where('contact_survey_id', $surveyIds)->pluck('graduation_id')->toArray() : [];
                                $g = \App\Models\Graduation::whereIn('id', $gIds)->get();
                                @endphp
                                @foreach ($g as $itemX)
                                    <div><a href="{{ route('admin.graduation-student.show', ['id' => $itemX->id]) }}">{{ $itemX->name }}</a></div>
                                @endforeach
                            </td> --}}
                                <td>
                                    @if (!empty($surveys))
                                        @foreach ($surveys as $s)
                                            <div style="margin-bottom: 3px">
                                                <a href="{{ route('admin.alumni-show', ['studentId' => $item->id, 'surveyId' => $s->id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> Xem
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted fst-italic">Chưa có dữ liệu khảo sát</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Phân trang --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $student->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
