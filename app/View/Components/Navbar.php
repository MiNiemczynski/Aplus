<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public User $user;
    public string $search;
    /**
     * Create a new component instance.
     */
    public function __construct(User $user, string $search = "")
    {
        $this->user = $user;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
