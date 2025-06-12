<?php
namespace App\Services;

use App\Models\ClassGroup;
use App\Models\ClassSession;
use App\Models\Test;
use App\Models\Subject;
use DB;

class TestService
{
    public function getById(int $id): Test
    {
        $test = Test::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $test;
    }
    public function getSubject(int $testId): Subject
    {
        $subject = DB::table('Tests')
            ->join('ClassSessions', 'Tests.ClassSessionId', '=', 'ClassSessions.Id')
            ->join('Subjects', 'ClassSessions.SubjectId', '=', 'Subjects.Id')
            ->where([
                ['Tests.Id', "=", $testId],
                ['Tests.IsActive', "=", true],
                ['ClassSessions.IsActive', "=", true],
                ['Subjects.IsActive', "=", true]
            ])->first();

        return $subject;
    }
    public function getInfo(int $id): Test
    {
        $test = Test::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->with(["ClassSession", "ClassSession.Subject", "ClassSession.ClassGroup"])->first();
        return $test;
    }
}