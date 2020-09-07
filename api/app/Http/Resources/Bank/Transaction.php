<?php

namespace App\Http\Resources\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'details' => $this->details,
            'amount'  => "{$this->signed()}$this->amount",
            'when'    => $this->pivot->created_at->format('Y-m-d H:m')
        ];
    }

    /**
     * Plus or negative sign.
     *
     * @return string
     */
    protected function signed(): string
    {
        return $this->pivot->from_or_to === \App\Enums\Account::FROM ? '-' : '+';
    }
}
