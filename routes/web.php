<?php

use App\Http\Controllers\SignInController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassGroupController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// login
Route::get('/', [SignInController::class, "loginPage"]);
Route::get('/login', [SignInController::class, "loginPage"]);
Route::get('/register', [SignInController::class, "registerPage"]);
Route::post('/login', [SignInController::class, "login"]);
Route::post('/register', [SignInController::class, "register"]);

Route::get('/student', [StudentController::class, "index"])->name('student.panel');
Route::get('/teacher', [TeacherController::class, "index"])->name('teacher.panel');
Route::get('/admin', [AdminController::class, "index"])->name('admin.panel');

Route::get('/student/home', [StudentController::class, 'home'])->name('student.home');
Route::get('/teacher/home', [TeacherController::class, 'home'])->name('teacher.home');
Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

// student
Route::get('/student/info', [StudentController::class, "info"])->name('student.info');

Route::get('/student/subjects', [StudentController::class, "subjects"])->name('student.subjects');
Route::get('/student/subjects/{id}', [StudentController::class, "subject"])->name('student.subject');

Route::get('/student/tests', [StudentController::class, "tests"])->name('student.tests');
Route::get('/student/tests/{id}', [StudentController::class, "test"])->name('student.test');

Route::get('/student/timetable', [StudentController::class, "timetable"])->name('student.timetable');

Route::post('/student/Create', [StudentController::class, "create"])->name('student.create');
Route::put('/student/Edit/{id}', [StudentController::class, "update"])->name('student.edit');
Route::delete('/student/Delete/{id}', [StudentController::class, "delete"])->name('student.delete');

// teacher
Route::post('/teacher/Create', [TeacherController::class, "create"])->name('teacher.create');
Route::put('/teacher/Edit/{id}', [TeacherController::class, "update"])->name('teacher.edit');
Route::delete('/teacher/Delete/{id}', [TeacherController::class, "delete"])->name('teacher.delete');

// admin
Route::get('/admin/users', [AdminController::class, "users"])->name('admin.users');

Route::get('/admin/subjects', [AdminController::class, "subjects"])->name('admin.subjects');
Route::get('/admin/subjects/create', [AdminController::class, "createSubject"])->name('admin.subjects.create');
Route::get('/admin/subjects/edit/{id}', [AdminController::class, "subjectDetails"])->name('admin.subject');

Route::get('/admin/classgroups', [AdminController::class, "classgroups"])->name('admin.classgroups');
Route::get('/admin/classgroups/create', [AdminController::class, "createClassGroup"])->name('admin.classgroups.create');
Route::get('/admin/classgroups/edit/{id}', [AdminController::class, "classGroupDetails"])->name('admin.classgroup');

Route::get('/admin/classrooms', [AdminController::class, "classrooms"])->name('admin.classrooms');
Route::get('/admin/classrooms/create', [AdminController::class, "createClassroom"])->name('admin.classrooms.create');
Route::get('/admin/classrooms/edit/{id}', [AdminController::class, "classroomDetails"])->name('admin.classroom');

Route::post('/admin/Create', [AdminController::class, "create"])->name('admin.create');
Route::put('/admin/Edit/{id}', [AdminController::class, "update"])->name('admin.edit');
Route::delete('/admin/Delete/{id}', [AdminController::class, "delete"])->name('admin.delete');

// admin - users
Route::get('/admin/admins', [AdminController::class, "admins"])->name('admin.admins');
Route::get('/admin/admins/create', [AdminController::class, "createAdmin"])->name('admin.admins.create');
Route::get('/admin/admins/edit/{id}', [AdminController::class, "adminDetails"])->name('admin.admin');

Route::get('/admin/students', [AdminController::class, "students"])->name('admin.students');
Route::get('/admin/students/create', [AdminController::class, "createStudent"])->name('admin.student.create');
Route::get('/admin/students/edit/{id}', [AdminController::class, "studentDetails"])->name('admin.student');

Route::get('/admin/teachers', [AdminController::class, "teachers"])->name('admin.teachers');
Route::get('/admin/teachers/create', [AdminController::class, "createTeacher"])->name('admin.teacher.create');
Route::get('/admin/teachers/edit/{id}', [AdminController::class, "teacherDetails"])->name('admin.teacher');

// subject
Route::post('/subject/Create', [SubjectController::class, "create"])->name('subject.create');
Route::put('/subject/Edit/{id}', [SubjectController::class, "update"])->name('subject.edit');
Route::delete('/subject/Delete/{id}', [SubjectController::class, "delete"])->name('subject.delete');
Route::get('/subject/{id}', [SubjectController::class, "getById"])->name('subject.info');

// class group
Route::post('/classgroup/Create', [ClassGroupController::class, "create"])->name('classgroup.create');
Route::put('/classgroup/Edit/{id}', [ClassGroupController::class, "update"])->name('classgroup.edit');
Route::delete('/classgroup/Delete/{id}', [ClassGroupController::class, "delete"])->name('classgroup.delete');

// classroom
Route::post('/classroom/Create', [ClassroomController::class, "create"])->name('classroom.create');
Route::put('/classroom/Edit/{id}', [ClassroomController::class, "update"])->name('classroom.edit');
Route::delete('/classroom/Delete/{id}', [ClassroomController::class, "delete"])->name('classroom.delete');

// test
Route::get('/test/{id}', [TestController::class, "getById"])->name('test.info');



