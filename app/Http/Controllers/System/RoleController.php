<?php


namespace App\Http\Controllers\System; // chữ hoa đúng thư mục


use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\GroupPermission;
use Illuminate\Http\Request;
use App\Services\SsoService;


class RoleController extends Controller
{
    public function index(Request $request): View|Application|Factory|RedirectResponse
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $roles = Role::query()
            ->search($request->search)
            ->where('faculty_id', $facultyId)
            ->orderBy('created_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pages.admin.role', [
            'roles' => $roles
        ]);
    }

    public function create(): View|Application|Factory|RedirectResponse
    {

        return view('admin.pages.admin.create-role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Tên vai trò là bắt buộc',
            'name.max' => 'Tên vai trò không được vượt quá 255 ký tự',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự',
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'faculty_id' => app(SsoService::class)->getFacultyId(),
            ]);

            return redirect()->route('admin.role.edit', $role->id)->with('success', 'Tạo vai trò thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo vai trò: ' . $e->getMessage());
        }
    }

    public function edit(Role $role): View|Application|Factory|RedirectResponse
    {
        $role = Role::with('permissions')->findOrFail($role->id);
        $groupPermissions = GroupPermission::query()->with('permissions')->get();
        return view('admin.pages.admin.edit-role', [
            'role' => $role,
            'groupPermissions' => $groupPermissions
        ]);
    }

    public function update(Request $request, $role): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array'
        ], [
            'name.required' => 'Tên vai trò là bắt buộc',
            'name.max' => 'Tên vai trò không được vượt quá 255 ký tự',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự',
        ]);

        try {
            $role = Role::findOrFail($role);
            $role->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Thêm dữ liệu vào bảng chung gian giữa role và permission'
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admin.role.index')->with('success', 'Cập nhật vai trò thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật vai trò: ' . $e->getMessage());
        }
    }

    public function destroy($roleId): RedirectResponse
    {
        try {
            $role = Role::findOrFail($roleId);
            // Kiểm tra xem vai trò có đang được sử dụng không
            if ($role->users()->count() > 0) {
                return back()->with('error', 'Không thể xóa vai trò đang được sử dụng bởi người dùng!');
            }
            
            $role->delete();

            return redirect()->route('admin.role.index')->with('success', 'Xóa vai trò thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa vai trò: ' . $e->getMessage());
        }
    }
}
