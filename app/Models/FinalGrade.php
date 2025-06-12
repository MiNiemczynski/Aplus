<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalGrade extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "FinalGrades";
    protected $primaryKey = "Id";

    public $timestamps = true;

    public function subject(): BelongsTo {
        return $this->belongsTo(Subject::class, "SubjectId");
    }
    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, "StudentId");
    }
}
