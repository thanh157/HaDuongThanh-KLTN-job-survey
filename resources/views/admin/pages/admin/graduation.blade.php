@extends('admin.layouts.master')

@section('title', 'Đợt tốt nghiệp')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-1">Tốt nghiệp - Đợt tốt nghiệp</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Đợt tốt nghiệp</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Danh sách đợt tốt nghiệp</li>
                </ol>
            </nav>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="#" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tạo mới
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-bordered">
                <thead class="table-light">
                    <tr class="text-nowrap text-center">
                        <!-- Đợt tốt nghiệp -->
                        <th>
                            <form method="GET" action="" class="position-relative d-inline-block">
                                <span>Đợt tốt nghiệp</span>
                                <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-dot')"></i>
                                <div id="filter-dot" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="dot_tot_nghiep" class="form-control" placeholder="vd: T12/2025">
                                    </div>
                                </div>
                            </form>
                        </th>

                        <!-- Năm tốt nghiệp -->
                        <th>
                            <form method="GET" action="" class="position-relative d-inline-block">
                                <span>Năm tốt nghiệp</span>
                                <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-nam')"></i>
                                <div id="filter-nam" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="nam_tot_nghiep" class="form-control" placeholder="vd: 2024">
                                    </div>
                                </div>
                            </form>
                        </th>

                        <!-- Tổng số sinh viên -->
                        <th>Tổng số sinh viên</th>

                        <!-- Ngày tạo -->
                        <th>
                            <form method="GET" action="" class="position-relative d-inline-block">
                                <span>Ngày tạo</span>
                                <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-ngay')"></i>
                                <div id="filter-ngay" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                                    <select class="form-select" name="sap_xep">
                                        <option value="moi_nhat">Gần nhất</option>
                                        <option value="cu_nhat">Xa nhất</option>
                                    </select>
                                </div>
                            </form>
                        </th>

                        <!-- Hành động -->
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu -->
                    @for ($i = 1; $i <= 10; $i++)
                        <tr class="text-center">
                            <td><a href="#">Đợt tốt nghiệp T{{ 12 - $i }}/{{ 2025 - $i }}</a></td>
                            <td>{{ 2025 - $i }}</td>
                            <td>{{ rand(4, 100) }}</td>
                            <td>{{ date('d/m/Y', strtotime("-$i months")) }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Popup style -->
<style>
    .filter-popup {
        top: 100%;
        left: 0;
        z-index: 999;
        display: none;
        min-width: 200px;
    }

    .filter-popup.show {
        display: block;
    }
</style>

<!-- Toggle Filter Script -->
<script>
    function toggleFilter(id) {
        document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('show'));
        document.getElementById(id).classList.toggle('show');
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.filter-popup') && !event.target.closest('.bi-funnel-fill')) {
            document.querySelectorAll('.filter-popup').forEach(el => el.classList.remove('show'));
        }
    });
</script>
@endsection
