<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $listBrand = Brand::orderBy('id')->get();
        $listAllProduct = Product::all();
        $prd = Product::find($id);

        $price =  $prd->current_price - ($prd->current_price * $prd->discount_percent);

        $listProduct = Product::where([
            ['brand_id', $prd->brand_id],
            ['quantity', '>', 0],
            ['id', '!=', $prd->id],
          ])->whereRaw("current_price - (current_price * discount_percent) >= ?", $price - $price*0.2)
            ->whereRaw("current_price - (current_price * discount_percent) <= ?", $price + $price*0.2)
            ->orderByRaw("current_price - (current_price * discount_percent) desc")
            ->take(9)->get()->chunk(3);
        //dd($listProduct);

        if ($prd->category_id == 2) {
            $listAccessoriesSamePrice = Product::where([
                ['category_id', 2],
                ['id', '!=', $prd->id]
              ])->whereRaw("current_price - (current_price * discount_percent) >= ?", $price - $price*0.2)
                ->whereRaw("current_price - (current_price * discount_percent) <= ?", $price + $price*0.2)
                ->orderByRaw("current_price - (current_price * discount_percent) desc")
                ->take(9)->get()->chunk(3);
            //dd($listAccessoriesSamePrice);

            return view('product.product_detail',
                compact('listBrand', 'listAllProduct', 'prd', 'listProduct', 'listAccessoriesSamePrice'));
        }
        else {
            $listProductOfBrandSamePrice = array();
            foreach ($listBrand as $brand) {
                if ($brand->id !== $prd->brand_id && $brand->name != 'N/A') {
                    $listProductOfBrandSamePrice[$brand->name] = Product::where('category_id', 1)
                        ->where('brand_id', $brand->id)
                        ->whereRaw("current_price - (current_price * discount_percent) >= ?", $price - $price*0.2)
                        ->whereRaw("current_price - (current_price * discount_percent) <= ?", $price + $price*0.2)
                        ->orderByRaw("current_price - (current_price * discount_percent) desc")
                        ->take(3)->get();
                }
            }
            //dd($listProductOfBrandSamePrice);

            return view('product.product_detail',
                compact('listBrand', 'listAllProduct', 'prd', 'listProduct', 'listProductOfBrandSamePrice'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
