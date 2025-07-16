<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Support\Collection;

class ClassroomService
{
    public function getById(int $id): ?Classroom
    {
        $classroom = Classroom::where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
        return $classroom;
    }
    public function getAll(string $search = ""): Collection
    {
        $classrooms = Classroom::where([
            ["IsActive", "=", true]
        ]);

        if (!empty($search)) {
            $classrooms = $classrooms
                ->where('RoomNumber', 'LIKE', "%$search%")
                ->orWhere('FloorNumber', 'LIKE', "%$search%");
        }

        return $classrooms->get();
    }
    public function create(Request $request)
    {
        $request->validate([
            'room' => ['required', 'integer', 'between:1,99'],
            'floor' => ['required', 'integer', 'between:1,2']
        ]);

        $model = new Classroom();
        $model->RoomNumber = $request->input(key: "room");
        $model->FloorNumber = $request->input(key: "floor");
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'room' => ['required', 'integer', 'between:1,99'],
            'floor' => ['required', 'integer', 'between:1,2']
        ]);

        $model = Classroom::find($id);
        $model->RoomNumber = $request->input(key: "room");
        $model->FloorNumber = $request->input(key: "floor");
        $model->IsActive = true;
        $model->save();
    }
    public function delete(int $id)
    {
        $model = Classroom::find($id);
        $model->IsActive = false;
        $model->save();
    }
}