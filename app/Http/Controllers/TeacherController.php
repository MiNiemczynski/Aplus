<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeacherService;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    private TeacherService $service;
    public function __construct()
    {
        $this->service = new TeacherService();
    }
    public function home(Request $request)
    {
        $teacher = auth()->user()->teacher;
        return $this->ajaxOrView($request,'app.content.user.teacher.home', ["teacher" => $teacher]);
    }
    public function create(Request $request)
    {
        $this->service->create($request);
        return redirect()->route("admin.teachers");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return redirect()->route("admin.teachers");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect()->route("admin.teachers");
    }
}