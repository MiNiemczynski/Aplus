<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $sidebarButtons = [];
    
    public function __construct()
    {
        $user = auth()->user();
        $this->sidebarButtons = [["text"=>"Home", "url"=>"/".$user->getRoleName()."/home", "icon"=>"bi bi-house-door"]];
        switch($user->getRoleName()) {
            case "student":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $user->student->studentMenuActions);
                break;
            case "teacher":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $user->teacher->teacherMenuActions);
                break;
            case "admin":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $user->adminMenuActions);
                break;
        };
    }
    
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
