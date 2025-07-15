@extends('admin.layouts.no-master')

@section('title', 'Khảo sát liên hệ')

@section('content')
    <style>
        body {
            background-color: #f5f5f5;
        }

        .survey-form,
        .auth-card {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .logo-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .survey-time {
            text-align: right;
            font-style: italic;
            font-size: 0.9rem;
            color: #888;
        }
    </style>

    {{-- ========== FORM XÁC THỰC ========== --}}
    <div id="auth-form" class="auth-card text-center mb-4">
        <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="80" class="mb-3">
        <h4>Xác thực Sinh viên</h4>
        <p class="text-muted">Vui lòng điền <strong>ít nhất 2 thông tin</strong> để xác thực</p>

        <form id="verifyForm" class="text-start">
            <div class="mb-3"><label>Mã sinh viên</label><input class="form-control" name="student_code"></div>
            <div class="mb-3"><label>Email</label><input class="form-control" name="email" type="email"></div>
            <div class="mb-3"><label>Số điện thoại</label><input class="form-control" name="phone"></div>
            <div class="mb-3"><label>CCCD</label><input class="form-control" name="cccd"></div>
            <div class="mb-3"><label>Ngày sinh</label><input class="form-control" name="date_of_birth" type="date">
            </div>
            <button type="submit" class="btn btn-primary w-100">Xác thực</button>
        </form>
    </div>

    {{-- ========== FORM KHẢO SÁT (ẨN BAN ĐẦU) ========== --}}
    <div id="survey-form" class="survey-form" style="display: none;">
        <div class="logo-header">
            <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
            <h6 class="fw-bold text-uppercase mb-1">Bộ Nông Nghiệp và Phát Triển Nông Thôn</h6>
            <p class="mb-1 text-uppercase fw-semibold">Học Viện Nông Nghiệp Việt Nam</p>
            <small class="text-muted fst-italic">Thị trấn Trâu Quỳ, Gia Lâm, Hà Nội | ĐT: 024.62617586</small>
        </div>

        <div class="form-section mb-3">
            <h5 class="fw-bold text-center">{{ $survey->title }}</h5>
            <p class="text-justify">{{ $survey->description }}</p>
            <div class="survey-time">
                Thời gian khảo sát: {{ \Carbon\Carbon::parse($survey->start_time)->format('d/m/Y') }}
                – {{ \Carbon\Carbon::parse($survey->end_time)->format('d/m/Y') }}
            </div>
        </div>

        <form action="{{ route('admin.contact-survey.submit', ['id' => $survey->id]) }}" method="POST">
            @csrf
            <h6 class="fw-bold mb-3">1. Thông tin sinh viên</h6>
            <div class="mb-3"><label>Mã sinh viên *</label><input type="text" name="student_code" class="form-control"
                    required></div>
            <div class="mb-3"><label>Mã lớp *</label><input type="text" name="class_code" class="form-control"
                    required></div>

            <h6 class="fw-bold mb-3">2. Thông tin cá nhân</h6>
            <div class="mb-3"><label>Họ và tên *</label><input type="text" name="full_name" class="form-control"
                    required></div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Ngày sinh</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
            </div>
            <div class="mb-3"><label>Nơi sinh</label><input type="text" name="place_of_birth" class="form-control">
            </div>
            <div class="mb-3"><label>Địa chỉ *</label><input type="text" name="address" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3"><label>Điện thoại *</label><input type="text" name="phone"
                        class="form-control" required></div>
                <div class="col-md-6 mb-3"><label>Email *</label><input type="email" name="email" class="form-control"
                        required></div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3"><label>Facebook</label><input type="text" name="facebook"
                        class="form-control"></div>
                <div class="col-md-6 mb-3"><label>Instagram</label><input type="text" name="instagram"
                        class="form-control"></div>
            </div>

            <h6 class="fw-bold mb-3">3. Thông tin cơ quan công tác</h6>
            <div class="mb-3"><label>Tên công ty</label><input type="text" name="company_name" class="form-control">
            </div>
            <div class="mb-3"><label>Địa chỉ</label><input type="text" name="company_address" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3"><label>Điện thoại</label><input type="text" name="company_phone"
                        class="form-control"></div>
                <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="company_email"
                        class="form-control"></div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4">Gửi khảo sát</button>
            </div>
        </form>
    </div>

    <script>
        const students = @json($students);

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('verifyForm');
            const authForm = document.getElementById('auth-form');
            const surveyForm = document.getElementById('survey-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const input = {
                    student_code: formData.get('student_code')?.trim(),
                    email: formData.get('email')?.trim(),
                    phone: formData.get('phone')?.trim(),
                    cccd: formData.get('cccd')?.trim(),
                    date_of_birth: formData.get('date_of_birth')?.trim()
                };

                // Chỉ cần trùng 1 thông tin là được
                const isValid = students.some(st =>
                    (input.student_code && st.student_code === input.student_code) ||
                    (input.email && st.email === input.email) ||
                    (input.date_of_birth && st.date_of_birth === st.date_of_birth) ||
                    (input.phone && st.phone === input.phone) ||
                    (input.cccd && st.cccd === input.cccd)
                );

                if (!isValid) {
                    alert('Thông tin không khớp. Vui lòng nhập đúng ít nhất 1 thông tin.');
                    return;
                }

                authForm.style.display = 'none';
                surveyForm.style.display = 'block';
            });
        });
    </script>

@endsection
