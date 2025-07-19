<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubjectService;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    private SubjectService $service;
    public function __construct()
    {
        $this->service = new SubjectService();
    }
    public function getById(Request $request, int $id)
    {
        $result = $this->service->getById($id);
        return $this->ajaxOrView($request,"app.content.subject.info", ["subject" => $result]);
    }
    public function create(Request $request)
    {
        $this->service->create($request);
        return $this->redirectToRoleRoute("subjects");
    }
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);
        return $this->redirectToRoleRoute("subjects");
    }
    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);
        return $this->redirectToRoleRoute("subjects");
    }
}