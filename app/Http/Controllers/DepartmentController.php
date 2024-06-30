<?php

namespace App\Http\Controllers;

use App\Services\Department\DepartmentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    //
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function data(): JsonResponse
    {
        try {
            $departments = $this->departmentService->getDepartments();
            return response()->json($departments);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
