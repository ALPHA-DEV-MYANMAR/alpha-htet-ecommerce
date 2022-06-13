<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = new Order();
        $orders = $orders->with('OrderStatus');
        $orders = $orders->latest()->paginate(5);

        return response()->json([
            'message' => 'success',
            'data'    => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order();
        $order->product_id = $request->product_id;
        $order->user_id    = Auth::user()->id;
        $order->total_stock = $request->total_stock;
        $order->order_status = $request->order_status;
        $order->save();

        return response()->json([
            'message' => 'success',
            'data'    => $order
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orders = new Order();
        $orders = $orders->with('OrderStatus');
        $order = $orders->find($order->id);

        return response()->json([
            'message'  => 'success',
            'data'     => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {

        $order->product_id = $request->product_id;
        $order->user_id    = Auth::user()->id;
        $order->total_stock = $request->total_stock;
        $order->order_status = $request->order_status;
        $order->update();

        $orders = new Order();
        $orders = $orders->with('OrderStatus');
        $order = $orders->find($order->id);

        return response()->json([
            'message' => 'success',
            'data'    => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
