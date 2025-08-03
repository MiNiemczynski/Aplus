<?php

namespace App\Helpers\CardFactories;

use App\View\Components\Card;
use Illuminate\Support\Collection;

class ClassroomCardFactory extends CardFactory
{
    public function makeCards(Collection $items, bool $addNew = false): array
    {
        $role = auth()->user()->getRoleName();
        if ($addNew) {
            $cards[] = new Card(
            "Add new",
            "",
            "/" . $role . "/classrooms/create"
            );
        }
        foreach ($items as $classroom) {
            $cards[] = new Card(
                "Room: " . $classroom->RoomNumber,
                "Floor: " . $classroom->FloorNumber,
                "/" . $role . "/classrooms/" . $classroom->Id
            );
        }
        return $cards ?? [];
    }
}