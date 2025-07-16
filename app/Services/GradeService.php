<?php
namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\Grade;

class GradeService
{
    public function getByTestId(int $testId): ?Grade
    {
        return Grade::where([
            ['testId', '=', $testId],
            ['IsActive', '=', true],
        ])->first();
    }
    public function getByStudentId(int $studentId): Collection
    {
        $grades = Grade::where([
            ['grades.StudentId', '=', $studentId],
            ['grades.IsActive', '=', true]
        ])
            ->join('Tests', 'Grades.TestId', '=', 'Tests.Id')
            ->join('ClassSessions', 'Tests.ClassSessionId', '=', 'ClassSessions.Id')
            ->join('Subjects', 'ClassSessions.SubjectId', '=', 'Subjects.Id')
            ->where([
                ['Tests.IsActive', '=', true],
                ['Subjects.IsActive', '=', true]
            ])->select(
                'Grades.*',
                'Subjects.Name as SubjectName'
            )->get();

        return $grades;
    }
    public function getBySubjectAndStudentId(int $subjectId, int $studentId): Collection
    {
        $grades = Grade::where([
            ['grades.StudentId', '=', $studentId],
            ['grades.IsActive', '=', true]
        ])
            ->join('tests', 'grades.TestId', '=', 'tests.Id')
            ->join('classsessions', 'tests.ClassSessionId', '=', 'classsessions.Id')
            ->where([
                ['tests.IsActive', '=', true],
                ['classsessions.IsActive', '=', true],
                ['classsessions.SubjectId', '=', $subjectId]
            ])->get();

        return $grades;
    }

}