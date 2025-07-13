<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

class StudentDetailController extends Controller
{
    public function show($id)
    {
        $student = [
            'id' => $id,
            'full_name' => 'Nguyễn Văn A',
            'gender' => 'Nam',
            'birthday' => '2002-05-20',
            'student_code' => '698519',
            'identity_card' => '123456789',
            'identity_date' => '2019-09-01',
            'identity_place' => 'Hà Nội',
            'course' => 'K65',
            'training_industry' => 'Công nghệ thông tin',
            'phone' => '0912345678',
            'email' => '698519@sv.vnua.edu.vn',
            'employment_status' => 'Đã có việc làm',
            'workplace' => 'Công ty ABC',
            'work_address' => '123 Đường A, Quận B',
            'work_city' => 'Hà Nội',
            'position' => 'Lập trình viên',
            'work_area' => 'Khu vực tư nhân',
            'time_to_get_job' => 'Dưới 3 tháng',
            'job_relevance' => 'Đúng ngành đào tạo',
            'school_support' => 'Đã học được',
            'salary' => 'Từ 5 triệu đến 10 triệu',
            'job_search_methods' => ['Tự tìm việc làm', 'Bạn bè giới thiệu'],
            'knowledge_application' => [
                'knowledge' => 'Áp dụng tương đối nhiều',
                'skills' => 'Áp dụng ít',
            ],
            'soft_skills' => ['Kỹ năng giao tiếp', 'Kỹ năng làm việc nhóm', 'Kỹ năng tiếng Anh'],
            'training_courses' => ['Nâng cao kỹ năng chuyên môn nghiệp vụ', 'Phát triển kỹ năng quản lý'],
            'solutions' => [
                'Tăng cường thực hành',
                'Cập nhật chương trình đào tạo theo thị trường',
            ],
        ];

        dd(1); 

        // ✅ Truyền đúng biến
        return view('admin.pages.admin.student-info', compact('student'));
    }
}

