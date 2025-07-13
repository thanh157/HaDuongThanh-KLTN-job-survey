@extends('admin.layouts.master')

@section('title', 'Tạo đợt khảo sát')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">Tạo đợt khảo sát mới</h4>

    <form action="{{ route('admin.survey.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề khảo sát <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="graduation_id" class="form-label">Đợt tốt nghiệp</label>
            <select name="graduation_id" id="graduation_id" class="form-select">
                <option value="">-- Chọn đợt tốt nghiệp --</option>
                @foreach ($graduations as $g)
                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
            <input type="date" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
            <input type="date" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu</button>
    </form>
</div>
@endsection
