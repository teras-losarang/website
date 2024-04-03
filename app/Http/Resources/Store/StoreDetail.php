<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $store = $this;

        return [
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
            "operational_hour" => json_decode($store->operational_hour),
            "status" => $store->status,
            "created_at" => $store->created_at,
            "updated_at" => $store->updated_at,
        ];
    }
}
