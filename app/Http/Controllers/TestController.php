<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TestService;
use App\Models\Test;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    private TestService $service;
    public function __construct()
    {
        $this->service = new TestService();
    }
    public function getById(Request $request, int $id)
    {
        $result = $this->service->getInfo($id);

        $classGroupName = $result->ClassSession->ClassGroup->Name ?? "Unknown class";
        $classSessionDate = $result->ClassSession->SessionDate ?? "Unknown date";
        $subjectName = $result->ClassSession->Subject->Name ?? "Unknown subject";

        return $this->ajaxOrView(
            $request,
            "app.content.test-info",
            [
                "test" => $result,
                "classGroup" => $classGroupName,
                "date" => $classSessionDate,
                "subject" => $subjectName
            ]
        );
    }
}