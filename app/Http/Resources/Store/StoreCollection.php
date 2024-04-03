<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        foreach ($this as $key => $store) {
            $data[] = [
                "id" => $store->id,
                "customer" => [
                    "id" => $store->user->id,
                    "name" => $store->user->name,
                ],
                "name" => $store->name,
                "slug" => $store->slug,
                "description" => $store->description,
                "address" => $store->address,
                "longlat" => $store->longlat,
                "thumbnail" => $store->thumbnail ? asset("storage/$store->thumbnail") : asset('assets/img/ecommerce-images/default.jpg'),
                "status" => $store->status,
                "created_at" => $store->created_at,
                "updated_at" => $store->updated_at,
            ];
        }

        return $data;
    }
}
