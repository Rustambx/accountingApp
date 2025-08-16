<?php

namespace App\Http\Controllers;

use App\Http\Requests\History\HistoryStoreRequest;
use App\Http\Requests\History\HistoryUpdateRequest;
use App\Http\Resources\HistoryResource;
use App\Models\History;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HistoryController extends Controller
{
    private HistoryService $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = $this->historyService->paginate();

        return inertia('History/Index', [
            'histories' => HistoryResource::collection($histories)
                ->response()
                ->getData(true),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('History/Create', $this->historyService->getCreateData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoryStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        return $this->historyService->create($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        return inertia('History/Edit', $this->historyService->getEditData($history));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HistoryUpdateRequest $request, History $history)
    {
        $data = $request->validated();

        $this->historyService->update($history, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        $this->historyService->delete($history);

        return response()->json([
            'message' => 'История успешно удалена'
        ], Response::HTTP_OK);
    }

    public function getHistoriesFilters(Request $request)
    {
        return response()->json(
            $this->historyService->getHistoriesFilters($request, 20)
        );
    }
}
