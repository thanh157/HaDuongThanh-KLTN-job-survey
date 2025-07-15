@extends('admin.layouts.no-master')

@section('title', 'Form khảo sát thông tin liên hệ')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .survey-form {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 2rem;
        }

        label.required::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>

    <div class="survey-form">
        <!-- HEADER LOGO -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
            <h6 class="fw-bold mb-1 text-uppercase">BỘ NÔNG NGHIỆP VÀ PHÁT TRIỂN NÔNG THÔN</h6>
            <p class="mb-1 text-uppercase fw-semibold">HỌC VIỆN NÔNG NGHIỆP VIỆT NAM</p>
            <small class="text-muted fst-italic">
                Thị trấn Trâu Quỳ, huyện Gia Lâm, TP Hà Nội | ĐT: 024.62617586 – Fax: 024.62617586
            </small>
        </div>
        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase">{{ $batch->title }}</h5>
            <p>{{ $batch->description }}</p>
            <div class="text-end mt-2">
                <small class="text-muted fst-italic">
                    Thời gian khảo sát: {{ \Carbon\Carbon::parse($batch->start_time)->format('d-m-Y') }} –
                    {{ \Carbon\Carbon::parse($batch->end_time)->format('d-m-Y') }}
                </small>
            </div>
        </div>

        <!-- Nội dung câu hỏi -->
        <form>
            {{-- PHẦN 1: Thông tin sinh viên --}}
            <div class="form-section">
                <h6 class="fw-bold">1. Thông tin sinh viên</h6>
                <div class="mb-3">
                    <label class="form-label required">Mã SV</label>
                    <input type="text" class="form-control" name="ma_sv">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mã lớp</label>
                    <input type="text" class="form-control" name="ma_lop">
                </div>
            </div>

            {{-- PHẦN 2: Thông tin cá nhân --}}
            <div class="form-section">
                <h6 class="fw-bold">2. Thông tin cá nhân</h6>
                <div class="mb-3">
                    <label class="form-label required">Họ và tên</label>
                    <input type="text" class="form-control" name="ho_ten">
                </div>
                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <input type="text" class="form-control" name="gioi_tinh">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" name="ngay_sinh">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nơi sinh</label>
                    <input type="text" class="form-control" name="noi_sinh">
                </div>
                <div class="mb-3">
                    <label class="form-label required">Địa chỉ</label>
                    <input type="text" class="form-control" name="dia_chi">
                </div>
                <div class="mb-3">
                    <label class="form-label required">Điện thoại</label>
                    <input type="text" class="form-control" name="dien_thoai">
                </div>
                <div class="mb-3">
                    <label class="form-label required">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="text" class="form-control" name="facebook">
                </div>
                <div class="mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="text" class="form-control" name="instagram">
                </div>
            </div>

            {{-- PHẦN 3: Thông tin cơ quan công tác --}}
            <div class="form-section">
                <h6 class="fw-bold">3. Thông tin cơ quan công tác</h6>
                <div class="mb-3">
                    <label class="form-label">Tên cơ quan/ công ty</label>
                    <input type="text" class="form-control" name="ten_cong_ty">
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="dia_chi_cong_ty">
                </div>
                <div class="mb-3">
                    <label class="form-label">Điện thoại</label>
                    <input type="text" class="form-control" name="sdt_cong_ty">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email_cong_ty">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Gửi khảo sát</button>
            </div>
        </form>
    </div>
@endsection
