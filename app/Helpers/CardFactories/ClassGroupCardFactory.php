<?php

namespace App\Helpers\CardFactories;

use App\View\Components\Card;
use Illuminate\Support\Collection;

class ClassGroupCardFactory extends CardFactory
{
    public function makeCards(Collection $items, bool $addNew = false): array
    {
        $role = auth()->user()->getRoleName();
        if ($addNew) {
            $cards[] = new Card(
                "Add new",
                "",
                "/" . $role . "/classgroups/create",
            );
        }
        foreach ($items as $classGroup) {
            $cards[] = new Card(
                $classGroup->Name,
                "",
                "/" . $role . "/classgroups/" . $classGroup->Id,
                $classGroup->Id
            );
        }
        return $cards ?? [];
    }
}