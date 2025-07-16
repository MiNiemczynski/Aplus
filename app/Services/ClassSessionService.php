<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ClassSessionService
{
    public function getById(int $id): ?ClassSession
    {
        $classSession = ClassSession::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $classSession;
    }
    
    public function getByTestId(int $testId): ?ClassSession
    {
        $classSession = ClassSession::join('Tests', 'ClassSessions.Id', '=', 'Tests.ClassSessionId')
            ->where([
                ["Tests.Id", "=", $testId],
                ["Tests.IsActive", "=", true]
            ])->first();
        return $classSession;
    }
    public function getClassSessionsByClassInRange(int $classId, Carbon $start, Carbon $end): Collection
    {
        $sessions = ClassSession::where([
            ["ClassSessions.ClassGroupId", "=", $classId],
            ["ClassSessions.IsActive", "=", true]
        ])
            ->whereBetween('ClassSessions.SessionDate', [$start->startOfDay(), $end])
            ->orderBy('ClassSessions.SessionDate')
            ->with(['Subject'])->get();

        return $sessions;
    }
    public function getAll(): Collection
    {
        $classSessions = ClassSession::where([
            ["IsActive", "=", true]
        ])->get();

        return $classSessions;
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'], //todo
        ]);

        $model = new ClassSession();
        $model->Name = $request->input(key: "name"); //todo
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'max:10'], //todo
        ]);

        $model = ClassSession::find($id);
        $model->Name = $request->input(key: "name"); //todo
        $model->IsActive = true;
        $model->save();
    }
    public function delete(int $id) {
        $model = ClassSession::find($id);
        $model->IsActive = false;
        $model->save();
    }
}