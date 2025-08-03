<?php

namespace App\Helpers\CardFactories;

use App\View\Components\Card;
use Illuminate\Support\Collection;

class SubjectCardFactory extends CardFactory
{
    public function makeCards(Collection $items, bool $addNew = false): array
    {
        $role = auth()->user()->getRoleName();
        if ($addNew) {
            $cards[] = new Card(
                "Add new",
                "",
                "/" . $role . "/subjects/create"
            );
        }
        foreach ($items as $subject) {
            $cards[] = new Card(
                $subject->Name,
                "",
                "/" . $role . "/subjects/" . $subject->Id
            );
        }
        return $cards ?? [];
    }
}