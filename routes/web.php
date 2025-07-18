<?php

use App\Http\Controllers\KhaoSatController;
use App\Http\Controllers\System\SurveyController;
use App\Http\Controllers\System\SurveyResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\System\StudentController;

use App\Http\Controllers\System\DepartmentController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\System\GraduationController;
use App\Http\Controllers\System\ClassController;
//use App\Http\Controllers\GraduationStudentController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\ChartStatisticController;
use App\Http\Controllers\System\StudentDetailController;
use App\Http\Controllers\ContactSurveyController;

Route::post('/logout', [AuthenticateController::class, 'logout'])->name('handleLogout');
Route::get('/auth/redirect', [AuthenticateController::class, 'redirectToSSO'])->name('sso.redirect');
Route::get('/auth/callback', [AuthenticateController::class, 'handleCallback'])->name('sso.callback');


Route::middleware('auth.sso')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('client.home');

    Route::get('/dashboard', function () {
        return view('admin.pages.admin.dashboard');
    })->name('admin.dashboard');

    //    Route::get('/department', [DepartmentController::class, 'index'])->name('admin.department.index')->middleware('permission:department.index');
    // Route::get('/graduation', [GraduationController::class, 'index'])->name('admin.graduation.index');
    // Route::get('/graduation', [GraduationController::class, 'index'])->name('admin.graduation.index');
    //    Route::get('/graduation/create', [GraduationController::class, 'create'])->name('admin.graduation.create');
    //    Route::post('/graduation', [GraduationController::class, 'store'])->name('admin.graduation.store');
    //    Route::get('/graduation/{id}/edit', [GraduationController::class, 'edit'])->name('admin.graduation.edit');
    //    Route::put('/graduation/{id}', [GraduationController::class, 'update'])->name('admin.graduation.update');
    //    Route::delete('/graduation/{id}', [GraduationController::class, 'destroy'])->name('admin.graduation.destroy');
    //    Route::get('/graduation/{graduationId}/students/create', [GraduationStudentController::class, 'create'])->name('admin.graduation-student.create');
    // Xử lý lưu
    //    Route::post('/graduation/{graduationId}/students', [GraduationStudentController::class, 'store'])->name('admin.graduation-student.store');

    Route::get('/create-department', function () {
        return view('admin.pages.admin.create-department');
    })->name('admin.department.create-department');

    // Route::get('/major', [MajorController::class, 'index'])->name('admin.major.index');
    Route::get('/admin/majors', [MajorController::class, 'index'])->name('admin.major.index');
    Route::get('/admin/department', [DepartmentController::class, 'index'])->name('admin.department.index');
    // Route::prefix('admin/class')->group(function () {
    //     Route::get('/', [ClassController::class, 'index'])->name('admin.class.index');
    //     Route::get('/{id}/detail', [ClassController::class, 'detail'])->name('admin.class.class-detail');
    // });
    // web.php
    Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
        Route::get('/classes', [ClassController::class, 'index'])->name('class.index');
        Route::get('/classes/{id}', [ClassController::class, 'show'])->name('class.class-detail');
        // Route::get('/admin/class/{code}/students', [ClassController::class, 'students'])->name('admin.class.students');
        Route::get('/class/student/{id}', [ClassController::class, 'showStudentDetail'])->name('class.student-detail');
        Route::get('/admin/class/{khoa}/list', [ClassController::class, 'showClassByKhoa'])->name('admin.class.by-khoa');
    });
    Route::get('/class/khoa/{khoa}', [ClassController::class, 'showByKhoa'])
        ->name('admin.class.by-khoa');
    Route::get('/class/{code}/students', [ClassController::class, 'showStudents'])->name('admin.class.students');
    Route::get('/admin/class/khoa/{khoa}', [\App\Http\Controllers\System\ClassController::class, 'showByKhoa'])->name('admin.class-by-khoa');

    Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
        Route::get('/classes', [ClassController::class, 'index'])->name('class.index');
        Route::get('/classes/{id}', [ClassController::class, 'show'])->name('class.class-detail');
    });


    Route::get('/report', [ReportController::class, 'index'])->name('admin.report.index');
    Route::any('/charts', [ChartStatisticController::class, 'index'])->name('admin.charts.index');
    Route::get('/charts/data', [ChartStatisticController::class, 'getChartData;'])->name('admin.charts.data');

    Route::name('admin.')->group(function () {
        Route::get('graduation', [GraduationController::class, 'index'])->name('graduation.index');
        Route::get('graduation/{id}/students', [GraduationController::class, 'showStudents'])->name('graduation-student.show');

        Route::prefix('survey')->name('survey.')->group(function () {
            Route::get('/', [SurveyController::class, 'index'])->name('index');
            Route::get('create', [SurveyController::class, 'create'])->name('create');
            Route::post('store', [SurveyController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [SurveyController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [SurveyController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [SurveyController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/form', [SurveyController::class, 'showForm'])->name('form');
            Route::get('/khao-sat/{id}/ket-qua', [SurveyResultController::class, 'index'])->name('result');
            Route::get('/khao-sat/{id}/ket-qua-chi-tiet', [SurveyResultController::class, 'show'])->name('result_detail');
            Route::get('exportPdf/{resultId}', [SurveyResultController::class, 'exportPdf'])->name('export_pdf');
        });
    });
});

// Thu thập thông tin cựu sinh viên
Route::middleware('auth.sso')->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('contact-survey')->name('contact-survey.')->group(function () {
        Route::get('/', [ContactSurveyController::class, 'index'])->name('index');
        Route::get('/create', [ContactSurveyController::class, 'create'])->name('create');
        Route::post('/store', [ContactSurveyController::class, 'store'])->name('store');

        Route::get('/{id}/edit', [ContactSurveyController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ContactSurveyController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactSurveyController::class, 'destroy'])->name('destroy');

        // Xem kết quả
        Route::get('/{id}/results', [ContactSurveyController::class, 'viewResults'])->name('results');
        Route::get('/{id}/show_submit', [ContactSurveyController::class, 'showStudentSubmit'])->name('show_student_submit');

        // API lấy đợt tốt nghiệp theo năm
        Route::get('/graduation-ceremonies', [ContactSurveyController::class, 'getGraduationCeremonies'])
            ->name('get-graduation-ceremonies');

        Route::get('/api/student-info', [ContactSurveyController::class, 'getStudentInfo'])->name('api.student-info');
    });
});

// Route::middleware('auth.sso')->prefix('admin')->name('admin.')->group(function () {
//     Route::prefix('contact-survey')->name('contact-survey.')->group(function () {
//         Route::get('/', [ContactSurveyController::class, 'index'])->name('index');
//         Route::get('/create', [ContactSurveyController::class, 'create'])->name('create');
//         Route::post('/store', [ContactSurveyController::class, 'store'])->name('store');

//         Route::get('/{id}/edit', [ContactSurveyController::class, 'edit'])->name('edit');
//         Route::put('/{id}', [ContactSurveyController::class, 'update'])->name('update');
//         Route::delete('/{id}', [ContactSurveyController::class, 'destroy'])->name('destroy');

//         // Route form xử lý cả GET (hiện) và POST (xác thực)
//         Route::get('/{id}/form', [ContactSurveyController::class, 'showForm'])->name('form');
//         Route::post('/{id}/form', [ContactSurveyController::class, 'showForm']);

//         Route::get('/{id}/results', [ContactSurveyController::class, 'viewResults'])->name('results');
//         Route::post('/{id}/submit', [ContactSurveyController::class, 'submitForm'])->name('submit');

//         // Route API dùng cho dropdown ngành
//         Route::get('/graduation-ceremonies', [ContactSurveyController::class, 'getGraduationCeremonies'])
//             ->name('get-graduation-ceremonies');
//     });
// });

// Route::get('/student', function () {
//     return view('admin.pages.admin.student');
// })->name('admin.student.index');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('student.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/students/{id}/detail', [StudentDetailController::class, 'show'])->name('student-info');
});
Route::get('/students/{id}/detail', [StudentDetailController::class, 'show'])->name('student-info');


//Route::get('/student-info', function () {
//    return view('admin.pages.admin.student-info');
//})->name('admin.student-info.index');

Route::get('student-info', [StudentController::class, 'listStudent'])->name('admin.student-info.index');

Route::get('/admin/student-detail/{id}', [StudentController::class, 'show'])->name('admin.student.detail');


//Route::get('/alumni-show', function () {
//    return view('admin.pages.admin.alumni-show');
//})->name('admin.alumni-show');

Route::get('alumni-show/{studentId}/{surveyId}', [StudentController::class, 'hopNhat'])->name('admin.alumni-show');

// Route::get('/class-detail;', function () {
//     return view('admin.pages.admin.class-detail');
// })->name('admin.class.class-detail');

Route::get('/form-survey;', function () {
    return view('admin.pages.admin.form-survey');
})->name('admin.survey.form-survey');

Route::get('/form-edit-survey;', function () {
    return view('admin.pages.admin.form-edit-survey');
})->name('admin.survey.form-edit-survey');

Route::get('/form-survey-student;', function () {
    return view('admin.pages.admin.form-survey-student');
})->name('admin.survey.form-survey-student');

Route::get('/admin/graduation/{id}/students', [GraduationController::class, 'showStudents'])
    ->name('admin.graduation-student.index.show');

Route::get('/infor-account;', function () {
    return view('admin.pages.admin.infor-account');
})->name('admin.infor-account.index');

Route::get('/edit-profile;', function () {
    return view('admin.pages.admin.edit-profile');
})->name('admin.infor-account.edit-profile');

Route::get('/change-password;', function () {
    return view('admin.pages.admin.change-password');
})->name('admin.infor-account.change-password');

//    Route::get('/report', function () {
//        return view('admin.pages.admin.report');
//    })->name('admin.report.index');
Route::get('/report', [ReportController::class, 'index'])->name('admin.report.index');
// Route::get('/report', function () {
//     return view('admin.pages.admin.report');
// })->name('admin.report.index');

Route::prefix('role')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('admin.role.index')->middleware('permission:role.index');
    Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create')->middleware('permission:role.create');
    Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store')->middleware('permission:role.create');
    Route::get('/{role}', [RoleController::class, 'show'])->name('admin.role.show');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('admin.role.edit')->middleware('permission:role.edit');
    Route::put('/{id}', [RoleController::class, 'update'])->name('admin.role.update')->middleware('permission:role.edit');
    Route::delete('/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy')->middleware('permission:role.delete');
});

Route::get('khao_sat/{survey_id}/form', [KhaoSatController::class, 'showForm'])->name('my_form');
Route::post('send_mail/{survey_id}', [KhaoSatController::class, 'sendMail'])->name('send_mail');

// ========== API ==========
Route::post('/api/khao-sat/verify-student', [KhaoSatController::class, 'verify'])->name('verify');
Route::post('/api/khao-sat/verify-student-2', [KhaoSatController::class, 'verifyV2'])->name('verifyV2');

Route::post('/khao-sat/submit', [KhaoSatController::class, 'submit'])->name('survey.submit');

Route::get('/khao-sat/hoan-thanh', function () {
    return view('admin.pages.survey.thankyou');
})->name('survey.thankyou');


// ========== Hiển thị và xác thực form khảo sát cho cựu sv ==========
Route::prefix('contact-survey')->name('contact-survey.')->group(function () {
    Route::get('{id}/form', [ContactSurveyController::class, 'showForm'])->name('form');
    Route::post('{id}/form', [ContactSurveyController::class, 'handleVerify']);
    Route::post('{id}/submit', [ContactSurveyController::class, 'submitForm'])->name('submit');
    Route::get('thankyou', [ContactSurveyController::class, 'thankyou'])->name('thankyou');
});
// ========== Hiển thị và xác thực form khảo sát cho cựu sv ==========

Route::post('/api/get-dot-tot-nghiep', [SurveyController::class, 'getDotTotNghiep']);
// ========== END API ==========




Route::get('ket-qua/{id}', [SurveyResultController::class, 'show'])->name('result_detail_v2');
Route::any('exportPdf_v2/{resultId}', [SurveyResultController::class, 'exportPdf'])->name('export_pdf_v2');
