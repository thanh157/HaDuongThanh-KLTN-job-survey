@extends('admin.layouts.master')
@section('title', 'Thống kê việc làm')

@section('content')
    <div class="container">
        <h4 class="my-3">Thống kê khảo sát</h4>

        <div class="form-group">
            <label>Đợt khảo sát *</label>
            <select class="form-select" id="survey_period">
                <option>PHIẾU KHẢO SÁT TÌNH HÌNH VIỆC LÀM CỦA SINH VIÊN TỐT NGHIỆP NĂM 2021</option>
                <option>PHIẾU KHẢO SÁT TÌNH HÌNH VIỆC LÀM CỦA SINH VIÊN TỐT NGHIỆP NĂM 2022</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Chọn biểu đồ</label>
            <select id="chartType" class="form-select">
                <option value="employed">Tình trạng việc làm</option>
                <option value="location">Khu vực làm việc</option>
                <option value="field">Liên quan ngành đào tạo</option>
                <option value="income">Mức lương</option> <!-- ✅ Thêm mục này -->
            </select>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <canvas id="pieChart" width="400" height="300"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="barChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script> <!-- ✅ Đường dẫn JS bạn đã viết -->
@endpush
