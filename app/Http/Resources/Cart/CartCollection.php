<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $cart) {
            $data[] = [
                "id" => $cart->id,
                "store" => [
                    "id" => $cart->store->id,
                    "name" => $cart->store->name
                ],
                "purchases" => $this->getPurchases($cart->purchases),
                "created_at" => $cart->created_at,
                "updated_at" => $cart->updated_at,
            ];
        }

        return $data;
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
                "notes" => $purchase->notes,
            ];
        }

        return $data;
    }
}
