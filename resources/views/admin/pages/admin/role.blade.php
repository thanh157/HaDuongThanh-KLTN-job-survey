@extends('admin.layouts.master')

@section('title', 'Vai trò')

@section('content')
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold mb-1">Quản lí chung - Vai trò</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.department.index') }}">Vai trò</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách Vai trò</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Hiển thị thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Hiển thị thông báo lỗi -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div>
            <a href="{{ route('admin.role.create') }}" type="button" class="px-2 shadow btn btn-primary btn-icon fw-semibold">
                <i class="px-1 ph-plus-circle fw-semibold"></i><span>Thêm mới</span>
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle table-bordered mb-0">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th>STT</th>
                            <th>Tên Vai trò</th>
                            <th>Mô tả</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $role->name ?? '---' }}</td>
                                <td>{{ $role->description ?? '---' }}</td>
                                <td>{{ \Carbon\Carbon::parse($role['created_at'])->format('H:i d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.role.edit', $role->id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.role.destroy', $role->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            @if($roles->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Hiển thị {{ $roles->firstItem() }} đến {{ $roles->lastItem() }}
                            trong tổng số {{ $roles->total() }} kết quả
                        </div>
                        {{ $roles->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .filter-popup {
            top: 100%;
            left: 0;
            z-index: 10;
            min-width: 250px;
            display: none;
        }

        .filter-popup.show {
            display: block;
        }

        .breadcrumb {
            font-size: 13px;
        }
    </style>

    <script>
        function toggleFilter(id) {
            document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            const popup = document.getElementById(id);
            if (popup) popup.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.filter-popup') && !event.target.classList.contains('bi-funnel-fill')) {
                document.querySelectorAll('.filter-popup').forEach(p => p.classList.remove('show'));
            }
        });
    </script>
@endsection
