<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Students";
    protected $primaryKey = "Id";

    public array $studentMenuActions = [
        ["text" => "Timetable", "url" => "/student/timetable", "icon" => "bi bi-calendar2-week"],
        ["text" => "Subjects", "url" => "/student/subjects", "icon" => "bi bi-book"],
        ["text" => "Tests", "url" => "/student/tests", "icon" => "bi bi-pencil-square"],
        ["text" => "Student info", "url" => "/student/info", "icon" => "bi bi-person-bounding-box"]
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "UserId");
    }
    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class, "ClassGroupId");
    }
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'StudentId', 'Id');
    }
    public function finalGrades(): HasMany
    {
        return $this->hasMany(FInalGrade::class, 'StudentId', 'Id');
    }
    public function studentClassSessions(): HasMany
    {
        return $this->hasMany(StudentClassSession::class, 'StudentId', 'Id');
    }
}
