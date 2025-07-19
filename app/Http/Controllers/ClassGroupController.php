<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClassGroupService;
use App\Http\Controllers\Controller;

class ClassGroupController extends Controller
{
    private ClassGroupService $service;
    public function __construct()
    {
        $this->service = new ClassGroupService();
    }
    public function create(Request $request)
    {
        $this->service->create($request);
        return $this->redirectToRoleRoute("classgroups");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return $this->redirectToRoleRoute("classgroups");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return $this->redirectToRoleRoute("classgroups");
    }
}