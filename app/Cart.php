<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Cart //extends Model
{
    public $items = null;
    //public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart) {
            $this->items = $oldCart->items;
            //$this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($id, $item) {
        $price = $item->current_price - ($item->current_price * $item->discount_percent);
        $storeItem = ['qty'=>0, 'amount'=>$price, 'item'=>$item];
        if($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storeItem = $this->items[$id];
            }
        }
        $storeItem['qty']++;
        $storeItem['amount'] = $price * $storeItem['qty'];
        $this->items[$id] = $storeItem;
        //$this->totalQty++;
        $this->totalPrice += $price;
    }

    public function remove($id, $qty) {
        $price = $this->items[$id]['item']->current_price - ($this->items[$id]['item']->current_price * $this->items[$id]['item']->discount_percent);
        $this->totalPrice -= $qty * $price;
        unset($this->items[$id]);
    }

    public function update($id, $qty) {
        $price = $this->items[$id]['item']->current_price - ($this->items[$id]['item']->current_price * $this->items[$id]['item']->discount_percent);
        $this->totalPrice -= $this->items[$id]['qty'] * $price; //tổng tiền khi chưa có sản phẩm với product id = $id
        $this->items[$id]['qty'] = $qty; // cập nhật lại số lượng sản phẩm
        $this->totalPrice += $this->items[$id]['qty'] * $price; //cập nhật lại tổng tiền
    }
}
