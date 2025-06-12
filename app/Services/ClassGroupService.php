<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\ClassGroup;
use Illuminate\Support\Collection;

class ClassGroupService
{
    public function getById(int $id): ?ClassGroup
    {
        $classgroup = ClassGroup::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $classgroup;
    }
    public function getAll(string $search = ""): Collection
    {
        $classgroups = ClassGroup::where([
            ["IsActive", "=", true]
        ]);

        if (!empty($search)) {
            $classgroups = $classgroups->where('Name', 'LIKE', "%$search%");
        }

        return $classgroups->get();
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
        ]);

        $model = new ClassGroup();
        $model->Name = $request->input(key: "name");
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'max:10'],
        ]);

        $model = ClassGroup::find($id);
        $model->Name = $request->input(key: "name");
        $model->IsActive = true;
        $model->save();
    }
    public function delete(int $id) {
        $model = ClassGroup::find($id);
        $model->IsActive = false;
        $model->save();
    }
}