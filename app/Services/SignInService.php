<?php
namespace App\Services;

use Auth;
use Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SignInService {
    public function login(Request $request): array {
        $email = $request->input("email");
        $password = $request->input("password");

        $user = User::where([
                    ["IsActive", "=", true],
                    ["Email", "=", $email]
        ])->first();

        if($user != null && Hash::check($password, $user->Password)) {
            Auth::login($user);

            if ($user->student !== null) $role = "student";
            elseif ($user->teacher !== null) $role = "teacher";
            elseif($user->IsAdmin) $role = "admin";
            else $role = "";

            return ["user"=>$user, "role"=>$role];
        } else {
            $errors[] = "User not found";
            return ["email"=>$email, "errors"=>$errors];
        }
    }
    public function register(Request $request): array {
        $name = $request->input("name");
        $email = $request->input("email");
        $password = $request->input("password");
        $password_repeat = $request->input("password_repeat");

        if($password != $password_repeat) {
            $errors[] = "Passwords must be identical!";
        }

        $user = User::where("Email", "=", "$email")->first();

        if($user != null) {
            $errors[] = "E-mail is already in use!";
        } 

        if(isset($errors) && count($errors) != 0) {
            return ["name"=>$name, "email"=>$email, "errors"=>$errors];
        } else {
            $model = new User();
            $model->Name = $name;
            $model->Email = $email;
            $model->Password = Hash::make($password);
            $model->IsActive = true;

            switch($request->input("role")) {
                case "student":
                    $model->IsAdmin = false;
                    $model->save();

                    $student = new Student();
                    $student->UserId = $model->Id;
                    $student->save();
                    break;
                case "teacher":
                    $model->IsAdmin = false;
                    $model->save();

                    $teacher = new Teacher();
                    $teacher->UserId = $model->Id;
                    $teacher->save();
                    break;
                case "admin":
                    $model->IsAdmin = true;
                    $model->save();
                    break;
            }

            return ["email"=>$email];
        }
    }
}