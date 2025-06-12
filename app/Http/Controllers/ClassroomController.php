<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClassroomService;
use App\Models\Classroom;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    private ClassroomService $service;
    public function __construct()
    {
        $this->service = new ClassroomService();
    }
    public function create(Request $request)
    {
        $this->service->create($request);
        return redirect()->route("admin.classrooms");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return redirect()->route("admin.classrooms");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return redirect()->route("admin.classrooms");
    }
}