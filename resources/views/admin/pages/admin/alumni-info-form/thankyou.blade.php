@extends('admin.layouts.master')

@section('title', 'Cảm ơn bạn')

@section('content')
    <div class="container py-5 text-center">
        <h2 class="fw-bold text-success">🎉 Cảm ơn bạn đã hoàn thành khảo sát!</h2>
        <p class="mt-3">Thông tin của bạn đã được ghi nhận thành công.</p>
        <a href="{{ route('admin.contact-survey.index') }}" class="btn btn-primary mt-4">Quay về danh sách</a>
    </div>
@endsection
