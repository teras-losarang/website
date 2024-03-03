<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

    public function deleteImage(ProductImage $productImage)
    {
        DB::beginTransaction();

        try {
            Storage::delete($productImage->path_file);

            $productImage->delete();

            DB::commit();
            return back()->with("success", "Foto berhasil dihapus.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
}
