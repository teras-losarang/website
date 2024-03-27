<?php

namespace App\Http\Controllers\API;

use App\Facades\TerasMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        $query = $this->order->query();
        $query = $query->whereHas('cart', function ($query) {
            $query->where('user_id', auth()->user()->id);
        });

        $orders = app(Pipeline::class)
            ->send($query)
            ->through([])
            ->thenReturn()
            ->paginate($request->per_page);

        return new OrderCollection($orders);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge(["status" => 0]);

        $order = $this->order->where($request->only('cart_id'))->first();
        if ($order) {
            return TerasMessage::notFound("data not found!");
        }

        try {
            $this->order->create($request->all());
            DB::commit();
            return TerasMessage::created("order successfully sent!");
        } catch (\Throwable $th) {
            DB::rollBack();
            return TerasMessage::error($th->getMessage());
        }
    }

    public function show(string $id)
    {
        $order = $this->order->find($id);
        if (!$order) {
            return TerasMessage::notFound("data not found!");
        }

        return new OrderDetail($order);
    }
}
