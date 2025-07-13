@extends('admin.layouts.master')

@section('title', 'Tạo đợt khảo sát')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Tạo đợt khảo sát thông tin liên hệ</h4>

    <form action="{{ route('admin.contact-survey-batches.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tiêu đề *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu *</label>
            <input type="date" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày kết thúc *</label>
            <input type="date" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Tạo đợt khảo sát</button>
    </form>
</div>
@endsection
