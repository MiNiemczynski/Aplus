<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Grades";
    protected $primaryKey = "Id";

    public $timestamps = true;

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class, "StudentId");
    }
    public function test(): BelongsTo {
        return $this->belongsTo(Test::class, "TestId");
    }
}
