<?php
namespace App\Services;

use App\Models\User;
use App\Models\Subject;
use App\Models\ClassGroup;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Hash;

class AdminService
{
    public function getById(int $id): User
    {
        return User::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function getAllSubjects(string $search = ""): array
    {
        $subjectService = new SubjectService();
        $subjects = $subjectService->getAll($search);

        $data[] = [
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/subjects/create"
        ];
        foreach ($subjects as $subject) {
            $data[] = [
                "title" => $subject->Name,
                "description" => "",
                "url" => "/admin/subjects/edit/" . $subject->Id
            ];
        }
        return $data;
    }
    public function getSubject(int $subjectId): ?Subject
    {
        $subjectService = new SubjectService();
        return $subjectService->getById($subjectId);
    }

    public function getAllClassGroups(string $search = ""): array
    {
        $classGroupService = new ClassGroupService();
        $classGroups = $classGroupService->getAll($search);

        $data[] = [
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/classgroups/create"
        ];
        foreach ($classGroups as $classGroup) {
            $data[] = [
                "id" => $classGroup->Id,
                "title" => $classGroup->Name,
                "description" => "",
                "url" => "/admin/classgroups/edit/" . $classGroup->Id
            ];
        }
        return $data;
    }
    public function getClassGroup(int $classGroupId): ?ClassGroup
    {
        $classGroupService = new ClassGroupService();
        return $classGroupService->getById($classGroupId);
    }
    public function getAllClassrooms(string $search = ""): array
    {
        $classroomService = new ClassroomService();
        $classrooms = $classroomService->getAll($search);

        $data[] = [
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/classrooms/create"
        ];
        foreach ($classrooms as $classroom) {
            $data[] = [
                "title" => "Room: " . $classroom->RoomNumber,
                "description" => "Floor: " . $classroom->FloorNumber,
                "url" => "/admin/classrooms/edit/" . $classroom->Id
            ];
        }
        return $data;
    }
    public function getClassroom(int $classroomId): ?Classroom
    {
        $classroomService = new ClassroomService();
        return $classroomService->getById($classroomId);
    }
    public function getAllUsers(string $search = ""): array
    {
        $users = User::with(['student', 'teacher'])->where([
            ["IsActive", "=", true]
        ]);
        if(!empty($search)){
            $users = $users->where("Name", "LIKE", "%$search%");
        }
        $users = $users->get();

        $admins = [[
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/admins/create"
        ]];
        $students = [[
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/students/create"
        ]];
        $teachers = [[
            "title" => "Add new",
            "description" => "",
            "url" => "/admin/teachers/create"
        ]];
        foreach ($users as $user) {
            if ($user->isAdmin()) {
                $admins[] = [
                    "title" => $user->Name,
                    "description" => "admin",
                    "url" => "/admin/admins/edit/".$user->Id
                ];
                continue;
            }
            if ($user->isStudent()) {
                $students[] = [
                    "title" => $user->Name,
                    "description" => "student",
                    "url" => "/admin/students/edit/".$user->student->Id
                ];
                continue;
            }
            if ($user->isTeacher()) {
                $teachers[] = [
                    "title" => $user->Name,
                    "description" => "teacher",
                    "url" => "/admin/teachers/edit/".$user->teacher->Id
                ];
            }
        }
        return ["admins" => $admins, "students"=> $students, "teachers"=> $teachers];
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