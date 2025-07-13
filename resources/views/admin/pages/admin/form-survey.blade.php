@extends('admin.layouts.master')

@section('title', 'Chi tiết Form')

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
    </style>

    <div class="container py-4">
        <div class="google-form-style ">
            <!-- Header -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" width="90" class="mb-2">
                <h6 class="fw-bold mb-1 text-uppercase">Bộ Nông Nghiệp và Phát Triển Nông Thôn</h6>
                <p class="mb-1 text-uppercase fw-semibold">Học Viện Nông Nghiệp Việt Nam</p>
                <small class="text-muted fst-italic">Thị trấn Trâu Quỳ, huyện Gia Lâm, TP Hà Nội | ĐT: 024.62617586 – Fax:
                    024.62617586</small>
            </div>

            <!-- Title -->
            <div class="form-section">
                <h5 class="fw-bold text-center">PHIẾU KHẢO SÁT TỰ ĐÁNH GIÁ MỨC ĐỘ HÀI LÒNG VỀ VIỆC LÀM <br> CỦA SINH VIÊN
                    TỐT NGHIỆP NĂM 2023</h5>
                <p class="text-justify">
                    Nhằm đánh giá hiệu quả của chương trình đào tạo và làm căn cứ để nâng cao chất lượng giáo dục, Học viện
                    Nông nghiệp Việt Nam đang tiến hành khảo sát tình hình việc làm của sinh viên đã tốt nghiệp năm 2023,
                    cũng như mức độ phù hợp giữa công việc hiện tại và chuyên ngành đã học.
                </p>
                <p class="text-justify">
                    Chúng tôi rất mong nhận được sự hợp tác từ Anh/Chị trong việc cung cấp thông tin một cách trung thực và
                    đầy đủ. Tất cả các thông tin trong phiếu khảo sát sẽ được sử dụng chỉ cho mục đích nghiên cứu và đảm bảo
                    bảo mật tuyệt đối.
                </p>
                <p class="text-justify">
                    Sự đóng góp của Anh/Chị có ý nghĩa rất lớn trong việc nâng cao chất lượng đào tạo của Học viện.
                </p>
                <p class="text-end mt-2">
                    <small class="text-muted fst-italic">Thời gian khảo sát: 01/02/2025 – 23/12/2025</small>
                </p>
            </div>

            <!-- Form Start -->
            @include('admin.includes._form_survey')
        </div>
    </div>
@endsection
