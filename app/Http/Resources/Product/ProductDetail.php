<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this;

        return [
            "id" => $product->id,
            "store" => [
                "id" => $product->store->id,
                "name" => $product->store->name,
                "customer" => $product->store->user->name,
            ],
            "variants" => $this->variants($product->variants),
            "name" => $product->name,
            "slug" => $product->slug,
            "description" => $product->description,
            "stock" => $product->stock,
            "price" => $product->price,
            "enable_variant" => $product->enable_variant,
            "status" => $product->status,
            "images" => $this->getImages($product->images),
            "created_at" => $product->created_at,
            "updated_at" => $product->updated_at
        ];
    }

    protected function getImages($images)
    {
        $data = [];

        foreach ($images as $key => $image) {
            $data[] = [
                "id" => $image->id,
                "path_file" => asset("storage/$image->path_file")
            ];
        }

        return $data;
    }

    protected function variants($variants)
    {
        $data = [];

        foreach ($variants as $variant) {
            $data[] = [
                "name" => $variant->name,
                "stock" => $variant->stock,
                "price" => $variant->price,
            ];
        }

        return $data;
    }
}
