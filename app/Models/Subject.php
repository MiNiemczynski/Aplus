<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Subjects";
    protected $primaryKey = "Id";

    public $timestamps = true;
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'SubjectId', 'Id');
    }
    public function finalGrades(): HasMany
    {
        return $this->hasMany(FinalGrade::class, 'SubjectId', 'Id');
    }
}