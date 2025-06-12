<?php
namespace App\Services;

use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Support\Collection;

class GradeService
{
    public function getByTest(int $testId): ?Grade
    {
        return Grade::where([
            ['testId', '=', $testId],
            ['IsActive', '=', true],
        ])->first();
    }
}