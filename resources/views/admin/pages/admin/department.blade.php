@extends('admin.layouts.master')

@section('content')

<div class="container py-4">

  <!-- Header -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
      <h4 class="fw-bold mb-1">Bộ môn - Danh sách</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">Bảng điều khiển</a></li>
          <li class="breadcrumb-item active" aria-current="page">Bộ môn</li>
        </ol>
      </nav>
    </div>
    <div class="mt-2 mt-sm-0">
        <a href="{{ route('admin.create-department') }}" class="btn btn-primary mt-2 mt-sm-0">
          <i class="bi bi-plus-lg me-1"></i> Tạo mới
        </a>
    </div>

  </div>

  <!-- Table -->
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light">
            <tr>
              <!-- Mã bộ môn -->
              <th>
                <form method="GET" action="" class="position-relative d-inline-block">
                  <span>Mã bộ môn</span>
                  <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-ma')"></i>
                  <div id="filter-ma" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-search"></i></span>
                      <input type="text" name="ma_bo_mon" class="form-control" placeholder="vd: BM001">
                    </div>
                    {{-- <div class="mt-2 text-end">
                      <button type="submit" class="btn btn-sm btn-outline-primary">OK</button>
                    </div> --}}
                  </div>
                </form>
              </th>

              <!-- Tên bộ môn -->
              <th>
                <form method="GET" action="" class="position-relative d-inline-block">
                  <span>Tên bộ môn</span>
                  <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-ten')"></i>
                  <div id="filter-ten" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-search"></i></span>
                      <input type="text" name="ten_bo_mon" class="form-control" placeholder="vd: Toán, Hóa...">
                    </div>
                    {{-- <div class="mt-2 text-end">
                      <button type="submit" class="btn btn-sm btn-outline-primary">OK</button>
                    </div> --}}
                  </div>
                </form>
              </th>

              <!-- Trạng thái -->
              <th>
                <form method="GET" action="" class="position-relative d-inline-block">
                  <span>Trạng thái</span>
                  <i class="bi bi-funnel-fill text-primary ms-1" style="cursor: pointer;" onclick="toggleFilter('filter-trangthai')"></i>
                  <div id="filter-trangthai" class="shadow rounded p-3 bg-white position-absolute filter-popup">
                    <select class="form-select" name="trang_thai">
                      <option value="">Tất cả</option>
                      <option value="hoat_dong">Hoạt động</option>
                      <option value="an">Ẩn</option>
                    </select>
                    {{-- <div class="mt-2 text-end">
                      <button type="submit" class="btn btn-sm btn-outline-primary">OK</button>
                    </div> --}}
                  </div>
                </form>
              </th>

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
                    {{-- <div class="mt-2 text-end">
                      <button type="submit" class="btn btn-sm btn-outline-primary">OK</button>
                    </div> --}}
                  </div>
                </form>
              </th>

              <!-- Hành động -->
              <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
          <tr>
            <td colspan="5" class="text-center py-5">
              <img src="{{asset('assets/admin/images/work.jpg')}}" alt="empty" class="img-fluid" style="max-width: 300px; height: auto;">
              <p class="text-muted mt-3 mb-0">Không có dữ liệu</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Script -->
{{-- <script>
  function toggleFilter(id) {
    // Ẩn popup khác
    document.querySelectorAll('.filter-popup').forEach(popup => {
      if (popup.id !== id) popup.style.display = 'none';
    });

    // Toggle popup hiện tại
    const el = document.getElementById(id);
    el.style.display = (el.style.display === 'block') ? 'none' : 'block';
  }

  // Ẩn khi click ra ngoài
  window.addEventListener('click', function (e) {
    document.querySelectorAll('.filter-popup').forEach(popup => {
      if (!popup.contains(e.target) && !popup.previousElementSibling.contains(e.target)) {
        popup.style.display = 'none';
      }
    });
  });
</script> --}}

@endsection 