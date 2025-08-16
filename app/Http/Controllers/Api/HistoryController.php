<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Models\Category;
use App\Models\History;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->historyService->getHistoriesFilters($request, 20)
        );
    }
}
