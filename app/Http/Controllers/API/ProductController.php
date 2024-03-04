<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductDetail;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $product, $productImage;

    public function __construct(Product $product, ProductImage $productImage)
    {
        $this->product = $product;
        $this->productImage = $productImage;
    }

    public function index(Request $request)
    {
        $products = app(Pipeline::class)
            ->send($this->product->query())
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new ProductCollection($products);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "slug" => Str::slug("$request->name-" . Str::random(6)),
        ]);

        try {
            $product = $this->product->create($request->except("images"));

            foreach ($request->images as $image) {
                $product->images()->create([
                    "path_file" => $image->store("product")
                ]);
            }

            DB::commit();
            return TerasMessage::created("$product->name has been added!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $product = $this->product->find($id);
        if (!$product) {
            return TerasMessage::notFound("data not found!");
        }

        return new ProductDetail($product);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();

        $product = $this->product->find($id);
        if (!$product) {
            return TerasMessage::notFound("data not found!");
        }

        if (Str::slug($product->name) != Str::slug($request->name)) {
            $request->merge([
                "slug" => Str::slug("$request->name-" . Str::random(6))
            ]);
        }

        try {
            if ($request->images) {
                foreach ($request->images as $image) {
                    $product->images()->create([
                        "path_file" => $image->store("product")
                    ]);
                }
            }

            $product->update($request->except("images"));

            DB::commit();
            return TerasMessage::success("$product->name has been updated!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $product = $this->product->find($id);
        if (!$product) {
            return TerasMessage::notFound("data not found!");
        }

        try {
            foreach ($product->images as $image) {
                Storage::delete($image->path_file);
            }

            $product->delete();

            DB::commit();
            return TerasMessage::success("$product->name has been deleted!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function deleteImage($id)
    {
        DB::beginTransaction();

        $productImage = $this->productImage->find($id);
        if (!$productImage) {
            return TerasMessage::notFound("data not found!");
        }

        try {
            Storage::delete($productImage->path_file);

            $productImage->delete();

            DB::commit();
            return TerasMessage::success("data has been deleted!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }
}
