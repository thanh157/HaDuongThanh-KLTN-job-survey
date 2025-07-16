@extends('admin.layouts.no-master')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f0f8ff;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem 2rem;
        }
    </style>

    <div class="container py-5">
        <div class="mx-auto" style="max-width: 600px">
            <div class="auth-card text-center">
                <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" alt="Logo" width="90" class="mb-3">
                <h4 class="fw-bold text-success">HỆ THỐNG THU THẬP THÔNG TIN CỰU SINH VIÊN</h4>
                <p class="text-muted">Vui lòng xác thực trước khi tham gia khảo sát</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verifyV2') }}" class="text-start mt-4">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                    <div class="mb-3">
                        <label class="form-label">Mã sinh viên</label>
                        <input type="text" name="m_mssv" class="form-control" value="{{ old('m_mssv') }}">
                    </div>

                    <div class="modal-body">
                        <label for="">Phone</label>
                        <input type="text" id="phone" name="m_phone" class="form-control" placeholder="Nhập phone" value="{{ old('m_phone') }}">
                        <div class="text-danger small d-none" id="phone-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email sinh viên</label>
                        <input type="email" name="m_email" class="form-control" value="{{ old('m_email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="m_dob" class="form-control" value="{{ old('m_dob') }}">
                    </div>

                    @php
                        $major = \App\Models\Major::query()->get();
                    @endphp
                    <div class="mb-3">
                        <label class="form-label">Ngành đào tạo</label>
                        <select name="training_industry" class="form-select select2" id="industry-select">
                            <option value="" readonly>--- Chọn ngành đào tạo ---</option>
                            @foreach ($major as $item)
                                <option value="{{ $item->id }}" {{ old('training_industry') == $item->id ? "selected" : "" }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-2">🔐 Xác thực</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
                    $('.select2').select2();

                    // Gọi API ngành đào tạo từ hệ thống ngoài
                    $.get('https://st-dse.vnua.edu.vn:6899/api/v1/external/training-industries/faculty/1')
                        .done(function(data) {
                            console.log(data); // Hiển thị cấu trúc để kiểm tra tên trường
                            data.forEach(function(item) {
                                // Nếu cấu trúc là {training_industry: "CNTT"}, dùng:
                                const text = item.name || item.training_industry || item.title;
                                $('#industry-select').append(new Option(text, text));
                            });
                        })
                        .fail(function(err) {
                            console.error('Lấy ngành thất bại:', err);
                            alert('Không lấy được ngành đào tạo, thử lại sau');
                        });
    </script>
@endpush
