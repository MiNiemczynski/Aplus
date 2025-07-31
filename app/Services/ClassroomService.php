<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Classroom;
use Illuminate\Support\Collection;
use App\View\Components\Card;

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
        ])->orderBy('FloorNumber', 'asc')->orderBy('RoomNumber', 'asc');

        if (!empty($search)) {
            $classrooms = $classrooms
                ->where('RoomNumber', 'LIKE', "%$search%")
                ->orWhere('FloorNumber', 'LIKE', "%$search%");
        }

        return $classrooms->get();
    }
    public function create(Request $request)
    {
        $model = Classroom::where([
            ["RoomNumber", "=", $request->input("room")],
            ["FloorNumber", "=", $request->input("floor")]
        ])->first();
        if($model != null) {
            $model->IsActive = true;
            $model->save();
            return;
        }

        $request->validate([
            'room' => ['required', 'integer', 'between:1,99'],
            'floor' => ['required', 'integer', 'between:0,2']
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
            'floor' => ['required', 'integer', 'between:0,2']
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
    
    public function getClassroomCards(string $search = ""): array
    {
        $classrooms = $this->getAll($search);

        $cards[] = new Card(
            "Add new",
            "",
            "/admin/classrooms/create"
        );
        foreach ($classrooms as $classroom) {
            $cards[] = new Card(
                "Room: " . $classroom->RoomNumber,
                "Floor: " . $classroom->FloorNumber,
                "/admin/classrooms/edit/" . $classroom->Id
            );
        }
        return $cards;
    }
}