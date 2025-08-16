<?php

namespace App\Enums;

enum TransactionType: string
{
    case Expense = 'expense';
    case Income = 'income';

    public static function options(): array
    {
        return [
            ['value' => self::Expense, 'label' => 'Расход'],
            ['value' => self::Income, 'label' => 'Доход'],
        ];
    }
}
