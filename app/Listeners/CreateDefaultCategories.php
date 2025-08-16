<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Category;

class CreateDefaultCategories
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        $defaultCategories = [
            'income' => ['Заработная плата', 'Иные доходы'],
            'expense' => ['Продукты питания', 'Транспорт', 'Мобильная связь', 'Интернет', 'Развлечения'],
        ];

        foreach ($defaultCategories as $type => $names) {
            foreach ($names as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'type' => $type,
                ]);
            }
        }
    }
}
