<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\CreateRequest;
use App\Http\Resources\Favorite\FavoriteCollection;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    protected $store, $favorite;

    public function __construct(Store $store, Favorite $favorite)
    {
        $this->store = $store;
        $this->favorite = $favorite;
    }

    public function index(Request $request)
    {
        $query = $this->favorite->query();
        $query = $query->where('user_id', auth()->user()->id);

        $favorites = app(Pipeline::class)
            ->send($query)
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new FavoriteCollection($favorites);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $store = $this->store->find($request->store_id);
        if (!$store) {
            return TerasMessage::notFound("data not found!");
        }

        $request->merge([
            "user_id" => auth()->user()->id
        ]);

        try {
            $favorite = $this->favorite->where($request->all())->first();

            DB::commit();
            if ($favorite) {
                $favorite->delete();
                return TerasMessage::success("$store->name has been remove favorite!");
            } else {
                $this->favorite->create($request->all());
                return TerasMessage::success("$store->name has been added favorite!");
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
