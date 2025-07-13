@extends('admin.layouts.master')

@section('title', 'Danh sách sinh viên đã khảo sát')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Quản lý thông tin cựu sinh viên</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.student-info.index') }}">Thông tin cựu sinh
                                viên</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Thông tin sinh viên đã khảo sát</li>
                </nav>
            </div>

        </div>
        <!-- Tìm kiếm -->
        <form method="GET" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã SV hoặc họ tên"
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Tìm kiếm</button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã SV</th>
                            <th>Họ tên</th>
                            <th>Lớp</th>
                            <th>Ngành</th>
                            <th>Khóa</th>
                            <th>Trạng thái việc làm</th>
                            <th>Khảo sát</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $students = collect([
                                [
                                    'id' => 698519,
                                    'name' => 'Phạm Thị Huyền',
                                    'class' => 'CNTT01',
                                    'course' => 'K65',
                                    'status' => 'Đã có việc làm',
                                ],
                                [
                                    'id' => 698522,
                                    'name' => 'Nguyễn Văn Minh',
                                    'class' => 'CNTT01',
                                    'course' => 'K65',
                                    'status' => 'Chưa có việc làm',
                                ],
                                [
                                    'id' => 698523,
                                    'name' => 'Lê Thị Mai',
                                    'class' => 'CNTT02',
                                    'course' => 'K64',
                                    'status' => 'Tiếp tục học',
                                ],
                                [
                                    'id' => 698524,
                                    'name' => 'Đặng Văn Hùng',
                                    'class' => 'CNTT02',
                                    'course' => 'K63',
                                    'status' => 'Đã có việc làm',
                                ],
                                [
                                    'id' => 698525,
                                    'name' => 'Trần Thị Hoa',
                                    'class' => 'CNTT03',
                                    'course' => 'K65',
                                    'status' => 'Đã có việc làm',
                                ],
                            ]);

                            $keyword = request('keyword');
                            if ($keyword) {
                                $students = $students->filter(
                                    fn($s) => str_contains($s['id'], $keyword) ||
                                        str_contains(Str::lower($s['name']), Str::lower($keyword)),
                                );
                            }
                        @endphp

                        @forelse ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student['id'] }}</td>
                                <td>{{ $student['name'] }}</td>
                                <td>{{ $student['class'] }}</td>
                                <td>Công nghệ thông tin</td>
                                <td>{{ $student['course'] }}</td>
                                <td>{{ $student['status'] }}</td>
                                <td><span class="badge bg-success">Đã khảo sát</span></td>
                                <td>
                                    <a href="{{ route('admin.alumni-show', $student['id']) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">Không tìm thấy sinh viên phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
