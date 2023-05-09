<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
class CheckoutShow extends Component
{
    public $carts,$totalProductAmount = 0;

    public $fullname,$email,$phone,$pincode,$address,$payment_mode = NULL,$payment_id = NULL;

    public function rules()
    {
        return [
            'fullname' =>'required|string|max:100',
            'email' =>'required|email|max:50',
            'phone' =>'required|string|max:11|min:10',
            'pincode' =>'required|string|max:6|min:6',
            'address' =>'required|string|max:400',

        ];
    }
    public function placeOrder()
    {
        $this->validate();
        $order = Order::create([
        'user_id' => Auth()->user()->id,
        'fullname' => $this->fullname ,
        'email' => $this->email,
        'phone' => $this->phone,
        'tracking_no' => 'wincoder-'.Str::random(10),
        'pincode' => $this->pincode,
        'address' => $this->address,
        'status_message' => 'in progress',
        'payment_mode' => $this->payment_mode,
        'payment_id' => $this->payment_id,
        ]);

        foreach($this->carts as $cartItem){
            $orderItems = Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_color_id' => $cartItem->product_color_id,
                'quantity' => $cartItem->quantity,
                'price' =>$cartItem->product->selling_price
            ]);
            //when order items quantity is decrement
            if( $cartItem->product_color_id !=NULL){

                $cartItem->productColor()->where('id',$cartItem->product_color_id)->decrement('quantity',$cartItem->quantity);
            }else{
                $cartItem->product()->where('id',$cartItem->product_id)->decrement('quantity',$cartItem->quantity);
            }
        }
        return $order;
    }
    public function codOrder()
    {
        $this->payment_mode = 'Cash on Delivery';
       $codOrder = $this->placeOrder();
       if($codOrder){
        Cart::where('user_id',auth()->user()->id)->delete();

        session()->flash('message', 'Order Placed Successfully');
        $this->dispatchBrowserEvent('message', [
            'text' => 'Order Placed Successfully',
            'type' => 'success',
            'status' => 200
        ]);
        return redirect()->to('thankyou');

       }else{
        $this->dispatchBrowserEvent('message', [
            'text' => 'Something went wrong',
            'type' => 'error',
            'status' => 500
        ]);
       }

    }

    public function totalProductAmount()
    {
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id',auth()->user()->id)->get();
        foreach($this->carts as $cartItem){
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;
    }
    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->totalProductAmount =$this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show',[
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}
