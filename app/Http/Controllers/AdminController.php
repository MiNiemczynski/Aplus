<?php
namespace App\Http\Controllers;

use App\Services\AdminService;
use App\Services\StudentService;
use App\Services\TeacherService;
use App\Services\ClassGroupService;
use App\Services\ClassroomService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\View\Components\Card;

class AdminController extends Controller
{
    private AdminService $service;
    public function __construct()
    {
        $this->service = new AdminService();
    }
    public function home(Request $request)
    {
        $admin = auth()->user();
        return $this->ajaxOrView($request, 'app.content.user.admin.home', [
            "admin" => $admin,
            "subjects" => app(SubjectService::class)->getSubjectCards($request->input("search") ?? ""),
            "classgroups" => app(ClassGroupService::class)->getClassGroupCards($request->input("search") ?? ""),
            "classrooms" => app(ClassroomService::class)->getClassroomCards($request->input("search") ?? ""),
            "actioncards" => [
                new Card("Admins", "", "/admin/admins"),
                new Card("Students", "", "/admin/students"),
                new Card("Teachers", "", "/admin/teachers")
            ]
        ]);
    }
    // subject
    public function createSubject(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.subject.create");
    }
    public function subjectDetails(Request $request, int $id)
    {
        $subject = app(SubjectService::class)->getById($id);
        return $this->ajaxOrView($request, "app.content.subject.create", ["subject" => $subject]);
    }
    public function subjects(Request $request)
    {
        $subjects = app(SubjectService::class)->getSubjectCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.subject.subjects", ["subjects" => $subjects]);
    }
    // class group
    public function createClassGroup(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.classgroup.create");
    }
    public function classGroupDetails(Request $request, int $id)
    {
        $classgroup = app(ClassGroupService::class)->getById($id);
        return $this->ajaxOrView($request, "app.content.classgroup.create", ["classgroup" => $classgroup]);
    }
    public function classGroups(Request $request)
    {
        $classgroups = app(ClassGroupService::class)->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.classgroup.classgroups", ["classgroups" => $classgroups]);
    }
    // classroom
    public function createClassroom(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.classroom.create");
    }
    public function classroomDetails(Request $request, int $id)
    {
        $classroom = app(ClassroomService::class)->getById($id);
        return $this->ajaxOrView($request, "app.content.classroom.create", ["classroom" => $classroom]);
    }
    public function classrooms(Request $request)
    {
        $classrooms = app(ClassroomService::class)->getClassroomCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.classroom.classrooms", ["classrooms" => $classrooms]);
    }
    // users 
    public function users(Request $request)
    {
        $users = $this->service->getUserCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.user.users", [
            "actioncards" => [
                new Card("Admins", "", "/admin/admins"),
                new Card("Students", "", "/admin/students"),
                new Card("Teachers", "", "/admin/teachers")
            ],
            "admins" => $users["admins"],
            "students" => $users["students"],
            "teachers" => $users["teachers"]
        ]);
    }
    public function create(Request $request)
    {
        $this->service->create($request);
        return $this->redirectToRoleRoute("admins");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return $this->redirectToRoleRoute("admins");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return $this->redirectToRoleRoute("admins");
    }
    // admin
    public function createAdmin(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.user.admin.create");
    }
    public function adminDetails(Request $request, int $id)
    {
        $admin = $this->service->getUserById($id);
        return $this->ajaxOrView($request, "app.content.user.admin.create", ["admin" => $admin]);
    }
    public function admins(Request $request)
    {
        $admins = $this->service->getUserCards($request->input("search") ?? "")["admins"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $admins, "title" => "Admins"]);
    }
    // student
    public function createStudent(Request $request)
    {
        $classgroups = app(ClassGroupService::class)->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.user.student.create", ["classgroups" => $classgroups]);
    }
    public function studentDetails(Request $request, int $id)
    {
        $student = app(StudentService::class)->getStudentById($id);
        $classgroups = app(ClassGroupService::class)->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.user.student.create", ["student" => $student, "classgroups" => $classgroups]);
    }
    public function students(Request $request)
    {
        $students = $this->service->getUserCards($request->input("search") ?? "")["students"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $students, "title" => "Students"]);
    }
    // teacher
    public function createTeacher(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.user.teacher.create");
    }
    public function teacherDetails(Request $request, int $id)
    {
        $teacher = app(TeacherService::class)->getTeacherById($id);
        return $this->ajaxOrView($request, "app.content.user.teacher.create", ["teacher" => $teacher]);
    }
    public function teachers(Request $request)
    {
        $teachers = $this->service->getUserCards($request->input("search") ?? "")["teachers"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $teachers, "title" => "Teachers"]);
    }
}