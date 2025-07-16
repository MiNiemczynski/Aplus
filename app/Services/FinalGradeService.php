<?php
namespace App\Services;

use App\Models\FinalGrade;

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