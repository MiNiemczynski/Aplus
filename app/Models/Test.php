<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    const UPDATED_AT = "EditionDate";
    const CREATED_AT = "CreationDate";

    protected $table = "Tests";
    protected $primaryKey = "Id";

    public $timestamps = true;
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'TestId', 'Id');
    }
    
    public function classSession(): BelongsTo {
        return $this->belongsTo(ClassSession::class, "ClassSessionId");
    }
}