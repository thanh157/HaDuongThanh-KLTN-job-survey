@extends('admin.layouts.master')
@section('title', 'Danh sách sinh viên tốt nghiệp')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Danh sách sinh viên - Đợt ID: {{ $graduation_id }}</h4>

    <a href="{{ route('admin.graduation-student.create', $graduation_id) }}" class="btn btn-success mb-3">+ Thêm sinh viên</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Lớp</th>
                <th>Ngành</th>
                <th>Email</th>
                <th>SĐT</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student['ma_sv'] }}</td>
                    <td>{{ $student['ho_ten'] }}</td>
                    <td>{{ $student['lop'] }}</td>
                    <td>{{ $student['nganh'] }}</td>
                    <td>{{ $student['email'] }}</td>
                    <td>{{ $student['sdt'] }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Chưa có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
