@extends('admin.layouts.master')

@section('title', 'Kết quả khảo sát')

@section('content')
    <div class="container my-4">
        {{-- Logo và tiêu đề --}}
        <div class="text-center mb-4">
            <img src="{{ asset('assets/client/images/logo-vnua.jpg') }}" alt="Logo học viện" style="height: 80px;">
            <h2 class="mt-3 fw-bold text-uppercase">Kết quả phiếu khảo sát thu thập thông tin cựu sinh viên</h2>
            <h5 class="text-muted mt-1">{{ $survey->title }}</h5>
        </div>

        {{-- Dòng chức năng: Thống kê, quay lại, tìm kiếm --}}
        <div class="row mb-3 align-items-center">
            {{-- Tổng số phản hồi --}}
            <div class="col-md-4 mb-2 mb-md-0">
                <p class="mb-0">
                    Tổng số phản hồi:
                    <strong class="text-success">{{ $count }}</strong> /
                    <strong>{{ $totalStudents }}</strong>
                </p>
            </div>

            {{-- Form tìm kiếm + nút quay lại --}}
            <div class="col-md-8 d-flex justify-content-md-end align-items-center gap-2 flex-wrap">
                {{-- Form tìm kiếm --}}
                <form action="" method="GET" class="d-flex flex-grow-1 flex-md-grow-0 w-100" style="max-width: 60%;">
                    <div class="input-group w-100">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Tìm theo mã sinh viên hoặc họ tên">
                        <button type="submit" class="btn btn-outline-primary"
                            style="white-space: nowrap; min-width: 110px;">
                            Tìm kiếm
                        </button>
                    </div>
                </form>

                {{-- Nếu đang tìm kiếm thì cho nút "Quay lại danh sách" --}}
                @if (request()->has('search'))
                    <a href="{{ route('admin.contact-survey.results', $survey->id) }}" class="btn btn-secondary btn-sm">
                        ← Quay lại danh sách
                    </a>
                @else
                    <a href="{{ route('admin.contact-survey.index') }}" class="btn btn-outline-primary btn-sm">
                        ← Quay lại ds khảo sát
                    </a>
                @endif
            </div>

        </div>


        {{-- Bảng dữ liệu --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã SV</th>
                        <th>Họ tên</th>
                        <th>Khóa</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Nơi sinh</th>
                        <th>Địa chỉ</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Facebook</th>
                        <th>Instagram</th>
                        <th>Cơ quan</th>
                        <th>Địa chỉ CQ</th>
                        <th>Phone CQ</th>
                        <th>Email CQ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $index => $result)
                        <tr>
                            <td class="text-center">
                                {{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}</td>
                            <td>{{ $result->student_code }}</td>
                            <td>{{ $result->full_name }}</td>
                            <td>{{ $result->course }}</td>
                            <td>{{ $result->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
                            <td>{{ date('d-m-Y', strtotime($result->date_of_birth)) }}</td>
                            <td>{{ $result->place_of_birth }}</td>
                            <td>{{ $result->address }}</td>
                            <td>{{ $result->phone }}</td>
                            <td>{{ $result->email }}</td>
                            <td><a href="{{ $result->facebook }}" target="_blank">Facebook</a></td>
                            <td><a href="{{ $result->instagram }}" target="_blank">Instagram</a></td>
                            <td>{{ $result->company_name }}</td>
                            <td>{{ $result->company_address }}</td>
                            <td>{{ $result->company_phone }}</td>
                            <td>{{ $result->company_email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="text-center">Chưa có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $results->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
