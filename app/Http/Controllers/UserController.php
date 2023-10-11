<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ImportService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private ImportService $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    public function import(): JsonResponse
    {
        $data = $this->importService->insertOrUpdateUsers();

        return response()->json($data);
    }
}
