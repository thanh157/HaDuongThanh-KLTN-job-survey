@extends('admin.layouts.master')
@section('title', 'Thêm sinh viên tốt nghiệp')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Thêm sinh viên vào đợt ID: {{ $graduationId }}</h4>

    <form action="{{ route('admin.graduation-student.store', $graduationId) }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Mã sinh viên</label>
                <input type="text" name="ma_sv" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Lớp</label>
                <input type="text" name="lop" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ngành</label>
                <input type="text" name="nganh" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="sdt" class="form-control">
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Lưu sinh viên
            </button>
        </div>
    </form>
</div>
@endsection
