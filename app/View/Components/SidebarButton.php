<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarButton extends Component
{
    public string $text;
    public string $url;
    public string $icon;
    /**
     * Create a new component instance.
     */
    public function __construct(string $text, string $url = '', string $icon = '')
    {
        $this->text = $text;
        $this->url = $url;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-button');
    }
}
