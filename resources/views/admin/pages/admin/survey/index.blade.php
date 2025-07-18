@extends('admin.layouts.master')

@section('title', 'Đợt khảo sát')

@section('content')
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Khảo sát - Khảo sát việc làm</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Khảo sát việc làm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đợt khảo sát</li>
                    </ol>
                </nav>
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
                            <td><strong>Tiêu đề khảo sát</strong></td>
                            <td><strong>Trạng thái</strong></td>
                            <td><strong>Đợt tốt nghiệp</strong></td>
                            <td><strong>Bắt đầu</strong></td>
                            <td><strong>Kết thúc</strong></td>
                            <td><strong>Phản hồi</strong></td>
                            <td><strong>Hành động</strong></td>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->isActive() ? 'Hoạt động' : 'Ẩn' }}</td>

                                <td>
                                    @if ($item->graduations->count() > 0)
                                        @foreach ($item->graduations as $dot)
                                            <a target="_blank"
                                                href="{{ route('admin.graduation-student.show', ['id' => $dot->id]) }}"
                                                class="d-block text-decoration-none text-primary mb-1">
                                                {{ $dot->name }}
                                            </a>
                                            <hr />
                                        @endforeach
                                    @endif
                                </td>

                                <td>{{ $item->start_time }}</td>
                                <td>{{ $item->end_time }}</td>
                                <td>
                                    @php
                                        $totalPhanHoi = App\Models\EmploymentSurveyResponse::where(
                                            'survey_period_id',
                                            $item->id,
                                        )->count();
                                        $countDot = $item->graduations()->pluck('id')->toArray();
                                        $countStudent = \App\Models\GraduationStudent::query()
                                            ->whereIn('graduation_id', $countDot)
                                            ->count();
                                    @endphp

                                    <strong class="text-primary">
                                        {{ $totalPhanHoi }} / {{ $countStudent }}
                                    </strong>
                                </td>

                                <td class="text-center d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.survey.edit', ['id' => $item->id]) }}"
                                        class="btn btn-sm btn-outline-primary" title="Chỉnh sửa"
                                        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button class="btn btn-sm btn-outline-secondary" title="Sao chép đường dẫn"
                                        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                        data-link="{{ route('my_form', ['survey_id' => $item->id]) }}"
                                        onclick="copySurveyLink(this)">
                                        <i class="bi bi-clipboard"></i>
                                    </button>

                                    <a href="{{ route('admin.survey.form', ['id' => $item->id]) }}"
                                        class="btn btn-sm btn-outline-primary" title="Show form"
                                        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-list-nested"></i>
                                    </a>

                                    <form action="{{ route('admin.survey.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Xác nhận xoá khảo sát này?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    {{-- @if ($totalPhanHoi > 0)
                                    <a href="{{ route('admin.survey.result', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết khảo sát"
                                       style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </a>
                                    @endif --}}
                                    @if ($totalPhanHoi > 0)
                                        <a href="{{ route('admin.survey.result', ['id' => $item->id]) }}"
                                            class="btn btn-outline-primary btn-sm" title="Xem kết quả">
                                            <i class="bi bi-bar-chart-fill me-1"></i> ({{ $totalPhanHoi }})
                                        </a>
                                    @endif


                                    <form action="{{ route('send_mail', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Send mail?');" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button class="btn btn-sm btn-outline-success"
                                            title="Gửi biểu mẫu khảo sát qua mail"
                                            style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"
                                            {{--                                                 onclick="sendSurveyByEmail(this)" --}}>
                                            <i class="bi bi-envelope"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Phân trang --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function copySurveyLink(button) {
            const link = button.getAttribute('data-link') || '';
            if (!link) {
                alert('Không có đường dẫn để sao chép.');
                return;
            }
            navigator.clipboard.writeText(link).then(() => {
                alert('Đường dẫn khảo sát đã được sao chép!');
            }).catch(() => {
                alert('Sao chép thất bại, vui lòng thử lại.');
            });
        }

        function sendSurveyByEmail(button) {
            // Ví dụ đơn giản, bạn có thể hiện modal nhập email hoặc gọi API gửi mail
            alert('Chức năng gửi biểu mẫu khảo sát qua mail sẽ được phát triển sau.');
        }

        // Hàm toggleFilter nếu chưa có trong file bạn có thể thêm
        function toggleFilter(id) {
            const el = document.getElementById(id);
            if (el.style.display === 'block') {
                el.style.display = 'none';
            } else {
                el.style.display = 'block';
            }
        }
    </script>
@endsection
