<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory;
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate"; 

    protected $table = "Users";
    protected $primaryKey = "Id";
    
    public array $adminMenuActions = [
        ["text"=>"Subjects", "url"=>"/admin/subjects", "icon"=>"bi bi-book"],
        ["text"=>"Class Groups", "url"=>"/admin/classgroups", "icon"=>"bi bi-book"],
        ["text"=>"Users", "url"=>"/admin/users", "icon"=>"bi bi-person"],
        ["text"=>"Classrooms", "url"=>"/admin/classrooms", "icon"=>"bi bi-door-closed"]
    ];

    public function student(): HasOne {
        return $this->hasOne(Student::class, "UserId");
    }
    public function teacher(): HasOne {
        return $this->hasOne(Teacher::class, "UserId");
    }
    public function isAdmin(): bool {
        return $this->IsAdmin == true;
    }
    public function isStudent(): bool {
        return $this->student()->exists();
    }
    public function isTeacher(): bool {
        return $this->teacher()->exists();
    }
    public function getRoleName(): string
    {
        if ($this->isAdmin()) return 'admin';
        if ($this->isTeacher()) return 'teacher';
        if ($this->isStudent()) return 'student';
        return 'unknown';
    }
    public function hasRole(string $role): bool
    {
        return match ($role) {
            'admin' => $this->isAdmin(),
            'student' => $this->isStudent(),
            'teacher' => $this->isTeacher(),
            default => false,
        };
    }
}
