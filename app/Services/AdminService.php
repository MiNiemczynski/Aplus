<?php
namespace App\Services;

use App\Models\User;
use App\Models\Subject;
use App\Models\ClassGroup;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Hash;
use App\View\Components\Card;

class AdminService
{
    public function getById(int $id): User
    {
        return User::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function getSubjectCards(string $search = ""): array
    {
        $subjectService = new SubjectService();
        $subjects = $subjectService->getAll($search);

        $cards[] = new Card(
            "Add new",
            "",
            "/admin/subjects/create"
        );
        foreach ($subjects as $subject) {
            $cards[] = new Card(
                $subject->Name,
                "",
                "/admin/subjects/edit/" . $subject->Id
            );
        }
        return $cards;
    }
    public function getSubject(int $subjectId): ?Subject
    {
        $subjectService = new SubjectService();
        return $subjectService->getById($subjectId);
    }

    public function getClassGroupCards(string $search = ""): array
    {
        $classGroupService = new ClassGroupService();
        $classGroups = $classGroupService->getAll($search);

        $cards[] = new Card(
            "Add new",
            "",
            "/admin/classgroups/create"
        );
        foreach ($classGroups as $classGroup) {
            $cards[] = new Card(
                $classGroup->Name,
                "",
                "/admin/classgroups/edit/" . $classGroup->Id
            );
        }
        return $cards;
    }
    public function getClassGroup(int $classGroupId): ?ClassGroup
    {
        $classGroupService = new ClassGroupService();
        return $classGroupService->getById($classGroupId);
    }
    public function getClassroomCards(string $search = ""): array
    {
        $classroomService = new ClassroomService();
        $classrooms = $classroomService->getAll($search);

        $cards[] = new Card(
            "Add new",
            "",
            "/admin/classrooms/create"
        );
        foreach ($classrooms as $classroom) {
            $cards[] = new Card(
                "Room: " . $classroom->RoomNumber,
                "Floor: " . $classroom->FloorNumber,
                "/admin/classrooms/edit/" . $classroom->Id
            );
        }
        return $cards;
    }
    public function getClassroom(int $classroomId): ?Classroom
    {
        $classroomService = new ClassroomService();
        return $classroomService->getById($classroomId);
    }
    public function getAllUserCards(string $search = ""): array
    {
        $users = User::with(['student', 'teacher'])->where([
            ["IsActive", "=", true]
        ]);
        if(!empty($search)){
            $users = $users->where("Name", "LIKE", "%$search%");
        }
        $users = $users->get();

        $adminCards = [new Card(
            "Add new",
            "",
            "/admin/admins/create"
        )];
        $studentCards = [new Card(
            "Add new",
            "",
            "/admin/students/create"
        )];
        $teacherCards = [new Card(
            "Add new",
            "",
            "/admin/teachers/create"
        )];
        foreach ($users as $user) {
            if ($user->isAdmin()) {
                $adminCards[] = new Card(
                    $user->Name,
                    "admin",
                    "/admin/admins/edit/".$user->Id
                );
                continue;
            }
            if ($user->isStudent()) {
                $studentCards[] = new Card(
                    $user->Name,
                    "student",
                    "/admin/students/edit/".$user->student->Id
                );
                continue;
            }
            if ($user->isTeacher()) {
                $teacherCards[] = new Card(
                    $user->Name,
                    "teacher",
                    "/admin/teachers/edit/".$user->teacher->Id
                );
            }
        }
        return ["admins" => $adminCards, "students"=> $studentCards, "teachers"=> $teacherCards];
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
        $model->IsAdmin = true;
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email,' . $id . ',Id']
        ]);

        $user->Name = $request->input(key: "name");
        $user->Email = $request->input(key: "email");

        $user->save();
    }
    public function delete(int $id)
    {
        $user = User::find($id);
        $user->IsActive = false;
        $user->save();
    }
}