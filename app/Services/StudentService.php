<?php
namespace App\Services;

use App\Models\ClassGroup;
use App\Models\ClassSession;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Models\Grade;
use DB;
use App\Services\FinalGradeService;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StudentService
{
    public function getById(int $id): Student
    {
        return Student::with("user")->where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function getInfo(): Student
    {
        $userId = auth()->user()->Id;

        $student = Student::with(['user', 'grades'])->where([
            ["UserId", "=", $userId],
            ["IsActive", "=", true]
        ])->first();

        return $student;
    }
    public function getClass(): ClassGroup
    {
        $classId = auth()->user()->student->ClassGroupId;
        $classGroupService = new ClassGroupService();

        $class = $classGroupService->getById($classId);
        return $class;
    }
    public function getSubject(int $subjectId)
    {
        $studentId = auth()->user()->student->Id;
        $classId = auth()->user()->student->ClassGroupId;

        $subjectService = new SubjectService();
        $subject = $subjectService->getById($subjectId);

        $finalgradeService = new FinalGradeService();
        $finalGrade = $finalgradeService->getByStudentSubject($studentId, $subjectId);

        $testGrades = Grade::where([
            ['grades.StudentId', '=', $studentId],
            ['grades.IsActive', '=', true]
        ])
            ->join('tests', 'grades.TestId', '=', 'tests.Id')
            ->join('classsessions', 'tests.ClassSessionId', '=', 'classsessions.Id')
            ->where([
                ['tests.IsActive', '=', true],
                ['classsessions.IsActive', '=', true],
                ['classsessions.SubjectId', '=', $subjectId],
                ['classsessions.ClassGroupId', '=', $classId],
            ])->get();

        return [
            'subject' => $subject,
            'finalGrade' => $finalGrade->Mark ?? null,
            'grades' => $testGrades
        ];
    }
    public function getSubjects(string $search = ""): array
    {
        $classId = auth()->user()->student->ClassGroupId;
        $subjects = ClassSession::where([
            ["ClassGroupId", "=", $classId],
            ["ClassSessions.IsActive", "=", true]
        ])->join('Subjects', 'SubjectId', '=', 'Subjects.Id')
            ->select('Subjects.*')
            ->distinct();

        if (!empty($search)) {
            $subjects = $subjects->where('Name', 'LIKE', "%$search%");
        }

        $subjects = $subjects->get();

        $data = [];
        foreach ($subjects as $subject) {
            $data[] = [
                "title" => $subject->Name,
                "description" => "",
                "url" => "/student/subjects/" . $subject->Id
            ];
        }
        return $data;
    }
    public function getTest(int $testId): array
    {
        $classId = auth()->user()->student->ClassGroupId;


        $testService = new TestService();
        $test = $testService->getById($testId);

        $gradeService = new GradeService();
        $grade = $gradeService->getByTest($testId);

        $classSession = ClassSession::where([
            ['ClassSessions.IsActive', '=', true],
            ['ClassSessions.ClassGroupId', '=', $classId]
        ])
            ->join('Tests', 'ClassSessions.Id', '=', 'Tests.ClassSessionId')
            ->where([
                ['Tests.IsActive', '=', true],
                ['Tests.Id', '=', $testId]
            ])->first();

        $subject = DB::table('Subjects')
            ->join('ClassSessions', 'Subjects.Id', '=', 'ClassSessions.SubjectId')
            ->where([
                ['ClassSessions.Id', '=', $classSession->Id],
                ['Subjects.IsActive', '=', true],
            ])
            ->select('Subjects.Name as Name')
            ->first();

        return [
            'subject' => $subject->Name,
            'test' => $test,
            'date' => $classSession->SessionDate,
            'grade' => $grade
        ];
    }

    public function getTests(string $search = ""): array
    {
        $classId = auth()->user()->student->ClassGroupId;
        $tests = DB::table("ClassSessions")
            ->where(
                [
                    ["ClassSessions.ClassGroupId", "=", $classId],
                    ["ClassSessions.IsActive", "=", true]
                ]
            )->join("Tests", "Tests.ClassSessionId", "=", "ClassSessions.Id")
            ->where("Tests.IsActive", true)
            ->join("Subjects", "Subjects.Id", "=", "ClassSessions.SubjectId")
            ->select(
                "Tests.Id as Id",
                "ClassSessions.SessionDate as Date",
                "Subjects.Name as Subject"
            );

        if (!empty($search)) {
            $tests = $tests
                ->where('ClassSessions.SessionDate', 'LIKE', "%$search%")
                ->orWhere('Subjects.Name', 'LIKE', "%$search%");
        }

        $tests = $tests->get();

        $data = [];
        foreach ($tests as $test) {
            $data[] = [
                "title" => $test->Subject,
                "description" => $test->Date,
                "url" => "/student/tests/" . $test->Id
            ];
        }
        return $data;
    }
    public function getWeek(Carbon $weekStart)
    {
        $classId = auth()->user()->student->ClassGroupId;
        $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();

        $sessions = ClassSession::where([
            ["ClassSessions.ClassGroupId", "=", $classId],
            ["ClassSessions.IsActive", "=", true]
        ])
            ->whereBetween('ClassSessions.SessionDate', [$weekStart->startOfDay(), $weekEnd])
            ->orderBy('ClassSessions.SessionDate')
            ->with(['Subject'])->get();

        return $sessions;
    }

    public function getTimetable(int $offset): array
    {
        $weekStart = Carbon::parse(now()->startOfWeek()->addWeeks($offset));
        $sessions = $this->getWeek($weekStart);

        $days = [];
        for ($i = 0; $i <= 4; $i++) {
            $days[] = $weekStart->copy()->addDays($i);
        }

        $groupedSessions = [];
        foreach ($sessions as $session) {
            $date = Carbon::parse($session->SessionDate)->format('Y-m-d');

            if (!isset($groupedSessions[$date])) {
                $groupedSessions[$date] = [];
            }

            $groupedSessions[$date][] = $session;
        }

        $week = $weekStart->format('d.m.Y') . '-' . $weekStart->copy()->addDays(6)->format('d.m.Y');
        return [
            "days" => $days,
            "groupedSessions" => $groupedSessions,
            "weekStart" => $weekStart,
            "week" => $week,
            "offset" => $offset,
            "role" => "student"
        ];
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email'],
            'password' => ['required', 'max:255'],
            'password_repeat' => ['required', 'same:password']
        ]);
        $model = new User();
        $model->Name = $request->input(key: "name");
        $model->Email = $request->input(key: "email");
        $model->Password = Hash::make($request->input(key: "password"));
        $model->IsActive = true;
        $model->save();

        $student = new Student();
        $student->UserId = $model->Id;
        $student->ClassGroupId = $request->input("classGroupId");
        $student->save();
    }
    public function update(Request $request, int $id)
    {
        $model = Student::find($id);
        $user = User::find($model->UserId);

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email,' . $user->Id . ',Id']
        ]);

        $model->ClassGroupId = $request->input("classGroupId");
        $user->Name = $request->input(key: "name");
        $user->Email = $request->input(key: "email");

        $user->save();
        $model->save();
    }
    public function delete(int $id)
    {
        $model = Student::find($id);
        $user = User::find($model->UserId);

        $model->IsActive = false;
        $user->IsActive = false;

        $model->save();
        $user->save();
    }
}