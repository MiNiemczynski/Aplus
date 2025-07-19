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
        $user = auth()->user();
        if($user) {
            return redirect()->route($user->getRoleName().".home")->with('replace', true);
        }
        return view("sign-in.login", $result);
    }
    public function logout(Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view("sign-in.login");
    }
    public function register(Request $request) {
        $result = $this->service->register($request);
        return view("sign-in.register", $result);
    }
}