@extends('admin.layouts.no-master') {{-- Layout đơn giản không chứa admin --}}

@section('title', 'Xác thực sinh viên')

@section('content')
    <style>
        body {
            background-color: #f5f6fa;
        }

        .auth-card {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .auth-card img {
            width: 80px;
            margin-bottom: 20px;
        }

        .auth-card h4 {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }
    </style>

    <div class="auth-card text-center">
        {{-- Logo học viện --}}
        <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" alt="Logo Học viện Nông nghiệp">

        <h4>Xác thực Sinh viên</h4>
        <p class="text-muted mb-4">Vui lòng điền <strong>ít nhất 2 thông tin</strong> để xác thực</p>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.contact-survey.authenticate.check', ['id' => $batch->id]) }}" method="POST" class="text-start">
            @csrf

            <div class="mb-3">
                <label for="student_code">Mã sinh viên</label>
                <input type="text" class="form-control" name="student_code" placeholder="Nhập MSSV">
            </div>

            <div class="mb-3">
                <label for="email">Email sinh viên</label>
                <input type="email" class="form-control" name="email" placeholder="Nhập email">
            </div>

            <div class="mb-3">
                <label for="phone">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại">
            </div>

            <div class="mb-3">
                <label for="cccd">Số CCCD</label>
                <input type="text" class="form-control" name="cccd" placeholder="Nhập CCCD">
            </div>

            <div class="mb-3">
                <label for="date_of_birth">Ngày sinh</label>
                <input type="date" class="form-control" name="date_of_birth">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Xác thực</button>
        </form>
    </div>
@endsection
