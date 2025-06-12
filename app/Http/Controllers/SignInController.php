<?php
namespace App\Http\Controllers;

use App\Services\SignInService;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    private SignInService $service;

    public function __construct() {
        $this->service = new SignInService();
    }
    public function loginPage(Request $request) {
        return view("sign-in.login");
    }
    public function registerPage(Request $request) {
        return view("sign-in.register");
    }
    public function login(Request $request) {
        $result = $this->service->login($request);
        $role = $result["role"] ?? "";
        if($role != "") {
            return redirect()->route($role.".panel")->with('replace', true);
        }
        return view("sign-in.login", $result);
    }
    public function register(Request $request) {
        $result = $this->service->register($request);
        return view("sign-in.register", $result);
    }
}