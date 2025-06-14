@extends('admin.layouts.master')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Lớp học - Danh sách</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lớp học</li>
                </ol>
            </nav> 
        </div>
        <div class="mt-2 mt-sm-0 d-flex gap-2">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload me-1"></i> Nhập từ file
            </a>
            <a href="{{ route('admin.class.create-class') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tạo mới
            </a>
        </div>
    </div>

    <!-- Filter + Search -->
    <form method="GET" class="mb-3 row gx-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo khóa...">
        </div>
        <div class="col-md-3">
            <select name="year" class="form-select">
                <option value="">Tất cả các năm</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Tìm</button>
        </div>
    </form>

    <!-- Danh sách các khóa học -->
    <div class="row gy-4">

        <!-- Card: Khóa 69 -->
        <div class="col-md-6">
            <div class="card shadow-sm border-start border-4 border-primary h-100 class-card" 
                 data-href="{{ route('admin.class.class-detail', ['id' => 2]) }}"
                 style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">Khóa 69</h5>
                            <p class="text-muted mb-2">Năm: 2024</p>
                            <ul class="list-unstyled small mb-0">
                                <li>Tổng số lớp: <strong>7</strong></li>
                                <li>Nhập học: <strong>549 SV</strong></li>
                                <li>Hiện tại: <strong>537 SV</strong></li>
                            </ul>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ route('admin.class.edit-class', ['id' => 2]) }}" class="btn btn-sm btn-outline-primary" title="Sửa" onclick="event.stopPropagation()">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" title="Xóa" onclick="event.stopPropagation()">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Khóa 68 -->
        <div class="col-md-6">
            <div class="card shadow-sm border-start border-4 border-success h-100 class-card" 
                 data-href="{{ route('admin.class.class-detail', ['id' => 1]) }}"
                 style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">Khóa 68</h5>
                            <p class="text-muted mb-2">Năm: 2023</p>
                            <ul class="list-unstyled small mb-0">
                                <li>Tổng số lớp: <strong>8</strong></li>
                                <li>Nhập học: <strong>722 SV</strong></li>
                                <li>Hiện tại: <strong>668 SV</strong></li>
                            </ul>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ route('admin.class.edit-class', ['id' => 1]) }}" class="btn btn-sm btn-outline-primary" title="Sửa" onclick="event.stopPropagation()">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" title="Xóa" onclick="event.stopPropagation()">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal import file -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Nhập danh sách lớp học từ file</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn file Excel (.xlsx)</label>
                        <input type="file" class="form-control" id="file" accept=".xlsx,.csv">
                        <div class="form-text">Chỉ chấp nhận định dạng .xlsx hoặc .csv</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">
                        <i class="bi bi-cloud-arrow-up"></i> Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.class-card').forEach(function(card) {
            card.addEventListener('click', function () {
                const href = this.dataset.href;
                if (href) window.location.href = href;
            });
        });
    });
</script>

