<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function paginate(int $userId, int $page = 20)
    {
        return Category::where('user_id', $userId)
            ->latest()
            ->paginate($page)
            ->withQueryString();
    }

    public function create(array $data): array
    {
        $category = Category::create($data);

        return CategoryResource::make($category)->resolve();
    }

    public function update(Category $category, array $data): array
    {
        $category->update($data);

        return CategoryResource::make($category)->resolve();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
