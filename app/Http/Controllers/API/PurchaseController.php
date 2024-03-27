<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\UpdateRequest;
use App\Models\Cart;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $cart, $purchase;

    public function __construct(Cart $cart, Purchase $purchase)
    {
        $this->cart = $cart;
        $this->purchase = $purchase;
    }

    public function update(UpdateRequest $request, string $id)
    {
        DB::beginTransaction();

        $purchase = $this->purchase->where("id", $id)->whereDoesntHave('cart.order')->first();
        if (!$purchase) {
            return TerasMessage::notFound("data not found!");
        }
        $product = $purchase->product;

        $request->merge([
            "amount" => $product->price * $request->qty
        ]);

        try {
            DB::commit();

            if ($request->qty > 0) {
                $purchase->update($request->only(['qty', 'amount']));
            } else {
                if (!$purchase) {
                    return TerasMessage::notFound("data not found!");
                }

                $purchaseCount = $this->purchase->where("cart_id", $purchase->cart_id)->count();

                if ($purchaseCount == 1) {
                    $purchase->cart()->delete();
                }

                $purchase->delete();
            }

            return TerasMessage::success("$product->name has been updated in cart!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();

        $purchase = $this->purchase->find($id);
        if (!$purchase) {
            return TerasMessage::notFound("data not found!");
        }

        $purchaseCount = $this->purchase->where("cart_id", $purchase->cart_id)->count();
        $product = $purchase->product;

        try {
            if ($purchaseCount == 1) {
                $purchase->cart()->delete();
            }

            $purchase->delete();

            DB::commit();
            return TerasMessage::success("$product->name has been deleted from cart!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return TerasMessage::error($th->getMessage());
        }
    }
}
