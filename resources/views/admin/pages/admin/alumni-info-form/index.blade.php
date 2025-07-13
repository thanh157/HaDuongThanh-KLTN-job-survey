{{-- resources/views/admin/pages/contact-survey/index.blade.php --}}
@extends('admin.layouts.master')

@section('title', 'Danh sách đợt khảo sát liên hệ')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Danh sách đợt khảo sát</h4>
            <a href="{{ route('admin.contact-survey.create') }}" class="btn btn-primary">...</a>

            <i class="bi bi-plus-lg me-1"></i> Tạo mới
            </a>
        </div>

        @include('admin.layouts.noti')

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Số SV đã khảo sát</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            <tr>
                                <td>{{ $batch->title }}</td>
                                <td>{{ $batch->start_time }}</td>
                                <td>{{ $batch->end_time }}</td>
                                <td>{{ $batch->alumni_contacts_count }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.survey.edit', $batch->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.survey.destroy', $batch->id) }}" method="POST"
                                        onsubmit="return confirm('Xoá đợt khảo sát này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.survey.results', $batch->id) }}"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-bar-chart"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if ($batches->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Chưa có đợt khảo sát nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
