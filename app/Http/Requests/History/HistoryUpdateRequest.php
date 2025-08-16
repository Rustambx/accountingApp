<?php

namespace App\Http\Requests\History;

use Illuminate\Foundation\Http\FormRequest;

class HistoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:expense,income',
            'comment' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required'   => 'Поле "Сумма" обязательно для заполнения.',
            'amount.numeric'    => 'Поле "Сумма" должно быть числом.',
            'amount.min'        => 'Поле "Сумма" не может быть меньше 0.',
            'date.date'         => 'Поле "Дата" должно быть корректной датой.',
            'type.required'     => 'Поле "Тип" обязательно для заполнения.',
            'type.in'           => 'Поле "Тип" должно быть либо "Расход", либо "Доход".',
            'comment.string'    => 'Поле "Комментарий" должно быть строкой.',
            'category_id.required' => 'Поле "Категория" обязательно для заполнения.',
            'category_id.exists'   => 'Выбранная категория не существует.',
        ];
    }
}
