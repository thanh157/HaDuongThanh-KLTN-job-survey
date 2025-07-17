@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
<div class="container mt-4">
    <h3>Kết quả khảo sát: {{ $survey->title }}</h3>
    <p>Đã có <strong>{{ $results->count() }}</strong> phản hồi</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Lớp</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Công ty</th>
                <th>Địa chỉ công ty</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->student_code }}</td>
                    <td>{{ $result->full_name }}</td>
                    <td>{{ $result->class_code }}</td>
                    <td>{{ $result->email }}</td>
                    <td>{{ $result->phone }}</td>
                    <td>{{ $result->company_name }}</td>
                    <td>{{ $result->company_address }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Chưa có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
