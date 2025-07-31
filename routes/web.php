<?php

use App\Http\Controllers\SignInController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassGroupController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleAuthorizationMiddleware;
use Illuminate\Support\Facades\Route;

// logging in and registering
Route::get('/', [SignInController::class, "loginPage"]);
Route::get('/login', [SignInController::class, "loginPage"]);
Route::get('/register', [SignInController::class, "registerPage"]);
Route::post('/login', [SignInController::class, "login"]);
Route::post('/register', [SignInController::class, "register"]);
Route::get('/logout', [SignInController::class, "logout"]);

// student CRUD
Route::post('/student/Create', [StudentController::class, "create"])->name('student.create');
Route::put('/student/Edit/{id}', [StudentController::class, "update"])->name('student.edit');
Route::delete('/student/Delete/{id}', [StudentController::class, "delete"])->name('student.delete');

// student group
Route::middleware(RoleAuthorizationMiddleware::class.":student")->prefix('student')->group(function () {
    Route::get('/home', [StudentController::class, 'home'])->name('student.home');
    Route::get('/info', [StudentController::class, "info"])->name('student.info');

    Route::get('/subjects', [StudentController::class, "subjects"])->name('student.subjects');
    Route::get('/subjects/{id}', [StudentController::class, "subject"])->name('student.subject');

    Route::get('/tests', [StudentController::class, "tests"])->name('student.tests');
    Route::get('/tests/{id}', [StudentController::class, "test"])->name('student.test');

    Route::get('/timetable', [StudentController::class, "timetable"])->name('student.timetable');
});

// teacher CRUD
Route::post('/teacher/Create', [TeacherController::class, "create"])->name('teacher.create');
Route::put('/teacher/Edit/{id}', [TeacherController::class, "update"])->name('teacher.edit');
Route::delete('/teacher/Delete/{id}', [TeacherController::class, "delete"])->name('teacher.delete');

// teacher group
Route::middleware(RoleAuthorizationMiddleware::class.":teacher")->prefix('teacher')->group(function () {
    Route::get('/home', [TeacherController::class, 'home'])->name('teacher.home');
});

// admin group
Route::middleware(RoleAuthorizationMiddleware::class.":admin")->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');

    // admin CRUD
    Route::post('/Create', [AdminController::class, "create"])->name('admin.create');
    Route::put('/Edit/{id}', [AdminController::class, "update"])->name('admin.edit');
    Route::delete('/Delete/{id}', [AdminController::class, "delete"])->name('admin.delete');

    // subject CRUD views
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('admin.subjects');
    Route::get('/subjects/create', [AdminController::class, 'createSubject'])->name('admin.subject.create');
    Route::get('/subjects/edit/{id}', [AdminController::class, 'subjectDetails'])->name('admin.subject.edit');
    
    // classgroups CRUD views
    Route::get('/classgroups', [AdminController::class, "classGroups"])->name('admin.classgroups');
    Route::get('/classgroups/create', [AdminController::class, "createClassGroup"])->name('admin.classgroup.create');
    Route::get('/classgroups/edit/{id}', [AdminController::class, "classGroupDetails"])->name('admin.classgroup.edit');

    // classrooms CRUD views
    Route::get('/classrooms', [AdminController::class, "classrooms"])->name('admin.classrooms');
    Route::get('/classrooms/create', [AdminController::class, "createClassroom"])->name('admin.classroom.create');
    Route::get('/classrooms/edit/{id}', [AdminController::class, "classroomDetails"])->name('admin.classroom.edit');

    // users CRUD views
    Route::get('/users', [AdminController::class, 'users'])->name('users');

    Route::get('/admins', [AdminController::class, "admins"])->name('admin.admins');
    Route::get('/admins/create', [AdminController::class, "createAdmin"])->name('admin.admins.create');
    Route::get('/admins/edit/{id}', [AdminController::class, "adminDetails"])->name('admin.admin');

    Route::get('/students', [AdminController::class, "students"])->name('admin.students');
    Route::get('/students/create', [AdminController::class, "createStudent"])->name('admin.student.create');
    Route::get('/students/edit/{id}', [AdminController::class, "studentDetails"])->name('admin.student');

    Route::get('/teachers', [AdminController::class, "teachers"])->name('admin.teachers');
    Route::get('/teachers/create', [AdminController::class, "createTeacher"])->name('admin.teacher.create');
    Route::get('/teachers/edit/{id}', [AdminController::class, "teacherDetails"])->name('admin.teacher');

});

// subject CRUD
Route::post('/subject/Create', [SubjectController::class, "create"])->name('subject.create');
Route::put('/subject/Edit/{id}', [SubjectController::class, "update"])->name('subject.edit');
Route::delete('/subject/Delete/{id}', [SubjectController::class, "delete"])->name('subject.delete');
Route::get('/subject/{id}', [SubjectController::class, "getById"])->name('subject.info');

// class group CRUD
Route::post('/classgroup/Create', [ClassGroupController::class, "create"])->name('classgroup.create');
Route::put('/classgroup/Edit/{id}', [ClassGroupController::class, "update"])->name('classgroup.edit');
Route::delete('/classgroup/Delete/{id}', [ClassGroupController::class, "delete"])->name('classgroup.delete');
Route::get('/classgroup/{id}', [ClassgroupController::class, "getById"])->name('classgroup.info');

// classroom CRUD
Route::post('/classroom/Create', [ClassroomController::class, "create"])->name('classroom.create');
Route::put('/classroom/Edit/{id}', [ClassroomController::class, "update"])->name('classroom.edit');
Route::delete('/classroom/Delete/{id}', [ClassroomController::class, "delete"])->name('classroom.delete');
Route::get('/classroom/{id}', [ClassroomController::class, "getById"])->name('classroom.info');

// test CRUD
Route::get('/test/{id}', [TestController::class, "getById"])->name('test.info');



