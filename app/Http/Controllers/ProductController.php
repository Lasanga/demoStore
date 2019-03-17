<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(6);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->isMethod('put') ? Product::findOrFail($request->id) : new Product;

        $product->displayName = $request->input('displayName');
        $product->supplierName = $request->input('supplierName');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');

        $isCreated = $product->save();

        if ($isCreated) {
            return new ProductResource($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product != null) {
            $isDeleted = $product->delete();
            
            if ($isDeleted) {
                return new ProductResource($product);
            }
        }
    }
}
