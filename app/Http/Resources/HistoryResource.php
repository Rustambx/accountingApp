<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date?->format('Y-m-d\TH:i'),
            'date_format' => $this->date->format('d.m.Y'),
            'comment' => $this->comment,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'formatted_amount' => $this->formatted_amount,
            'category_id' => $this->category_id,
            'category' => CategoryResource::make($this->category)->resolve(),
        ];
    }
}
