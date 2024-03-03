<?php

namespace App\Http\Controllers\WEB;

use App\Enums\Day;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Spatie\Permission\Models\Role;

class StoreController extends Controller
{
    protected $store, $user, $role, $product;

    public function __construct(Store $store, User $user, Role $role, Product $product)
    {
        $this->store = $store;
        $this->user = $user;
        $this->role = $role;
        $this->product = $product;
    }

    public function index()
    {
        $data = [
            "stores" => $this->store->all()
        ];

        return view('store.index', $data);
    }

    public function create()
    {
        $data = [
            "users" => $this->user->whereHas('roles', function ($query) {
                $query->where('id', User::CUSTOMER);
            })->doesntHave('store')->get(),
            "days" => Day::get()
        ];

        return view('store.create', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            "user_id" => "required|exists:users,id",
            "name" => "required",
            "address" => "required",
            "description" => "required",
            "file_thumbnail" => "image|mimes:png,jpg,jpeg",
        ]);

        $operationalHour = [];

        foreach ($request->day as $key => $day) {
            $operationalHour[] = [
                "day" => $day,
                "opening_time" => $request->opening_time[$key],
                "closing_time" => $request->closing_time[$key],
            ];
        }

        $request->merge([
            "operational_hour" => json_encode($operationalHour),
            "slug" => Str::slug("$request->name-" . Str::random(6))
        ]);

        try {
            if ($request->hasFile("file_thumbnail")) {
                $request->merge([
                    "thumbnail" => $request->file("file_thumbnail")->store("store")
                ]);
            }

            $this->store->create($request->all());

            DB::commit();
            return to_route("web.store.index")->with("success", "Toko baru berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function show(Store $store)
    {
        $data = [
            "store" => $store,
        ];

        return view('store.show', $data);
    }

    public function edit(Store $store)
    {
        $data = [
            "store" => $store,
        ];

        return view('store.edit', $data);
    }

    public function update(Request $request, Store $store)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "address" => "required",
            "description" => "required",
            "file_thumbnail" => "image|mimes:png,jpg,jpeg",
        ]);

        $operationalHour = [];

        foreach ($request->day as $key => $day) {
            $operationalHour[] = [
                "day" => $day,
                "opening_time" => $request->opening_time[$key],
                "closing_time" => $request->closing_time[$key],
            ];
        }

        $request->merge([
            "operational_hour" => json_encode($operationalHour),
        ]);

        if (Str::slug($store->name) != Str::slug($request->name)) {
            $request->merge([
                "slug" => Str::slug("$request->name-" . Str::random(6))
            ]);
        }

        try {
            if ($request->hasFile("file_thumbnail")) {
                if ($store->thumbnail) {
                    Storage::delete($store->thumbnail);
                }

                $request->merge([
                    "thumbnail" => $request->file("file_thumbnail")->store("store")
                ]);
            }

            $store->update($request->all());

            DB::commit();
            return back()->with("success", "Toko berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function destroy(Store $store)
    {
        DB::beginTransaction();

        try {
            if ($store->thumbnail) {
                Storage::delete($store->thumbnail);
            }

            $store->delete();

            DB::commit();
            return back()->with("success", "Toko berhasil dihapus.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function productCreate(Store $store)
    {
        $data = [
            "store" => $store
        ];

        return view("store.product.create", $data);
    }

    public function productStore(Request $request, Store $store)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "price" => "required",
            "stock" => "required|numeric",
            "description" => "required",
            "images" => "required|array",
            "images.*" => "image|mimes:png,jpg,jpeg",
        ]);

        $request->merge([
            "slug" => Str::slug("$request->name-" . Str::random(6)),
            "price" => str_replace(",", "", $request->price),
            "store_id" => $store->id
        ]);

        try {
            $product = $this->product->create($request->except("images"));

            foreach ($request->images as $image) {
                $product->images()->create([
                    "path_file" => $image->store("product")
                ]);
            }

            DB::commit();
            return to_route("web.store.show", $store)->with("success", "Produk berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function productEdit(Store $store, Product $product)
    {
        $data = [
            "store" => $store,
            "product" => $product
        ];

        return view("store.product.edit", $data);
    }

    public function productUpdate(Request $request, Store $store, Product $product)
    {
        DB::beginTransaction();

        $request->validate([
            "name" => "required",
            "price" => "required",
            "stock" => "required|numeric",
            "description" => "required",
            "images" => "array",
            "images.*" => "image|mimes:png,jpg,jpeg",
        ]);

        if (Str::slug($product->name) != Str::slug($request->name)) {
            $request->merge([
                "slug" => Str::slug("$request->name-" . Str::random(6))
            ]);
        }

        $request->merge([
            "price" => str_replace(",", "", $request->price),
            "store_id" => $store->id
        ]);

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
            return to_route("web.store.show", $store)->with("success", "Produk berhasil disimpan.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }

    public function productDestroy(Store $store, Product $product)
    {
        DB::beginTransaction();

        try {
            foreach ($product->images as $image) {
                Storage::delete($image->path_file);
            }

            $product->delete();

            DB::commit();
            return back()->with("success", "Produk berhasil dihapus.");
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
        }
    }
}
