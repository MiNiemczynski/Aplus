<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardsContainer extends Component
{
    public array $cards;
    public string $title;
    /**
     * Create a new component instance.
     */
    public function __construct($cards = [], string $title = "")
    {
        $this->cards = $cards;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards-container');
    }
}
