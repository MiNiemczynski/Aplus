<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class AdminService extends UserService
{
    public function getAdminById(int $id): User
    {
        return $this->getUserById($id);
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
        $model->IsAdmin = true;
        $model->IsActive = true;
        $model->save();
    }
    public function update(Request $request, int $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,Email,' . $id . ',Id']
        ]);

        $user->Name = $request->input(key: "name");
        $user->Email = $request->input(key: "email");

        $user->save();
    }
    public function delete(int $id)
    {
        $user = User::find($id);
        $user->IsActive = false;
        $user->save();
    }
}