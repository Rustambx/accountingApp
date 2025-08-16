<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'user_id'];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class);
    }
}
