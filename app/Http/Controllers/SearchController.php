<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function searchProduct(Request $request)
    {
        $listBrand = Brand::orderBy('id')->get();

        $searchValue = $request->only('q');
        if ($searchValue['q'] == null || $searchValue['q'] == '' || $searchValue['q'] ==' ') {
            return redirect()->back()->with('notify', 'Không được để trống từ khóa tìm kiếm!');
        }

        if (is_numeric($searchValue['q'])) {
            /*$listProduct = Product::where([
                ['current_price', '>=', $searchValue['q'] - $searchValue['q'] * 0.2],
                ['current_price', '<=', $searchValue['q'] + $searchValue['q'] * 0.2]
            ]) ->paginate(8)->appends(Input::except('page'));*/

            $listProduct = Product::whereRaw("current_price - (current_price * discount_percent) >= ?", $searchValue['q'] - $searchValue['q'] * 0.2)
                ->whereRaw('current_price - (current_price * discount_percent) <= ?', $searchValue['q'] + $searchValue['q'] * 0.2)
                ->paginate(8)->appends(Input::except('page'));


        } else {
            $listProduct = Product::where('name', 'LIKE', '%' . $searchValue['q'] . '%')
                ->paginate(8)->appends(Input::except('page'));
        }
        //dd($listProduct->total());

        if ($listProduct->total() == 0) {
            return view('search.search', compact('listBrand', 'listProduct'));
        } else {
            $images = [];
            foreach ($listProduct as $product) {
                //echo $product->category_id ."<br>";
                //echo $product->brand_id ."<br>";
                //echo $product->name ."<br>";
                //echo $product->current_price ."<br>";
                //echo $product->discount_percent ."<br>";

                $brand = Brand::where('id', $product->brand_id)->first();
                //dd($brand->id);

                if ($product->category_id = 2 || $brand->name == 'N/A') {
                    $path = 'img\products\accessories\400\\';
                    if ($dh = opendir($path)) {
                        while (($title = readdir($dh)) !== false) {
                            if (preg_match('/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/', $title, $m)) {
                                //var_dump($m); die;
                                //echo $title . '<br />';
                                $images[] = $path . $title;
                            }
                        }
                    }
                }
                if ($product->category_id = 1 && $brand->name !== 'N/A') {
                    $path = 'img\products\\' . strtolower($brand->name) . '\400\\';
                    if ($dh = opendir($path)) {
                        while (($title = readdir($dh)) !== false) {
                            if (preg_match('/([a-zA-Z0-9\.\-\_\\s\(\)]+)\.([a-zA-Z0-9]+)$/', $title, $m)) {
                                //var_dump($m); die;
                                //echo $title . '<br />';
                                $images[] = str_replace('\\', '/', $path . $title);
                            }
                        }
                    }
                }

            }//exit;
            /*foreach ($images as $img) {
                echo $img."<br>";
            }exit;*/

            //dd($images);
            return view('search.search', compact('listBrand', 'listProduct', 'images'));
            /*return view('search.search', compact('listBrand','listProduct', 'images'),[
                'search' => $listProduct->appends(Input::except('page'))
            ]);*/
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
