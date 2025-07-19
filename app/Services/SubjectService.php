<?php
namespace App\Services;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SubjectService
{
    public function getById(int $id): ?Subject
    {
        $subject = Subject::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $subject;
    }
    
    public function getByClassSessionId(int $classSessionId): ?Subject
    {
        $subject = Subject::join('ClassSessions', 'ClassSessions.SubjectId', '=', 'Subjects.Id')
            ->where([
                ["ClassSessions.Id", "=", $classSessionId],
                ["ClassSessions.IsActive", "=", true]
            ])
            ->first();
        return $subject;
    }

    public function getByClassId(int $classId, ?string $search = null): Collection
    {
        $subjects = Subject::join('ClassSessions', 'ClassSessions.SubjectId', '=', 'Subjects.Id')
            ->where([
                ["ClassGroupId", "=", $classId],
                ["ClassSessions.IsActive", "=", true],
                ["Subjects.IsActive", "=", true]
            ])
            ->select('Subjects.*')
            ->distinct();

        if (!empty($search)) {
            $subjects->where('Subjects.Name', 'LIKE', "%$search%");
        }

        return $subjects->get();
    }


    public function getAll(string $search = ""): Collection
    {
        $subjects = Subject::where([
            ["IsActive", "=", true]
        ]);

        if (!empty($search)) {
            $subjects = $subjects->where('Name', 'LIKE', "%$search%");
        }

        return $subjects->get();
    }

    public function create(Request $request)
    {
        $model = Subject::where("Name", $request->input("name"))->first();
        if($model) {
            $model->IsActive = true;
            $model->save();
            return;
        }

        $request->validate([
            'name' => ['required', 'max:100'],
        ]);

        $model = new Subject();
        $model->Name = $request->input(key: "name");
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
        ]);

        $model = Subject::find($id);
        $model->Name = $request->input(key: "name");
        $model->IsActive = true;
        $model->save();
    }
    public function delete(int $id)
    {
        $model = Subject::find($id);
        $model->IsActive = false;
        $model->save();
    }
}