<?php

namespace App\View\Components;

use Closure;
use App\Helpers\ColorHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public string $title;
    public string $description;
    public string $url;
    public string $colorClass;
    /**
     * Create a new component instance.
     */
    public function __construct($title, string $description, string $url)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->colorClass = ColorHelper::randomColor();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
