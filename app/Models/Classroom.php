<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Classrooms";
    protected $primaryKey = "Id";

    public $timestamps = true;

    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'ClassroomId', 'Id');
    }
}
