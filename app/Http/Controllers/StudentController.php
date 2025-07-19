<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    private StudentService $service;
    public function __construct()
    {
        $this->service = new StudentService();
    }
    public function home(Request $request)
    {
        $student = auth()->user();
        $subjects = $this->service->getSubjectCards($request->input("search") ?? "");
        $tests = $this->service->getTestCards($request->input("search") ?? "");

        return $this->ajaxOrView($request, 'app.content.user.student.home', [
            "student" => $student,
            "subjects" => $subjects,
            "tests" => $tests
        ]);
    }
    public function info(Request $request)
    {
        $student = $this->service->getInfo();
        $grades = $this->service->getGrades();
        $className = $this->service->getClassName();

        return $this->ajaxOrView($request, "app.content.user.student.info", ["student" => $student, "grades" => $grades, "className" => $className]);
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
        $result = $this->service->getSubjectCards($request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.subject.subjects", ["subjects" => $result]);
    }
    public function test(Request $request, int $testId)
    {
        $result = $this->service->getTest($testId);
        return $this->ajaxOrView($request, "app.content.test.student-info", [
            "subject" => $result['subject'],
            "test" => $result['test'],
            "date" => $result['date'],
            "grade" => $result['grade']
        ]);
    }
    public function tests(Request $request)
    {
        $result = $this->service->getTestCards($request->input("search") ?? "");
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