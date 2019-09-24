<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Order;
use App\OrderDetail;
use App\User;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    public function listOrderOfUser()
    {
        $listBrand = Brand::orderBy('id')->get();

        if (Session::get('user') !== null) {
            $getUser = Session::get('user');

            $user = User::where('phone', $getUser['user_phone'])->get();
            $userID = $user->first()->id;
            //dd($userID);

            //danh sach order cua 1 user
            $listOrderOfUser = Order::selectRaw('*,orders.id as orderID, order_details.id as detailID,
            products.id as productID, order_details.quantity as qtyO, products.quantity as qtyP')
                ->where('user_id', $userID)
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->orderBy('orders.order_date', 'desc')
                ->get();
            //dd($listOrderOfUser);

            $listAllOrderDate = array();
            foreach ($listOrderOfUser as $order) {
                $listAllOrderDate[] = $order->order_date;
            }
            $listOrderDate = array_unique($listAllOrderDate);//array_unique: bỏ các giá trị trùng nhau
            //dd($listOrderDate);

            $getAll= array();
            foreach ($listOrderDate as $date) {
                foreach ($listOrderOfUser as $order) {
                    if ($date == $order->order_date) {
                        $getAll[$date][$order->orderID][$order->productID] = $order;
                    }
                }
            }
            //dd(head($getAll));
            //dd(array_key_first($getAll));

            /*foreach ($getAll as $date=>$orderOfDate) {
                foreach ($orderOfDate as $orderID=>$details) {
                    foreach ($details as $productID=>$order) {
                        //dd($orderOfDate);
                    }
                }
            }*/
            return view('order.history', compact('listBrand','getAll'));
        }
        return view('order.history', compact('listBrand'));
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
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
