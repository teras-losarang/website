<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $order) {
            $data[] = [
                "id" => $order->id,
                "store" => [
                    "id" => $order->cart->store->id,
                    "name" => $order->cart->store->name
                ],
                "address" => [
                    "address" => $order->address->address,
                    "longlat" => $order->address->longlat
                ],
                "purchases" => $this->getPurchases($order->cart->purchases),
                "status" => $order->status,
                "shipping_cost" => $order->shipping_cost,
                "service_fee" => $order->service_fee,
                "total_cost" => $order->total_cost,
                "payment_method" => $order->payment_method,
                "notes" => $order->notes,
                "created_at" => $order->created_at,
                "updated_at" => $order->updated_at
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
