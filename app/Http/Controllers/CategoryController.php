<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function listAccessories() {
        $listBrand = Brand::orderBy('id')->get();

        $listProduct = Product::where([
            ['category_id', 2],
            ['quantity', '>', 0]
        ])->orderBy('current_price', 'DESC')->paginate(12);
        $p = 'D:/ProgramFiles/XAMPP/XAMPP-V7.3.7/htdocs/laravel/SellMobilePhone/public/';
        $path = 'img/products/accessories/400/';
        $images = [];
        if ($dh = opendir($path)) {
            while (($title = readdir($dh)) !== false) {
                if (preg_match('/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/', $title, $m)) {
                    //var_dump($m); die;
                    //echo $title . '<br />';
                    $images[] = $path.$title;
                }
            }
        }
        return view('category.accessories', compact('listBrand','listProduct', 'images'));
    }
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
