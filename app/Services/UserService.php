<?php
namespace App\Services;

use App\Models\User;
use App\View\Components\Card;
use Illuminate\Support\Collection;

class UserService
{
    public function getUserById(int $id): User
    {
        return User::with(['student', 'teacher'])->where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function getUsers(string $search = "", string $role = ""): Collection
    {
        $users = User::with(['student', 'teacher'])->where([
            ["IsActive", "=", true]
        ]);
        if (!empty($search)) {
            $users = $users->where("Name", "LIKE", "%$search%");
        }
        if (!empty($role)) {
            switch ($role) {
                case 'admin':
                    $users = $users->where('IsAdmin', true);
                    break;
                default:
                    $users = $users->whereHas($role);
                    break;
            }
        }
        $users = $users->get();
        return $users;
    }
    public function getUserCards(string $search = ""): array
    {
        $role = auth()->user()->getRoleName();
        $users = $this->getUsers($search);

        $adminCards = [
            new Card(
                "Add new",
                "",
                "/".$role."/admins/create"
            )
        ];
        $studentCards = [
            new Card(
                "Add new",
                "",
                "/".$role."/students/create"
            )
        ];
        $teacherCards = [
            new Card(
                "Add new",
                "",
                "/".$role."/teachers/create"
            )
        ];
        foreach ($users as $user) {
            if ($user->isAdmin()) {
                $adminCards[] = new Card(
                    $user->Name,
                    "admin",
                    "/".$role."/admins/" . $user->Id
                );
                continue;
            }
            if ($user->isStudent()) {
                $studentCards[] = new Card(
                    $user->Name,
                    "student",
                    "/".$role."/students/" . $user->student->Id
                );
                continue;
            }
            if ($user->isTeacher()) {
                $teacherCards[] = new Card(
                    $user->Name,
                    "teacher",
                    "/".$role."/teachers/" . $user->teacher->Id
                );
            }
        }
        return ["admins" => $adminCards, "students" => $studentCards, "teachers" => $teacherCards];
    }
}