<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoryResource;
use App\Services\HistoryService;

class DashboardController extends Controller
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function index()
    {
        $histories = $this->historyService->paginate();

        return inertia('Dashboard', [
            'histories' => HistoryResource::collection($histories)
                ->response()
                ->getData(true),
        ]);
    }
}
