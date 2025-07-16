<?php
namespace App\Services;

use App\Models\ClassGroup;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;
use App\Services\FinalGradeService;
use App\View\Components\Card;

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

        $student = Student::with(['user'])->where([
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
    public function getGrades(): Collection
    {
        $studentId = auth()->user()->student->Id;
        $gradeService = new GradeService();

        $grades = $gradeService->getByStudentId($studentId);
        return $grades;
    }
    public function getSubject(int $subjectId)
    {
        $studentId = auth()->user()->student->Id;

        $subjectService = new SubjectService();
        $subject = $subjectService->getById($subjectId);

        $finalgradeService = new FinalGradeService();
        $finalGrade = $finalgradeService->getByStudentSubject($studentId, $subjectId);
        
        $gradeService = new GradeService();
        $grades = $gradeService->getBySubjectAndStudentId($subjectId, $studentId);

        return [
            'subject' => $subject,
            'finalGrade' => $finalGrade->Mark ?? null,
            'grades' => $grades
        ];
    }
    public function getSubjectCards(string $search = ""): array
    {
        $classId = auth()->user()->student->ClassGroupId;
        
        $subjectService = new SubjectService();
        $subjects = $subjectService->getByClassId($classId, $search);

        foreach ($subjects as $subject) {
            $cards[] = new Card(
                $subject->Name,
                "",
                "/student/subjects/" . $subject->Id
            );
        }
        return $cards;
    }
    public function getTest(int $testId): array
    {
        $testService = new TestService();
        $test = $testService->getById($testId);

        $gradeService = new GradeService();
        $grade = $gradeService->getByTestId($testId);

        $classSessionService = new ClassSessionService();
        $classSession = $classSessionService->getByTestId($testId);

        $subjectService = new SubjectService();
        $subject = $subjectService->getByClassSessionId($classSession->Id);

        return [
            'subject' => $subject->Name,
            'test' => $test,
            'date' => $classSession->SessionDate,
            'grade' => $grade
        ];
    }

    public function getTestCards(string $search = ""): array
    {
        $classId = auth()->user()->student->ClassGroupId;
        
        $testService = new TestService();
        $tests = $testService->getByClassGroupId($classId, $search);

        foreach ($tests as $test) {
            $cards[] = new Card(
                $test->Subject,
                $test->Date,
                "/student/tests/" . $test->Id
            );
        }
        return $cards;
    }
    public function getWeek(Carbon $weekStart)
    {
        $classId = auth()->user()->student->ClassGroupId;
        $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();

        $classSessionService = new ClassSessionService();
        $classSessions = $classSessionService->getClassSessionsByClassInRange($classId, $weekStart, $weekEnd);

        return $classSessions;
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