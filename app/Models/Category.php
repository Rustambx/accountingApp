<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type'];

    protected $casts = [
        'type' => TransactionType::class,
    ];

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            TransactionType::Expense => 'Расход',
            TransactionType::Income => 'Доход'
        };
    }
}
