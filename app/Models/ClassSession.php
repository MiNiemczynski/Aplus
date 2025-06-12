<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "ClassSessions";
    protected $primaryKey = "Id";

    public $timestamps = true;
    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class, 'ClassGroupId', 'Id');
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'SubjectId', 'Id');
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'ClassroomId', 'Id');
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'TeacherId', 'Id');
    }
    public function studentClassSessions(): HasMany
    {
        return $this->hasMany(StudentClassSession::class, 'ClassSessionId', 'Id');
    }
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'ClassSessionId', 'Id');
    }
}