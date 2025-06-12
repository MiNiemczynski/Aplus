<?php
namespace App\Services;

use App\Models\Subject;
use App\Models\FinalGrade;
use Illuminate\Support\Collection;

class FinalGradeService
{
    public function getByStudentSubject(int $studentId, int $subjectId): ?FinalGrade
    {
        return FinalGrade::where([
            ['StudentId', '=', $studentId],
            ['SubjectId', '=', $subjectId],
            ['IsActive', '=', true],
        ])->first();
    }
}