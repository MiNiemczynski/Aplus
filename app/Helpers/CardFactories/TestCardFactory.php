<?php

namespace App\Helpers\CardFactories;

use App\View\Components\Card;
use Illuminate\Support\Collection;

class TestCardFactory extends CardFactory
{
    public function makeCards(Collection $items, bool $addNew = false): array
    {
        $role = auth()->user()->getRoleName();
        if ($addNew) {
            $cards[] = new Card(
                "Add new",
                "",
                "/".$role."/tests/create",
            );
        }
        foreach ($items as $test) {
            $cards[] = new Card(
                $test->Subject,
                $test->Date,
                "/".$role."/tests/".$test->Id
            );
        }
        return $cards ?? [];
    }
}