<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\ClassGroup;
use Illuminate\Support\Collection;
use App\View\Components\Card;

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
        $model = ClassGroup::where("Name", $request->input("name"))->first();
        if($model) {
            $model->IsActive = true;
            $model->save();
            return;
        }
        
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
    public function getClassGroupCards(string $search = ""): array
    {
        $classGroups = $this->getAll($search);

        $cards[] = new Card(
            "Add new",
            "",
            "/admin/classgroups/create",
        );
        foreach ($classGroups as $classGroup) {
            $cards[] = new Card(
                $classGroup->Name,
                "",
                "/admin/classgroups/edit/" . $classGroup->Id,
                $classGroup->Id
            );
        }
        return $cards;
    }
}