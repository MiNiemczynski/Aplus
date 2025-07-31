<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\Services\GradeService;
use App\Services\FinalGradeService;
use App\Services\TestService;
use App\Services\ClassGroupService;
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
        $student = auth()->user()->student;
        $classGroupId = $student->ClassGroupId;
        $subjects = app(SubjectService::class)->getSubjectCardsByClassGroupId($classGroupId, $request->input("search") ?? "");
        $tests = app(TestService::class)->getTestCardsByClassGroupId($classGroupId, $request->input("search") ?? "");

        return $this->ajaxOrView($request, 'app.content.user.student.home', [
            "student" => $student,
            "subjects" => $subjects,
            "tests" => $tests
        ]);
    }
    public function info(Request $request)
    {
        $student = $this->service->getInfo();
        $grades = app(GradeService::class)->getByStudentId($student->Id);
        $className = app(ClassGroupService::class)->getById($student->ClassGroupId)->Name;

        return $this->ajaxOrView($request, "app.content.user.student.info", ["student" => $student, "grades" => $grades, "className" => $className]);
    }
    public function subject(Request $request, int $subjectId)
    {
        $result = app(SubjectService::class)->getById($subjectId);
        return $this->ajaxOrView($request, "app.content.subject.student-info", [
            "subject" => $result['subject'],
            "finalGrade" => $result['finalGrade'],
            "grades" => $result['grades']
        ]);
    }
    public function subjects(Request $request)
    {
        $classGroupId = auth()->user()->student->ClassGroupId;
        $result = app(SubjectService::class)->getSubjectCardsByClassGroupId($classGroupId, $request->input("search") ?? "");
        return $this->ajaxOrView($request, "app.content.subject.subjects", ["subjects" => $result]);
    }
    public function test(Request $request, int $testId)
    {
        $result = app(TestService::class)->getByIdWithDetails($testId);
        return $this->ajaxOrView($request, "app.content.test.student-info", [
            "subject" => $result['subject'],
            "test" => $result['test'],
            "date" => $result['date'],
            "grade" => $result['grade']
        ]);
    }
    public function tests(Request $request)
    {
        $classGroupId = auth()->user()->student->ClassGroupId;
        $result = app(TestService::class)->getTestCardsByClassGroupId($classGroupId, $request->input("search") ?? "");
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
        return $this->redirectToRoleRoute("students");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return $this->redirectToRoleRoute("students");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return $this->redirectToRoleRoute("students");
    }
}