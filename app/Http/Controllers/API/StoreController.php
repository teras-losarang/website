<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateRequest;
use App\Http\Requests\Store\UpdateRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Http\Resources\Store\StoreDetail;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    protected $store, $product;

    public function __construct(Store $store, Product $product)
    {
        $this->store = $store;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $stores = app(Pipeline::class)
            ->send($this->store->query())
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new StoreCollection($stores);
    }


    public function search(Request $request)
    {
        $data = [];
        $stores = $this->store->query();
        $products = $this->product->query();

        if ($request->has('search')) {
            $stores->where('name', 'like', "%$request->search%");
            $products->where('name', 'like', "%$request->search%");
        }

        $stores = $stores->get();
        $products = $products->get();

        if ($stores->count() > 0) {
            foreach ($stores as $key => $store) {
                $data[] = [
                    "id" => $store->id,
                    "name" => $store->name,
                    "slug" => $store->slug,
                    "description" => $store->description,
                    "address" => $store->address,
                    "longlat" => $store->longlat,
                    "tags" => $store->tags,
                ];
            }

            return TerasMessage::render([
                'status' => TerasMessage::SUCCESS,
                'status_code' => TerasMessage::HTTP_OK,
                'data' => $data
            ]);
        }

        return TerasMessage::render([
            'status' => TerasMessage::SUCCESS,
            'status_code' => TerasMessage::HTTP_OK,
            'data' => $data
        ]);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

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

            $store = $this->store->create($request->all());

            DB::commit();
            return TerasMessage::created("$store->name has been added!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $store = $this->store->find($id);
        if (!$store) {
            return TerasMessage::notFound("data not found!");
        }

        return new StoreDetail($store);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();

        $store = $this->store->find($id);
        if (!$store) {
            return TerasMessage::notFound("data not found!");
        }

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
            return TerasMessage::success("$store->name has been updated!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $store = $this->store->find($id);
        if (!$store) {
            return TerasMessage::notFound("data not found!");
        }

        try {
            if ($store->thumbnail) {
                Storage::delete($store->thumbnail);
            }

            $store->delete();

            DB::commit();
            return TerasMessage::success("$store->name has been deleted!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }
}
