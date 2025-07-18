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
                {{ $response->date_of_birth ? date('d-m-Y', strtotime($response->date_of_birth)) : '' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Mã SV:</strong> {{ $student->code }}</div>
            <div class="col-md-4"><strong>Nơi sinh:</strong> {{ $response->place_of_birth }}</div>
            <div class="col-md-4">
                <strong>Địa chỉ:</strong> {{ $response->address }}
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Khóa:</strong> {{ $response->course }}</div>
            <div class="col-md-4"><strong>Điện thoại:</strong> {{ $response->phone }}</div>
            <div class="col-md-4"><strong>Email:</strong> {{ $response->email }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><strong>Facebook:</strong> {{ $response->facebook }}</div>
            <div class="col-md-4"><strong>Instagram:</strong> {{ $response->instagram }}</div>
        </div>
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
                        <strong>Tên công ty:</strong> {{ $response->company_name }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Địa chỉ:</strong> {{ $response->company_address }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Chức vụ:</strong> {{ $response->company_phone }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Chức vụ:</strong> {{ $response->company_email }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
