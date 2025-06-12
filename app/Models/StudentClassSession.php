<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class StudentClassSession extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "StudentClassSessions";
    protected $primaryKey = "Id";

    public $timestamps = true;

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, "StudentId");
    }
    
    public function classSession(): BelongsTo {
        return $this->belongsTo(ClassSession::class, "ClassSessionId");
    }
}