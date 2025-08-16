<?php

namespace App\Models;

use App\Enums\TransactionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    protected $fillable = ['amount', 'date', 'comment', 'type', 'category_id'];

    protected $casts = [
        'date' => 'datetime',
        'type' => TransactionType::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            TransactionType::Expense => 'Расход',
            TransactionType::Income => 'Доход'
        };
    }

    protected static function booted()
    {
        static::creating(function ($history) {
            if (empty($history->date)) {
                $history->date = Carbon::now();
            }
        });
    }
}
