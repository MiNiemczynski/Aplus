<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

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


    /** @use HasFactory<\Database\Factories\UserFactory> */
    // use HasFactory, Notifiable;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var list<string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var list<string>
    //  */
    // protected $hidden = [
    //     // 'password',
    //     // 'remember_token',
    // ];

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
}
