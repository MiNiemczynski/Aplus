<?php
namespace App\Services;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Hash;

class TeacherService {
    public function getById(int $id): Teacher {
        return Teacher::with("user")->where([
            ["Id", "=", $id],
            ["IsActive", "=", true]
        ])->first();
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email'],
            'password' => ['required', 'max:255'],
            'password_repeat' => ['required', 'same:password']
        ]);
        $model = new User();
        $model->Name = $request->input(key: "name");
        $model->Email = $request->input(key: "email");
        $model->Password = Hash::make($request->input(key: "password"));
        $model->IsActive = true;
        $model->save();

        $teacher = new Teacher();
        $teacher->UserId = $model->Id;
        $teacher->Salary = $request->input("salary");
        $teacher->save();
    }
    public function update(Request $request, int $id)
    {
        $model = Teacher::find($id);
        $user = User::find($model->UserId);

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email,' . $user->Id . ',Id']
        ]);

        $model->Salary = $request->input("salary");
        $user->Name = $request->input(key: "name");
        $user->Email = $request->input(key: "email");

        $user->save();
        $model->save();
    }
    public function delete(int $id)
    {
        $model = Teacher::find($id);
        $user = User::find($model->UserId);

        $model->IsActive = false;
        $user->IsActive = false;

        $model->save();
        $user->save();
    }
}