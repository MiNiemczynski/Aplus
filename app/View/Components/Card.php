<?php

namespace App\View\Components;

use Closure;
use App\Helpers\ColorHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public int $id;
    public string $title;
    public string $description;
    public string $url;
    public string $colorClass;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $description, string $url, int $id = 0)
    {
        $id != 0 ? $this->id = $id : $this->id = 0;
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
