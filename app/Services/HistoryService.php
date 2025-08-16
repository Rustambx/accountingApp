<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\HistoryResource;
use App\Models\Category;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryService
{
    public function paginate(int $page = 20)
    {
        return History::where('user_id', auth()->id())
            ->paginate($page)
            ->withQueryString();
    }

    public function getCreateData(): array
    {
        $categories = CategoryResource::collection(
            Category::where('user_id', auth()->id())->get()
        )->resolve();
        $types = TransactionType::options();

        return compact('categories', 'types');
    }

    public function create(array $data): array
    {
        $history = History::create($data);

        return HistoryResource::make($history)->resolve();
    }

    public function getEditData(History $history): array
    {
        $history = HistoryResource::make($history)->resolve();
        $categories = CategoryResource::collection(
            Category::where('user_id', auth()->id())->get()
        )->resolve();
        $types = TransactionType::options();

        return compact('history', 'categories', 'types');
    }

    public function update(History $history, array $data): array
    {
        $history->update($data);

        return HistoryResource::make($history)->resolve();
    }

    public function delete(History $history): void
    {
        $history->delete();
    }

    public function getHistoriesFilters(Request $request, int $page = 20): array
    {
        $query = History::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $histories = $query->paginate($page)->withQueryString();

        return [
            'data' => HistoryResource::collection($histories)->resolve(),
            'meta' => [
                'current_page' => $histories->currentPage(),
                'last_page' => $histories->lastPage(),
                'per_page' => $histories->perPage(),
                'total' => $histories->total(),
                'links' => collect($histories->linkCollection())->map(function ($link) {
                    return [
                        'url' => $link['url'],
                        'label' => $link['label'],
                        'active' => $link['active'] ?? false,
                    ];
                }),
                'categories' => Category::where('user_id', auth()->id())->get(),
            ],
        ];
    }


}
