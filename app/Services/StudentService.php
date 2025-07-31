<?php
namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Carbon\Carbon;

class StudentService extends UserService
{
    public function getStudentById(int $id): Student
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