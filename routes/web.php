<?php


use App\Http\Controllers\AuthController;

use App\Http\Controllers\KhaoSatController;
use App\Http\Controllers\System\SurveyController;
use App\Http\Controllers\System\SurveyResultController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;

// // web.php
// Route::get('/login/microsoft', [AuthController::class, 'redirectToProvider'])->name('sso.redirect');
// Route::get('/login/microsoft/callback', [AuthController::class, 'handleProviderCallback']);

// Route::get('/login', function () {
//     return view('admin.pages.admin.login');
// })->name('admin.login');

use App\Http\Controllers\System\DepartmentController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\System\GraduationController;
use App\Http\Controllers\System\ClassController;
use App\Http\Controllers\GraduationStudentController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\Admin\FormSurveyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\ChartStatisticController;

// Route::get('/login/sso', [AuthController::class, 'redirectToSSO'])->name('sso.redirect');
// Route::get('/login/sso/callback', [AuthController::class, 'handleSSOCallback'])->name('sso.callback');

// Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::post('/logout', [AuthenticateController::class, 'logout'])->name('handleLogout');
Route::get('/auth/redirect', [AuthenticateController::class, 'redirectToSSO'])->name('sso.redirect');
Route::get('/auth/callback', [AuthenticateController::class, 'handleCallback'])->name('sso.callback');


Route::middleware('auth.sso')->group(function (): void {
    Route::get('/', function () {
        return view('welcome');
    })->name('client.home');

    Route::get('/dashboard', function () {
        return view('admin.pages.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/department', [DepartmentController::class, 'index'])->name('admin.department.index')->middleware('permission:department.index');
    // Route::get('/graduation', [GraduationController::class, 'index'])->name('admin.graduation.index');
    // Route::get('/graduation', [GraduationController::class, 'index'])->name('admin.graduation.index');
    Route::get('/graduation/create', [GraduationController::class, 'create'])->name('admin.graduation.create');
    Route::post('/graduation', [GraduationController::class, 'store'])->name('admin.graduation.store');
    Route::get('/graduation/{id}/edit', [GraduationController::class, 'edit'])->name('admin.graduation.edit');
    Route::put('/graduation/{id}', [GraduationController::class, 'update'])->name('admin.graduation.update');
    Route::delete('/graduation/{id}', [GraduationController::class, 'destroy'])->name('admin.graduation.destroy');
    Route::get('/graduation/{graduationId}/students/create', [GraduationStudentController::class, 'create'])->name('admin.graduation-student.create');
    // Xử lý lưu
    Route::post('/graduation/{graduationId}/students', [GraduationStudentController::class, 'store'])->name('admin.graduation-student.store');

    // Route::prefix('admin/survey')->name('admin.survey.')->group(function () {
    //     Route::get('/', [SurveyPeriodController::class, 'index'])->name('index');
    //     Route::get('/create', [SurveyPeriodController::class, 'create'])->name('admin.create-survey');
    //     Route::post('/store', [SurveyPeriodController::class, 'store'])->name('admin.store-survey');
    //     Route::get('/{id}/edit', [SurveyPeriodController::class, 'edit'])->name('admin.form-edit-survey');
    //     Route::put('/{id}', [SurveyPeriodController::class, 'update'])->name('admin.update-survey');
    //     Route::delete('/{id}', [SurveyPeriodController::class, 'destroy'])->name('admin.destroy-survey');
    // });

    // Route::get('/department', function () {
    //     return view('admin.pages.admin.department');
    // })->name('admin.department.index');

    Route::get('/create-department', function () {
        return view('admin.pages.admin.create-department');
    })->name('admin.department.create-department');

    // Route::get('/major', [MajorController::class, 'index'])->name('admin.major.index');
    Route::get('/admin/majors', [MajorController::class, 'index'])->name('admin.major.index');
    // Route::prefix('admin/class')->group(function () {
    //     Route::get('/', [ClassController::class, 'index'])->name('admin.class.index');
    //     Route::get('/{id}/detail', [ClassController::class, 'detail'])->name('admin.class.class-detail');
    // });
    // web.php
    Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
        Route::get('/classes', [ClassController::class, 'index'])->name('class.index');
        Route::get('/classes/{id}', [ClassController::class, 'show'])->name('class.class-detail');
        Route::get('/admin/class/{code}/students', [ClassController::class, 'students'])->name('admin.class.students');

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


    // Route::get('/report', [ReportController::class, 'index'])->name('admin.report');

    // Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('admin.report.index');
    // Route::get('/charts', [ChartStatisticController::class, 'index'])->name('admin.charts.index');
    Route::get('/charts', [ChartStatisticController::class, 'index'])->name('admin.charts.index');
    Route::get('/charts/data', [ChartStatisticController::class, 'getChartData;'])->name('admin.charts.data');

    // Route::prefix('admin/survey')->name('admin.survey.')->group(function () {
    //     Route::get('/', [SurveyPeriodController::class, 'index'])->name('index');
    //     Route::get('/create', [SurveyPeriodController::class, 'create'])->name('create-survey');
    //     Route::post('/store', [SurveyPeriodController::class, 'store'])->name('store');
    // });


    // Route::get('/major', function () {
    //     return view('admin.pages.admin.major');
    // })->name('admin.major.index');

    // Route::get('/create-major', function () {
    //     return view('admin.pages.admin.create-major');
    // })->name('admin.major.create-major');

    // Route::get('/class', function () {
    //     return view('admin.pages.admin.class');
    // })->name('admin.class.index');

    // Route::get('/edit-major', function () {
    //     return view('admin.pages.admin.edit-major');
    // })->name('admin.major.edit-major');

    // Route::get('/edit-department', function () {
    //     return view('admin.pages.admin.edit-department');
    // })->name('admin.department.edit-department');


    // Route::get('/edit-class', function () {
    //     return view('admin.pages.admin.edit-class');
    // })->name('admin.class.edit-class');


    // Route::get('/create-class', function () {
    //     return view('admin.pages.admin.create-class');
    // })->name('admin.class.create-class');

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
            Route::get('/{id}/form', [SurveyController::class, 'showForm'])->name('form');
            Route::get('/khao-sat/{id}/ket-qua', [SurveyResultController::class, 'index'])->name('result');

        });
    });


    // Route::get('/class-detail;', function () {
    //     return view('admin.pages.admin.class-detail');
    // })->name('admin.class.class-detail');

    Route::get('/form-survey', function () {
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

    // Route::get('/graduation;', function () {
    //     return view('admin.pages.admin.graduation');
    // })->name('admin.graduation.index');

    Route::get('/infor-account;', function () {
        return view('admin.pages.admin.infor-account');
    })->name('admin.infor-account.index');

    Route::get('/edit-profile;', function () {
        return view('admin.pages.admin.edit-profile');
    })->name('admin.infor-account.edit-profile');

    Route::get('/change-password;', function () {
        return view('admin.pages.admin.change-password');
    })->name('admin.infor-account.change-password');



    // Route::get('/report', function () {
    //     return view('admin.pages.admin.report');
    // })->name('admin.report.index');
    Route::get('/report', function () {
        return view('admin.pages.admin.report');
    })->name('admin.report.index');

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.role.index')->middleware('permission:role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create')->middleware('permission:role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store')->middleware('permission:role.create');
        Route::get('/{role}', [RoleController::class, 'show'])->name('admin.role.show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('admin.role.edit')->middleware('permission:role.edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('admin.role.update')->middleware('permission:role.edit');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy')->middleware('permission:role.delete');
    });
});

Route::get('khao_sat/{id}/form', [KhaoSatController::class, 'showForm'])->name('my_form');


// API
Route::post('/api/khao-sat/verify-student', [KhaoSatController::class, 'verify'])->name('verify');

Route::post('/khao-sat/submit', [KhaoSatController::class, 'submit'])->name('survey.submit');

Route::get('/khao-sat/hoan-thanh', function () {
    return view('admin.pages.survey.thankyou');
})->name('survey.thankyou');
