<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Carbon\Carbon;

class StudentController extends Controller
{
    private StudentService $service;
    private Student $student;
    public function __construct()
    {
        $this->service = new StudentService();
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return view("sign-in.login", ["errors" => ["You have been logged out!"]]);
        }

        $student = $user->student;
        if (!$student) {
            abort(403, "Access denied – you are not a student");
        }

        return $this->home($request);
    }
    public function home(Request $request)
    {
        $student = auth()->user()->student;
        $subjects = $this->service->getSubjects($request->input("search") ?? "");
        $tests = $this->service->getTests($request->input("search") ?? "");
        return $this->ajaxOrView($request, 'app.content.user.student.home', ["subjects" => $subjects, "student" => $student, "tests" => $tests]);
    }
    public function info(Request $request)
    {
        $student = $this->service->getInfo();
        $class = $this->service->getClass();

        $className = $class["Name"] ?? "Not assigned";

        return $this->ajaxOrView($request, "app.content.user.student.info", ["student" => $student, "class" => $class]);
    }
    public function subject(Request $request, int $subjectId)
    {
        $result = $this->service->getSubject($subjectId);
        return $this->ajaxOrView($request, "app.content.subject.student-info", [
            "subject" => $result['subject'],
            "finalGrade" => $result['finalGrade'],
            "grades" => $result['grades']
        ]);
    }
    public function subjects(Request $request)
    {
        $result = $this->service->getSubjects($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.subject.subjects", ["subjects" => $result]);
    }
    public function test(Request $request, int $testId)
    {
        $result = $this->service->getTest($testId);
        return $this->ajaxOrView($request, "app.content.user.student.test-info", [
            "subject" => $result['subject'],
            "test" => $result['test'],
            "date" => $result['date'],
            "grade" => $result['grade']
        ]);
    }
    public function tests(Request $request)
    {
        $result = $this->service->getTests($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.test.tests", ["tests" => $result]);
    }
    public function timetable(Request $request)
    {
        $result = $this->service->getTimetable($request->input('offset') ?? 0);
        return $this->ajaxOrView($request, "app.content.misc.timetable", $result);
    }

    public function create(Request $request)
    {
        $this->service->create($request);
        return redirect()->route("admin.students");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return redirect()->route("admin.students");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect()->route("admin.students");
    }
}