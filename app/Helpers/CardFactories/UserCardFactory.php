<?php

namespace App\Helpers\CardFactories;

use App\View\Components\Card;
use Illuminate\Support\Collection;

class UserCardFactory extends CardFactory
{
    public function makeCards(Collection $items, bool $addNew = false): array
    {
        $role = auth()->user()->getRoleName();
        if ($addNew) {        
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
        }
        foreach ($items as $user) {
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