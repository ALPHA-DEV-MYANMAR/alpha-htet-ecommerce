<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'message'  => 'success',
            'data'     => $products
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
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $product = new Product();
        $product->name = $request->name;
        $product->image_id = $request->image_id ;
        $product->description = $request->description;
        $product->stock_id = $request->stock_id ;
        $product->category_id = $request->category_id;
        $product->user_id = Auth::user()->id;
        $product->save();


//        $stock = new Stock();
//        $stock->price = $request->price;
//        $stock->stock_total = $request->stock_total;
//        $stock->product_id = 1 ;

        return response()->json([
            'message' => 'success',
            'data'    => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'message'  =>  'success',
            'data'     => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->image_id = $request->image_id ;
        $product->description = $request->description;
        $product->stock_id = $request->stock_id ;
        $product->category_id = $request->category_id;
        $product->user_id = Auth::user()->id;
        $product->update();

        return response()->json([
            'message'   =>  'success',
            'data'      => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
