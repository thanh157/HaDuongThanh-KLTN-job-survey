@extends('admin.layouts.no-master')

@section('title', 'Khảo sát liên hệ')

@section('content')
    <style>
        body {
            background-color: #f1f3f4;
        }

        .google-form-style {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .google-form-style .form-section {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .google-form-style label {
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .google-form-style input {
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        .google-form-style input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }

        .survey-time {
            text-align: right;
            font-style: italic;
            font-size: 0.9rem;
            color: #888;
        }

        input[readonly], textarea[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
            color: #6c757d;
        }
    </style>

    <div class="container py-4">
        <div class="google-form-style">
            <!-- Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
                <h6 class="fw-bold mb-1 text-uppercase">Bộ Nông Nghiệp và Phát Triển Nông Thôn</h6>
                <p class="mb-1 text-uppercase fw-semibold">Học Viện Nông Nghiệp Việt Nam</p>
                <small class="text-muted fst-italic">Thị trấn Trâu Quỳ, Gia Lâm, Hà Nội | ĐT: 024.62617586</small>
            </div>

            <!-- Title & Time -->
            <div class="form-section">
                <h5 class="fw-bold text-center">{{ $survey->title }}</h5>
                <p class="text-justify">{{ $survey->description }}</p>
                <div class="survey-time">
                    Thời gian khảo sát:
                    {{ \Carbon\Carbon::parse($survey->start_time)->format('H:i d/m/Y') }} –
                    {{ \Carbon\Carbon::parse($survey->end_time)->format('H:i d/m/Y') }}
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Student Info -->
            <form action="{{ route('contact-survey.submit', ['id' => $survey->id]) }}" method="POST">
                @csrf
                @method('post')

                <div class="form-section">
                    <h6 class="fw-bold">Thông tin sinh viên</h6>

                    <div class="mb-3">
                        <label>Mã sinh viên *</label>
                        <input type="text" name="student_code" id="student-code" class="form-control" value="{{ $student->code }}"
                            placeholder="Nhập mã sinh viên" required readonly>

                    </div>

                    <div class="mb-3">
                        <label>Khóa học *</label>
                        <input type="text" name="course" id="student-course" class="form-control" value="{{ old('course') }}" required>
                    </div>

                </div>

                <div class="form-section">
                    <h6 class="fw-bold">Thông tin cá nhân</h6>

                    <div class="mb-3">
                        <label>Họ và tên *</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Nhập họ và tên" required value="{{ $student->full_name }}" >
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Giới tính *</label>
                            <select name="gender" class="form-select" required>
                                <option value="male" {{$student->gender == "male" ? "selected" : ""}}>Nam</option>
                                <option value="female" {{$student->gender == "female" ? "selected" : ""}}>Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Ngày sinh *</label>
                            <input type="date" name="date_of_birth" class="form-control" required value="{{ $student->dob }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Nơi sinh *</label>
                        <input type="text" name="place_of_birth" class="form-control" placeholder="Nhập nơi sinh">
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ *</label>
                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ hiện tại"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Điện thoại *</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" value="{{ $student->phone }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" value="{{ $student->email }}"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Facebook *</label>
                            <input type="text" name="facebook" class="form-control" placeholder="Nhập link Facebook" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Instagram *</label>
                            <input type="text" name="instagram" class="form-control" placeholder="Nhập link Instagram" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h6 class="fw-bold">Thông tin cơ quan công tác</h6>

                    <div class="mb-3">
                        <label>Tên công ty *</label>
                        <input type="text" name="company_name" class="form-control" placeholder="Nhập tên công ty" required>
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ *</label>
                        <input type="text" name="company_address" class="form-control" required
                            placeholder="Nhập địa chỉ công ty">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Điện thoại *</label>
                            <input type="text" name="company_phone" class="form-control" required
                                placeholder="Nhập số điện thoại công ty">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email *</label>
                            <input type="email" name="company_email" class="form-control" required
                                placeholder="Nhập email công ty">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">Gửi khảo sát</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const studentCodeInput = document.getElementById('student-code');
    //     const studentCourseInput = document.getElementById('student-course');
    //
    //     studentCodeInput.addEventListener('input', function () {
    //         const code = this.value.trim();
    //         if (code.length >= 2 && /^\d+$/.test(code)) {
    //             const course = code.substring(0, 2);
    //             studentCourseInput.value = 'Khóa: ' + course;
    //         } else {
    //             studentCourseInput.value = '';
    //         }
    //     });
    // });

    window.addEventListener('DOMContentLoaded', function () {
        const studentCodeInput = document.getElementById('student-code');
        const studentCourseInput = document.getElementById('student-course');

        if (studentCodeInput && studentCourseInput) {
            const code = studentCodeInput.value.trim();
            if (code.length >= 2 && /^\d+$/.test(code)) {
                const course = code.substring(0, 2);
                studentCourseInput.value = 'Khóa: ' + course;
            } else {
                studentCourseInput.value = '';
            }
        }
    });
</script>

@endsection
