<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public User $user;
    public string $role;
    public array $sidebarButtons = [];
    
    public function __construct()
    {
        $this->user = auth()->user();
        if($this->user->isStudent()) $this->role = "student";
        elseif($this->user->isTeacher()) $this->role = "teacher";
        elseif($this->user->isAdmin()) $this->role = "admin";
        
        $this->sidebarButtons = [["text"=>"Home", "url"=>"/".$this->role."/home", "icon"=>"bi bi-house-door"]];
        switch($this->role) {
            case "student":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $this->user->student->studentMenuActions);
                break;
            case "teacher":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $this->user->teacher->teacherMenuActions);
                break;
            case "admin":
                $this->sidebarButtons = array_merge($this->sidebarButtons, $this->user->adminMenuActions);
                break;
        };
    }
    
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
