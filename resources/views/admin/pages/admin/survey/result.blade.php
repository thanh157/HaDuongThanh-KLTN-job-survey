@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Khảo sát - Khảo sát việc làm</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.survey.index') }}">Khảo sát việc làm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kết quả khảo sát</li>
                </ol>
            </nav>

            <div>
                - Nam khao sat: 2022 <br>
                - dot khao sat: dot 1, dot 2, dot 3 <br>
                - Khi click dot 1 sang chi tiet: http://127.0.0.1:8000/graduation/72/students <br>
                - thống kê: 1/100 <br>
            </div>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('admin.survey.create') }}" class="btn btn-primary mt-2 mt-sm-0">
                <i class="bi bi-plus-lg me-1"></i> Tạo mới
            </a>
        </div>
    </div>

    @include('admin.layouts.noti')
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-bordered">
                <thead>
                <tr>
                    <td><strong>STT</strong></td>
                    <td><strong>Mã sv</strong></td>
                    <td><strong>Email</strong></td>
                    <td><strong>Name</strong></td>
                    <td>Ngày phản hồi</td>
                    <td><strong>Hành động</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->code_student  }}</td>
                        <td>{{ $item->email  }}</td>
                        <td>{{ $item->full_name  }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : "" }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.survey.result_detail', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-primary" title="Chi tiết"
                               style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; margin-right: 4px">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#">Xuất pdf</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($data->count())
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
