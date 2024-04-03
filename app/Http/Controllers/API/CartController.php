<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\Cart\CartDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $product, $store, $cart, $purchase;

    public function __construct(Product $product, Store $store, Cart $cart, Purchase $purchase)
    {
        $this->product = $product;
        $this->store = $store;
        $this->cart = $cart;
        $this->purchase = $purchase;
    }

    public function index(Request $request)
    {
        $query = $this->cart->query();
        $query = $query->where('user_id', auth()->user()->id)
            ->whereDoesntHave('order');

        $carts = app(Pipeline::class)
            ->send($query)
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new CartCollection($carts);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $store = $this->store->find($request->store_id);
        if (!$store) {
            return TerasMessage::notFound("data not found!");
        }

        $product = $this->product->find($request->product_id);
        if (!$product) {
            return TerasMessage::notFound("data not found!");
        }

        if ($product->enable_variant && !$request->has('variant')) {
            return TerasMessage::warning("please select a variant!");
        }

        $request->merge([
            "user_id" => auth()->user()->id,
            "amount" => $product->price * $request->qty,
            "variant" => $request->variant
        ]);

        try {
            DB::commit();

            $cart = $this->cart->where(["store_id" => $store->id, "user_id" => auth()->user()->id])->whereDoesntHave('order')->first();
            if ($request->qty > 0) {
                if (!$cart) {
                    $cart = $this->cart->create($request->only(['store_id', 'user_id']));
                }

                $purchase = $this->purchase->where(["cart_id" => $cart->id, "product_id" => $product->id])->first();
                if (!$purchase) {
                    if ($product->enable_variant) {
                        $cart->purchases()->create($request->except(['store_id', 'user_id']));
                    } else {
                        $cart->purchases()->create($request->except(['store_id', 'user_id', 'variant']));
                    }
                } else {
                    $purchase->update($request->except(['store_id', 'user_id']));
                }
            } else {
                if (!$cart) {
                    return TerasMessage::notFound("data not found!");
                }
                $cart->delete();
            }

            return TerasMessage::success("$product->name has been updated in cart!");
        } catch (\Throwable $th) {
            DB::rollback();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function show($id)
    {
        $cart = $this->cart->find($id);
        if (!$cart) {
            return TerasMessage::notFound("data not found!");
        }

        return new CartDetail($cart);
    }
}
