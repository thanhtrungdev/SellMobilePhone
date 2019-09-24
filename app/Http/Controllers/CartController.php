<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Cart;
use App\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Input;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listBrand = Brand::orderBy('id')->get();
        $listProduct = Product::all();

        if (Session::get('cart') !== null) {
            $getCart = Session::get('cart')->items;

            $total = 0;
            $discount = 0;
            foreach ($getCart as $product_id => $v) {
                $total += $v['qty'] * $v['item']->current_price;
                $discount += $v['qty'] * ($v['item']->current_price * $v['item']->discount_percent);
            }

            return view('cart.view_cart', compact('listBrand','listProduct', 'getCart', 'total', 'discount'));

        } else {
            return view('cart.view_cart', compact('listBrand'));
        }
    }

    public function addProductToCart(Request $request, $id)
    {
        $product = Product::find($id);
        /*$data = $request->only('qty');*/

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        //dd(Session::get('cart')->items);exit;

        if ($oldCart != null) {
            foreach (Session::get('cart')->items as $k => $v) {
                if ($id == $k) {
                    return response()->json(['message' => 'The product already exists!',], 200);
                }
            }
        }

        $cart = new Cart($oldCart);
        $cart->add($product->id, $product);
        $request->session()->put('cart', $cart);
        $c = $request->session()->get('cart');
        //dd($c);exit;
        //dd($c->items);exit;

        //dd($c);exit;
        $result = [sizeof($c->items), $c->totalPrice, $c->items];
        //$j = json_encode($result);

        return response()->json([
            'message' => 'The product has been added!',
            'num_price_product' => $result,
        ], 200);

        //return redirect()->route('homepage');
    }

    public function removeProductFromCart(Request $request, $id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        //dd(($oldCart->items)[$id]['item']->current_price);exit;

        if ($oldCart == null) {
            return response()->json(['message' => 'Cart is empty!',], 200);
        }

        $cart = new Cart($oldCart);
        $listQty = array();
        foreach ($cart->items as $product_id => $sub_key) {
            $listQty[$product_id] = $request->input('qty-product-' . $product_id);
        }
        //var_dump($listQty);
        foreach ($listQty as $product_id => $qty) {
            if ($id == $product_id) {
                $cart->remove($id, $qty);
            }
        }
        //exit;
        $request->session()->put('cart', $cart);
        $c = $request->session()->get('cart');
        $result = [sizeof($c->items), $c->totalPrice, $c->items];
        /*return response()->json([
            'message' => 'The product has been removed!',
            'num_price_product' => $result,
        ], 200);*/
        return redirect()->back();
    }

    public function updateCart(Request $request)
    {
        //dd($qty = $request->input('qty-product-99'));
        //dd($request);

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        //dd(($oldCart->items));exit;
        //dd(($oldCart->items)[$id]['qty']);exit;
        if ($oldCart == null) {
            return response()->json(['message' => 'Cart is empty!',], 200);
        }

        $cart = new Cart($oldCart);
        //dd($cart->items);

        /*$qty = array();
        foreach ($cart->items as $product_id=>$sub_key) {
            $qty[$product_id] = Input::get('qty-product-'.$product_id);
        }
        dd($qty);exit;*/

        foreach ($cart->items as $product_id => $sub_key) {
            $qty = $request->input('qty-product-' . $product_id);
            //$qty = $qty[$product_id] = Input::get('qty-product-'.$product_id);
            if ($qty == null) {
                return redirect()->back()
                    ->withErrors(['qtyProduct'.$product_id => 'Bạn chưa nhập số lượng!',])
                    ->withInput();
            } else if(!is_numeric($qty)) {
                return redirect()->back()
                    ->withErrors(['qtyProduct'.$product_id => 'Số lượng phải là số nguyên dương!',])
                    ->withInput();
            } else if ($qty == 0) {
                return redirect()->back()
                    ->withErrors(['qtyProduct'.$product_id => 'Số lượng tối thiểu phải bằng 1',])
                    ->withInput();
            }

            $cart->update($product_id, $qty);
        }//exit;

        $request->session()->put('cart', $cart);
        //$c = $request->session()->get('cart');
        //dd($c);

        //return response()->json(['message' => 'The cart has been updated!',], 200);

        return redirect()->back()->with('success', 'Giỏ hàng của bạn đã được cập nhật!');
    }

    public function deleteCart()
    {
        /*$oldCart = Session::has('cart') ? Session::get('cart') : null;
        if ($oldCart == null) {
            return response()->json(['message' => 'Cart is empty!',], 200);
        }
        $request->session()->forget('cart');*/

        Session::forget('cart');
        return redirect()->route('homepage')->with('success', 'Giỏ hàng của bạn đã được hủy!');
    }

    public function checkout(Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        if ($oldCart == null) {
            return response()->json(['message' => 'Cart is empty!',], 200);
        }

        $cart = new Cart($oldCart);
        //dd($cart->items);exit;
        /*foreach ($cart->items as $product_id => $product) {
            echo $product_id .': '. $product['qty'] ."<br>";
            dd($product['item']->name);
        }exit;*/

        $info = $request->except('_token'); // $abcxyz = $request->input('input_name'); ...
        //dd($info);exit;
        //dd(sizeof($info));exit;

        $niceNames = array(
            'name' => 'Họ và tên người đặt hàng',
            'address' => 'Địa chỉ người đặt hàng',
            'phone' => 'Số điện thoại',
            'receiver-name' => 'Họ và tên người nhận hàng',
            'receiver-address' => 'Địa chỉ người nhận hàng',
            'receiver-phone' => 'Số điện thoại',
        );
        $messages = [
            'required' => ':attribute không được bỏ trống!',
            'unique' => ':attribute đã tồn tại, vui lòng đăng nhập hoặc kiểm tra lại',
            'email' => 'Email chưa đúng định dạng (name@domain.com)',
            'regex' => ':attribute không đúng định dạng (0xxx xxx xxx)'
        ];
        $user_rule = [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|regex:/(0)(\d{3})(\s)?(\d{3})(\s)?(\d{3})/|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
        ];
        $receiver_rule = [
            'receiver-name' => 'required|string|max:255',
            'receiver-address' => 'required',
            'receiver-phone' => 'required|regex:/(0)(\d{3})(\s)?(\d{3})(\s)?(\d{3})/',
            'receiver-email' => 'nullable|email|max:255',
        ];

        $rule = array_merge($user_rule, $receiver_rule);
        $validator = \Validator::make($info, $rule, $messages);
        $validator->setAttributeNames($niceNames);

        $validator_user = \Validator::make($info, $user_rule, $messages);
        $validator_user->setAttributeNames($niceNames);

        $validator_receiver = \Validator::make($info, $receiver_rule, $messages);
        $validator_receiver->setAttributeNames($niceNames);

        //$error_message = $validator_user->errors()->messages();
        //dd($error_message);

        $user = Session::has('user') ? Session::get('user') : null;

        //dd(sizeof($info));

        if ($user === null) {
            if (sizeof($info) == 5) {
                //echo 'Đặt hàng, nhận hàng và thanh toán';
                if ($validator_user->fails()) {
                    return redirect()->back()->withErrors($validator_user->errors())->withInput();
                }
                $this->createSessionUser($request, $info['name'], $info['address'], $info['phone'], $info['email']);

                $this->createUsers($info['name'], $info['address'], $info['phone'], $info['email']);
                $insertedUserID = User::where('phone', $info['phone'])->first();

                $this->createOrders($insertedUserID['id'], $info['phone'], $info['address'], $info['address']);

                $resultOrder = Order::orderBy('id', 'DESC')->first();
                $insertedOrderId = $resultOrder->id;

                foreach ($cart->items as $product_id => $value) {
                    $amount = $value['qty'] * $value['item']->current_price;
                    $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                    $this->createOrderDetails($insertedOrderId, $product_id, $amount, $discount_amount, $value['qty']);

                    $oldQty = Product::find($product_id)->quantity;
                    $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                }

            }
            else {

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }

                $this->createSessionUser($request, $info['name'], $info['address'], $info['phone'], $info['email']);

                $this->createUsers($info['name'], $info['address'], $info['phone'], $info['email']);
                $insertedUserID = User::where('phone', $info['phone'])->first();

                if ($info['payment-check'] == 'user_pay') {
                    //echo 'Đặt hàng cho người khác và thanh toán';
                    $this->createOrders($insertedUserID['id'], $info['receiver-phone'], $info['receiver-address'], $info['address']);
                    $insertedOrderID = Order::where('user_id', $insertedUserID['id'])->orderBy('id', 'desc')->first();

                    foreach ($cart->items as $product_id => $value) {
                        $amount = $value['qty'] * $value['item']->current_price;
                        $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                        $this->createOrderDetails($insertedOrderID['id'], $product_id, $amount, $discount_amount, $value['qty']);

                        $oldQty = Product::find($product_id)->quantity;
                        $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                    }
                }

                if ($info['payment-check'] == 'receiver_pay') {
                    //echo 'Chỉ đặt hàng, người nhận hàng thanh toán';
                    $this->createOrders($insertedUserID['id'], $info['receiver-phone'], $info['receiver-address'], $info['receiver-address']);
                    $insertedOrderID = Order::where('user_id', $insertedUserID['id'])->orderBy('id', 'desc')->first();

                    foreach ($cart->items as $product_id => $value) {
                        $amount = $value['qty'] * $value['item']->current_price;
                        $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                        $this->createOrderDetails($insertedOrderID['id'], $product_id, $amount, $discount_amount, $value['qty']);

                        $oldQty = Product::find($product_id)->quantity;
                        $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                    }
                }
            }
        }
        else {
            $sessionUser = $request->session()->get('user');
            $insertedUserID = User::where('phone', $sessionUser['user_phone'])->first();

            if (sizeof($info) == 5) {
                //echo 'Đặt hàng, nhận hàng và thanh toán';
                $this->createOrders($insertedUserID['id'], $sessionUser['user_phone'], $sessionUser['user_address'], $sessionUser['user_address']);
                $insertedOrderID = Order::where('user_id', $insertedUserID['id'])->orderBy('id', 'desc')->first();

                foreach ($cart->items as $product_id => $value) {
                    $amount = $value['qty'] * $value['item']->current_price;
                    $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                    $this->createOrderDetails($insertedOrderID['id'], $product_id, $amount, $discount_amount, $value['qty']);

                    $oldQty = Product::find($product_id)->quantity;
                    $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                }
            }
            else {

                if ($validator_receiver->fails()) {
                    //dd($validator->errors());
                    return redirect()->back()->withErrors($validator_receiver->errors())->withInput();
                }
                if ($info['payment-check'] == 'user_pay') {
                    //echo 'Đặt hàng cho người khác và thanh toán';
                    $this->createOrders($insertedUserID['id'], $info['receiver-phone'], $info['receiver-address'], $sessionUser['user_address']);
                    $insertedOrderID = Order::where('user_id', $insertedUserID['id'])->orderBy('id', 'desc')->first();

                    foreach ($cart->items as $product_id => $value) {
                        $amount = $value['qty'] * $value['item']->current_price;
                        $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                        $this->createOrderDetails($insertedOrderID['id'], $product_id, $amount, $discount_amount, $value['qty']);

                        $oldQty = Product::find($product_id)->quantity;
                        $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                    }
                }

                if ($info['payment-check'] == 'receiver_pay') {
                    //echo 'Chỉ đặt hàng, người nhận hàng thanh toán';
                    $this->createOrders($insertedUserID['id'], $info['receiver-phone'], $info['receiver-address'], $info['receiver-address']);
                    $insertedOrderID = Order::where('user_id', $insertedUserID['id'])->orderBy('id', 'desc')->first();

                    foreach ($cart->items as $product_id => $value) {
                        $amount = $value['qty'] * $value['item']->current_price;
                        $discount_amount = $value['qty'] * $value['item']->current_price * $value['item']->discount_percent;
                        $this->createOrderDetails($insertedOrderID['id'], $product_id, $amount, $discount_amount, $value['qty']);

                        $oldQty = Product::find($product_id)->quantity;
                        $this->updateQuantityProducts($product_id, ($oldQty - $value['qty']));
                    }
                }
            }
        }

        $request->session()->forget('cart');
        /*$c = $request->session()->get('cart');
        dd($c);*/

        return redirect()->route('homepage')->with('success', 'Đặt hàng thành công!');
    }

    private function createSessionUser($request, $name, $address, $phone, $email)
    {
        $u = array();
        $u['user_name'] = $name;
        $u['user_address'] = $address;
        $u['user_phone'] = $phone;
        $u['user_email'] = $email;
        $request->session()->put('user', $u);
    }

    private function createUsers($name, $address, $phone, $email)
    {
        $dataUser = [
            'username' => str_replace(' ', '', $phone),
            'password' => sha1(str_replace(' ', '', $phone)),
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
        ];
        User::insert($dataUser);
    }

    private function createOrders($userId, $phoneReceiver, $shipAddress, $billAddress)
    {
        $dataOrder = [
            'user_id' => $userId,
            'order_date' => now(),
            'phone_receiver' => $phoneReceiver,
            'ship_address' => $shipAddress,
            'billing_address' => $billAddress,
            'status' => 'Đang xữ lý',
        ];
        Order::insert($dataOrder);
    }

    private function createOrderDetails($orderId, $productId, $amount, $discountAmount, $quantity)
    {
        $dataOrderDetail = [
            'order_id' => $orderId,
            'product_id' => $productId,
            'amount' => $amount,
            'discount_amount' => $discountAmount,
            'quantity' => $quantity,
        ];
        OrderDetail::insert($dataOrderDetail);
    }

    private function updateQuantityProducts($productID, $qty) {
        Product::where('id', $productID)->update(['quantity' => $qty]);
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
