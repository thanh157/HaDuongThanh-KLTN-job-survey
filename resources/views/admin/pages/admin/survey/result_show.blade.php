@extends('admin.layouts.master')

@section('title', 'Chi tiết khảo sát việc làm')

@php
    function getSurveyFieldLabels(?string $jsonValue, array $config): string
    {
        if (empty($jsonValue)) {
            return '';
        }

        $decoded = json_decode($jsonValue, true);

        if (!is_array($decoded) || !isset($decoded['value'])) {
            return '';
        }

        $values = $decoded['value'] ?? [];
        $other = trim($decoded['content_other'] ?? '');
        $labels = [];

        foreach ($values as $id) {
            $id = intval($id);
            if (isset($config[$id])) {
                $labels[] = $config[$id];
            }
        }

        if (!empty($other)) {
            $labels[] = 'Ghi chú: ' . $other;
        }

        return implode(', ', $labels);
    }
@endphp

@section('content')
    <div class="container py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="fw-bold text-primary m-0">
                <i class="bi bi-mortarboard-fill me-2"></i>Thông tin khảo sát việc làm cựu sinh viên
            </h3>
            <a href="{{ route('admin.student-info.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>

        <div>
            Khảo sát: {{ $survey->title }} <br>
        </div>
        <p class="text-muted">Thông tin chi tiết được thu thập trong quá trình khảo sát sinh viên tốt nghiệp.</p>
    </div>

    <div class="card shadow-sm p-4">
        {{-- PHẦN 1: Thông tin cá nhân --}}
        <h5 class="text-secondary fw-bold mb-3">
            <i class="bi bi-person-badge-fill me-2"></i>Thông tin cá nhân
        </h5>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Họ tên:</strong> {{ $response->full_name }}</div>
            <div class="col-md-4"><strong>Giới tính:</strong> {{ $response->gender == 'male' ? 'Nam' : 'Nữ' }}</div>
            <div class="col-md-4"><strong>Ngày sinh:</strong>
                {{ $response->dob ? date('d-m-Y', strtotime($response->dob)) : '' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Mã SV:</strong> {{ $response->code_student }}</div>
            <div class="col-md-4"><strong>CCCD:</strong> {{ $response->identification_card_number }}</div>
            <div class="col-md-4">
                <strong>Nơi cấp:</strong> {{ $response->identification_issuance_place }}
                ({{ \Carbon\Carbon::parse($response->identification_issuance_date)->format('d/m/Y') }})
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Khóa:</strong> {{ $response->course }}</div>
            <div class="col-md-4"><strong>Ngành:</strong>
                {{ !empty($major[$response->training_industry_id]) ? $major[$response->training_industry_id] : '' }}
            </div>
            <div class="col-md-4"><strong>Điện thoại:</strong> {{ $response->phone_number }}</div>
        </div>
        <div class="mb-4"><strong>Email:</strong> {{ $response->email }}</div>

        <hr>

        {{-- PHẦN 2: Việc làm hiện tại --}}
        <h5 class="text-secondary fw-bold mb-3">
            <i class="bi bi-briefcase-fill me-2"></i>Việc làm hiện tại
        </h5>

        <div class="row mb-3 align-items-start">
            <div class="col-md-2 text-center mb-3 mb-md-0">
                <img src="{{ asset('assets/admin/images/employee.png') }}" alt="Công ty ABC"
                    class="img-fluid rounded-circle border shadow-sm" style="width:80px;">
            </div>

            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Tên công ty:</strong> {{ $response->recruit_partner_name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Địa chỉ:</strong> {{ $response->recruit_partner_address }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Chức vụ:</strong> {{ $response->recruit_partner_position }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Khu vực:</strong>
                        {{ $response->work_area ? data_get(config('config.work_area'), $response->work_area) : '---' }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Thu nhập:</strong>
                        {{ $response->average_income ? data_get(config('config.average_income'), $response->average_income) : '---' }}
                        triệu VNĐ/tháng
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Thời gian có việc:</strong>
                        {{ $response->employed_since ? data_get(config('config.employed_since'), $response->employed_since) : '---' }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Phù hợp ngành đào tạo:</strong>
                        {{ $response->professional_qualification_field ? data_get(config('config.professional_qualification_field'), $response->professional_qualification_field) : '---' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Được nhà trường hỗ trợ:</strong>
                        {{ $response->school_support ?? '---' }}
                    </div>
                </div>
            </div>
        </div>



        <hr>

        {{-- PHẦN 3: Thông tin khảo sát --}}
        <h5 class="text-secondary fw-bold mb-3">
            <i class="bi bi-clipboard-check-fill me-2"></i>Thông tin khảo sát
        </h5>

        @php
            $recruitmentText = getSurveyFieldLabels($response->recruitment_type, config('config.recruitment_type'));
            $must_attended_courses = getSurveyFieldLabels(
                $response->must_attended_courses,
                config('config.must_attended_courses'),
            );
            $soft_skills_required = getSurveyFieldLabels(
                $response->soft_skills_required,
                config('config.soft_skills_required'),
            );
            $solutions_get_job = getSurveyFieldLabels($response->solutions_get_job, config('config.solutions_get_job'));
        @endphp

        <div class="mb-2"><strong>Cách tìm việc:</strong> {{ $recruitmentText }}</div>
        <div class="mb-2"><strong>Khóa học đã tham gia:</strong> {{ $must_attended_courses }}</div>
        <div class="mb-2"><strong>Áp dụng kiến thức:</strong> </div>
        <div class="mb-2"><strong>Áp dụng kỹ năng:</strong> </div>
        <div class="mb-2"><strong>Kỹ năng mềm cần có:</strong> {{ $soft_skills_required }}</div>
        <div class="mb-2"><strong>Giải pháp cải tiến đào tạo:</strong> {{ $solutions_get_job }}</div>
    </div>
    </div>
@endsection
