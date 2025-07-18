@extends('admin.layouts.master')

@section('title', 'Đợt khảo sát liên hệ')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Khảo sát - Cựu sinh viên toàn trường</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Cựu sinh viên</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đợt khảo sát</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('admin.contact-survey.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tạo mới
                </a>
            </div>
        </div>

        @include('admin.layouts.noti')

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tiêu đề khảo sát</th>
                            <th>Trạng thái</th>
                            <th>Năm tốt nghiệp</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Phản hồi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batches as $batch)
                            <tr>
                                <td>{{ $batch->title }}</td>
                                <td>
                                    {{ $batch->isActive() ? 'Hoạt động' : 'Ẩn' }}
                                <td>
                                    {{-- Nếu sau này bạn thêm liên kết năm thì duyệt tại đây --}}
                                    @php
                                        $years = $batch->graduations->pluck('school_year')->unique();
                                    @endphp
                                    @foreach ($years as $year)
                                        <span class="badge bg-light text-dark me-1">{{ $year }}</span>
                                    @endforeach
                                </td>
                                <td>{{ \Carbon\Carbon::parse($batch->start_time)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($batch->end_time)->format('d/m/Y') }}</td>
                                <td>
                                    @php $res = \App\Models\AlumniContact::where('survey_batch_id', $batch->id)->count(); @endphp
                                    <a href="{{ route('admin.contact-survey.results', ['id' => $batch->id]) }}"><strong
                                            class="text-warning">{{ $res }}</strong></a> /
                                    {{ $batch->total_students }}
                                </td>

                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.contact-survey.edit', $batch->id) }}"
                                        class="btn btn-outline-primary btn-sm" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Nút sao chép link khảo sát -->
                                    <button class="btn btn-outline-secondary btn-sm" title="Sao chép đường dẫn khảo sát"
                                        onclick="copySurveyLink('{{ route('contact-survey.form', ['id' => $batch->id]) }}')">
                                        <i class="bi bi-clipboard"></i>
                                    </button>

                                    <form action="{{ route('admin.contact-survey.destroy', $batch->id) }}" method="POST"
                                        onsubmit="return confirm('Xoá đợt khảo sát này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.contact-survey.results', $batch->id) }}"
                                        class="btn btn-outline-primary btn-sm" title="Xem kết quả">
                                        <i class="bi bi-bar-chart-fill me-1"></i> ({{ $res }})
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Chưa có đợt khảo sát nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if (method_exists($batches, 'links'))
                    <div class="d-flex justify-content-center mt-3">
                        {{ $batches->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function copySurveyLink(link) {
            navigator.clipboard.writeText(link)
                .then(() => {
                    alert(
                        "Đường dẫn khảo sát đã được sao chép!\nBạn có thể dán vào trình duyệt để truy cập form khảo sát."
                    );
                })
                .catch(() => {
                    alert("Không thể sao chép đường dẫn. Vui lòng thử lại.");
                });
        }
    </script>

@endsection
