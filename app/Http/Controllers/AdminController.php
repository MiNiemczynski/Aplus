<?php
namespace App\Http\Controllers;

use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;
use App\View\Components\Card;

class AdminController extends Controller
{
    private AdminService $service;
    public function __construct()
    {
        $this->service = new AdminService();
    }
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return view("sign-in.login", ["errors" => ["You have been logged out!"]]);
        }
        if (!$user->isAdmin()) {
            abort(403, "Access denied – you are not an administrator");
        }

        return $this->home($request);
    }
    public function home(Request $request)
    {
        $admin = auth()->user();
        return $this->ajaxOrView($request, 'app.content.user.admin.home', [
            "admin" => $admin,
            "subjects" => $this->service->getSubjectCards($request->input("search") ?? ""),
            "classgroups" => $this->service->getClassGroupCards($request->input("search") ?? ""),
            "classrooms" => $this->service->getClassroomCards($request->input("search") ?? ""),
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
        $subject = $this->service->getSubject($id);
        return $this->ajaxOrView($request, "app.content.subject.create", ["subject" => $subject]);
    }
    public function subjects(Request $request)
    {
        $subjects = $this->service->getSubjectCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.subject.subjects", ["subjects" => $subjects]);
    }
    // class group
    public function createClassGroup(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.classgroup.create");
    }
    public function classGroupDetails(Request $request, int $id)
    {
        $classgroup = $this->service->getClassGroup($id);
        return $this->ajaxOrView($request, "app.content.classgroup.create", ["classgroup" => $classgroup]);
    }
    public function classGroups(Request $request)
    {
        $classgroups = $this->service->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.classgroup.classgroups", ["classgroups" => $classgroups]);
    }
    // classroom
    public function createClassroom(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.classroom.create");
    }
    public function classroomDetails(Request $request, int $id)
    {
        $classroom = $this->service->getClassroom($id);
        return $this->ajaxOrView($request, "app.content.classroom.create", ["classroom" => $classroom]);
    }
    public function classrooms(Request $request)
    {
        $classrooms = $this->service->getClassroomCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.classroom.classrooms", ["classrooms" => $classrooms]);
    }
    // users 
    public function users(Request $request)
    {
        $users = $this->service->getAllUserCards($request->input("search") ?? "");
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
        return redirect()->route("admin.admins");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return redirect()->route("admin.admins");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect()->route("admin.admins");
    }
    // admin
    public function createAdmin(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.user.admin.create");
    }
    public function adminDetails(Request $request, int $id)
    {
        $admin = $this->service->getById($id);
        return $this->ajaxOrView($request, "app.content.user.admin.create", ["admin" => $admin]);
    }
    public function admins(Request $request)
    {
        $admins = $this->service->getAllUserCards($request->input("search") ?? "")["admins"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $admins, "title" => "Admins"]);
    }
    // student
    public function createStudent(Request $request)
    {
        $classgroups = $this->service->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.user.student.create", ["classgroups" => $classgroups]);
    }
    public function studentDetails(Request $request, int $id)
    {
        $studentService = new StudentService();
        $student = $studentService->getById($id);
        $classgroups = $this->service->getClassGroupCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.user.student.create", ["student" => $student, "classgroups" => $classgroups]);
    }
    public function students(Request $request)
    {
        $students = $this->service->getAllUserCards($request->input("search") ?? "")["students"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $students, "title" => "Students"]);
    }
    // teacher
    public function createTeacher(Request $request)
    {
        return $this->ajaxOrView($request, "app.content.user.teacher.create");
    }
    public function teacherDetails(Request $request, int $id)
    {
        $teacherService = new TeacherService();
        $teacher = $teacherService->getById($id);
        return $this->ajaxOrView($request, "app.content.user.teacher.create", ["teacher" => $teacher]);
    }
    public function teachers(Request $request)
    {
        $teachers = $this->service->getAllUserCards($request->input("search") ?? "")["teachers"];
        return $this->ajaxOrView($request, "app.content.user.usersgroup", ["users" => $teachers, "title" => "Teachers"]);
    }
}