@extends('admin.layouts.master')

@section('title', 'Chi tiết sinh viên - ' . ($student['full_name'] ?? 'Không rõ tên'))

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
            <div>
                <h4 class="fw-bold mb-1">Quản lý thông tin cựu sinh viên</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.student.index') }}">Thông tin chi tiết cựu sinh
                                viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $student['full_name'] ?? '—' }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.student.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <!-- Hàng 1: Avatar + Thông tin cơ bản -->
        <div class="row g-4 mb-3">
            <!-- Avatar -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-header bg-secondary text-white fw-bold">Ảnh đại diện</div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        @php
                            $avatar = $student['thumbnail'];
                            if (!$avatar) {
                                $avatar = match ($student['gender']) {
                                    'male' => asset('assets/admin/images/male.jpg'),
                                    'female' => asset('assets/admin/images/female.jpg'),
                                    default => asset('assets/admin/images/student.jpg'),
                                };
                            }
                        @endphp
                        <img src="{{ $avatar }}" class="rounded-circle border mb-3"
                            style="width: 120px; height: 120px; object-fit: cover;" alt="Avatar">
                        <h5 class="fw-bold mb-0">{{ $student['full_name'] ?? '—' }}</h5>
                        <small class="text-muted">
                            Mã sinh viên: {{ $student['code'] ?? '—' }}<br>
                            Khóa: {{ $student['code'] ? substr($student['code'], 0, 2) : '—' }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Thông tin cơ bản -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-indigo text-white fw-bold">Thông tin cơ bản</div>
                    <div class="card-body">
                        <p><strong>Họ tên:</strong> {{ $student['full_name'] ?? '—' }}</p>
                        <p><strong>Giới tính:</strong> {{ $student['gender'] === 'male' ? 'Nam' : 'Nữ' }}</p>
                        <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($student['dob'])->format('d/m/Y') }}</p>
                        <p><strong>Tuổi:</strong>
                            {{ \Carbon\Carbon::now()->year - \Carbon\Carbon::parse($student['dob'])->year }}</p>
                        <p><strong>Trạng thái:</strong>
                            @php
                                $status = $student['status'];
                                $statusMap = [
                                    'currently_studying' => ['label' => 'Đang học', 'class' => 'bg-primary'],
                                    'graduated' => ['label' => 'Đã tốt nghiệp', 'class' => 'bg-danger'],
                                ];
                                $statusDisplay = $statusMap[$status] ?? [
                                    'label' => ucfirst($status),
                                    'class' => 'bg-secondary',
                                ];
                            @endphp
                            <span class="badge {{ $statusDisplay['class'] }} text-white px-3 py-1 rounded-pill">
                                {{ $statusDisplay['label'] }}
                            </span>
                        </p>
                        <p><strong>Năm học:</strong> {{ $student['school_year_start'] }} -
                            {{ $student['school_year_end'] }}</p>
                        <p><strong>Đối tượng chính sách:</strong> {{ $student['social_policy_object'] ?? '—' }}</p>
                        <p><strong>Hình thức đào tạo:</strong>
                            @if ($student['training_type'] === 'formal_university')
                                Chính quy
                            @else
                                {{ $student['training_type'] ?? '—' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hàng 2: Liên hệ + Thông tin tốt nghiệp -->
        <div class="row g-4">
            <!-- Liên hệ & cá nhân -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white fw-bold">Liên hệ & cá nhân</div>
                    <div class="card-body">
                        <p><strong>Email cá nhân:</strong> {{ $student['email'] ?? '—' }}</p>
                        <p><strong>Email trường:</strong> {{ $student['email_edu'] ?? '—' }}</p>
                        <p><strong>Điện thoại:</strong> 0{{ ltrim($student['phone'], '0') ?? '—' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $student['address'] ?? '—' }}</p>
                        <p><strong>Hộ khẩu thường trú:</strong> {{ $student['permanent_residence'] ?? '—' }}</p>
                        <p><strong>Quê quán:</strong> {{ $student['countryside'] ?? '—' }}</p>
                        <p><strong>Nơi sinh:</strong> {{ $student['pob'] ?? '—' }}</p>
                        <p><strong>Dân tộc:</strong> {{ $student['ethnic'] ?? '—' }}</p>
                        <p><strong>Tôn giáo:</strong> {{ $student['religion'] ?? '—' }}</p>
                        <p><strong>Quốc tịch:</strong> {{ $student['nationality'] ?? '—' }}</p>
                        <p><strong>Số CCCD:</strong> {{ $student['citizen_identification'] ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <!-- Thông tin tốt nghiệp -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white fw-bold">Thông tin tốt nghiệp</div>
                    <div class="card-body">
                        <p><strong>Đợt tốt nghiệp:</strong> {{ $student['graduation_name'] ?? '—' }}</p>
                        <p><strong>Năm tốt nghiệp:</strong> {{ $student['school_year'] ?? '—' }}</p>
                        <p><strong>Ra trường cách đây:</strong>
                            @if (!empty($student['school_year']) && is_numeric($student['school_year']))
                                {{ \Carbon\Carbon::now()->year - (int) $student['school_year'] }} năm
                            @else
                                —
                            @endif
                        </p>
                        <p><strong>Số quyết định:</strong> {{ $student['certification'] ?? '—' }}</p>
                        <p><strong>Ngày quyết định:</strong>
                            {{ isset($student['certification_date']) ? \Carbon\Carbon::parse($student['certification_date'])->format('d/m/Y') : '—' }}
                        </p>
                        <p><strong>Ngày tạo hồ sơ:</strong>
                            {{ \Carbon\Carbon::parse($student['created_at'])->format('d/m/Y') }}</p>
                        <p><strong>Ngày cập nhật:</strong>
                            {{ \Carbon\Carbon::parse($student['updated_at'])->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
