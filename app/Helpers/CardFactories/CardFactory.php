<?php

namespace App\Helpers\CardFactories;
use Illuminate\Support\Collection;

abstract class CardFactory
{
    abstract public function makeCards(Collection $items): array;
}