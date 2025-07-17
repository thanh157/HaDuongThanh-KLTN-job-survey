@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center  justify-content-between">
        <h3>Kết quả khảo sát: {{ $survey->title }}</h3>
        <button type="button" class="btn btn-xs btn-primary"><a style="color: white" href="{{ route('admin.contact-survey.index') }}">Back</a></button>
    </div>

    <p>Đã có <strong>{{ $count }}</strong> phản hồi</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Sinh viên</th>
                <th>DOB</th>
                <th>Phone, email</th>
                <th>Mạng xã hội cơ quan</th>
                <th>Thông tin cơ quan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div>Mã: {{ $result->student_code }}</div>
                        <div>Họ tên: {{ $result->full_name }}</div>
                        <div>Khóa: {{ $result->course }}</div>
                        <div>Giới tính: {{ $result->gender == 'male' ? 'Nam' : 'Nữ' }}</div>
                    </td>
                    <td>
                        <div>Ngày sinh: {{ date('d-m-Y', strtotime($result->date_of_birth)) }}</div>
                        <div>Nơi sinh: {{ $result->place_of_birth }}</div>
                        <div>Địa chỉ: {{ $result->address }}</div>
                    </td>
                    <td>
                        <div>Phone: {{ $result->phone }}</div>
                        <div>Email: {{ $result->email }}</div>
                    </td>
                    <td>
                        <div><a href="{{ $result->facebook }}">Facebook</a></div>
                        <div><a href="{{ $result->instagram }}">Instagram</a></div>
                    </td>
                    <td>
                        <div>Tên: {{ $result->company_name }}</div>
                        <div>Địa chỉ: {{ $result->company_address }}</div>
                        <div>Phone: {{ $result->company_phone }}</div>
                        <div>Email: {{ $result->company_email }}</div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Chưa có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
    {{-- Phân trang --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $results->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
