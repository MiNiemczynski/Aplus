<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function ajaxOrView(Request $request, string $view, array $data = [])
    {
        $search = $request->input('search') ?? '';
        if ($request->ajax()) {
            return view($view, $data);
        }
        return view('app.index', [
            'user' => auth()->user(),
            'ajaxView' => view($view, $data)->render(),
            'search' => $search
        ]);
    }
}
