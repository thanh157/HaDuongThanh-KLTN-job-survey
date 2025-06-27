<?php

namespace App\Http\Controllers\System;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    public function index()
    {
        $path = base_path('app/JSON/ClassList.json');
        $classes = [];

        if (File::exists($path)) {
            $json = File::get($path);
            $classes = json_decode($json, true);
        }

        return view('admin.pages.admin.class', compact('classes'));
    }

    public function detail($id)
    {
        $path = base_path('app/JSON/ClassList.json');
        $classes = [];

        if (File::exists($path)) {
            $json = File::get($path);
            $classes = json_decode($json, true);
        }

        // Tìm lớp theo ID
        $class = collect($classes)->firstWhere('id', $id);

        if (!$class) {
            abort(404, 'Không tìm thấy lớp học');
        }

        return view('admin.pages.admin.class-detail', compact('class'));
    }
}
