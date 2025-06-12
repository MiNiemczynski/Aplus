<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ClassGroup  extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "ClassGroups";
    protected $primaryKey = "Id";

    public $timestamps = true;
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'ClassGroupId', 'Id');
    }
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class, 'ClassGroupId', 'Id');
    }
}