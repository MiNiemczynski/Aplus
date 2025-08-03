<?php
namespace App\Services;

use App\Models\Test;
use App\Helpers\CardFactories\TestCardFactory;
use Illuminate\Support\Collection;
use DB;

class TestService
{
    private $cardFactory;
    public function __construct() {
        $this->cardFactory = app(TestCardFactory::class);
    }
    public function getById(int $id): Test
    {
        $test = Test::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $test;
    }
    public function getByIdWithDetails(int $testId): array
    {
        $test = $this->getById($testId);

        $grade = app(GradeService::class)->getByTestId($testId);
        $classSession = app(ClassSessionService::class)->getByTestId($testId);
        $subject = app(SubjectService::class)->getByClassSessionId($classSession->Id);

        return [
            'subject' => $subject->Name,
            'test' => $test,
            'date' => $classSession->SessionDate,
            'grade' => $grade
        ];
    }
    public function getByClassGroupId(int $classId, string $search = ""): Collection
    { 
        $tests = DB::table("ClassSessions")
            ->where([
                ["ClassSessions.ClassGroupId", "=", $classId],
                ["ClassSessions.IsActive", "=", true]
            ])
            ->join("Tests", "Tests.ClassSessionId", "=", "ClassSessions.Id")
            ->where("Tests.IsActive", true)
            ->join("Subjects", "Subjects.Id", "=", "ClassSessions.SubjectId")
            ->select(
                "Tests.Id as Id",
                "ClassSessions.SessionDate as Date",
                "Subjects.Name as Subject"
            );

        if (!empty($search)) {
            $tests = $tests
                ->where('ClassSessions.SessionDate', 'LIKE', "%$search%")
                ->orWhere('Subjects.Name', 'LIKE', "%$search%");
        }

       return $tests->get();
    }
    public function getInfo(int $id): Test
    {
        $test = Test::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->with(["ClassSession", "ClassSession.Subject", "ClassSession.ClassGroup"])->first();
        return $test;
    }
    
    public function getTestCardsByClassGroupId(int $classId, string $search = ""): array
    {
        $tests = $this->getByClassGroupId($classId, $search);
        $cards = $this->cardFactory->makeCards($tests, addNew: true);
        return $cards;
    }
}