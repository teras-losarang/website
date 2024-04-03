<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "store" => [
                "id" => $this->store->id,
                "name" => $this->store->name
            ],
            "purchases" => $this->getPurchases($this->purchases),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }


    protected function getPurchases($purchases)
    {
        $data = [];

        foreach ($purchases as $purchase) {
            $data[] = [
                "id" => $purchase->id,
                "product_name" => $purchase->product->name,
                "product_price" => $purchase->product->price,
                "qty" => $purchase->qty,
                "amount" => $purchase->amount,
                "variant" => json_decode($purchase->variant),
                "notes" => $purchase->notes,
            ];
        }

        return $data;
    }
}
