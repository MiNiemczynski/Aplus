<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Teachers";
    protected $primaryKey = "Id";

    public array $teacherMenuActions = [
        ["text" => "Timetable", "url" => "/teacher/timetable", "icon" => "bi bi-calendar2-week"],
        ["text" => "Class Groups", "url" => "/teacher/classgroups", "icon" => "bi bi-person-lines-fill"],
        ["text" => "Subjects", "url" => "/teacher/subjects", "icon" => "bi bi-book"],
        ["text" => "Teacher info", "url" => "/teacher/info", "icon" => "bi bi-person-bounding-box"]
    ];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "UserId");
    }
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'TeacherId', 'Id');
    }
}
