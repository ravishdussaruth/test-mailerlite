<?php

namespace App\Http\Resources\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
            'id'       => $this->id,
            'balance'  => $this->balance,
            'currency' => $this->currency,
            'limit'    => $this->limit_per_day,
            'spent'    => $this->spendOnDay()
        ];
    }
}
