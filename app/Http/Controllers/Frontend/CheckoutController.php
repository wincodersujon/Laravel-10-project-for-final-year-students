<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Session;
use Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public  function index()
    {
        return view('frontend/checkout/index');
    }

    //stripe payment methods

    public function stripe($totalprice)
    {
        return view('frontend.checkout.stripe',compact('totalprice'));
    }

    public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" =>$totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment."
        ]);

        // $user=Auth::user();
        // $userid=$user->id;
        // $data=Cart::where('user_id','=',$userid)->get();

        // foreach( $data as $data)
        // {
        //  $order=new Order;
        //  $order->name=$data->name;
        //  $order->email=$data->email;
        //  $order->phone=$data->phone;
        //  $order->address=$data->address;
        //  $order->user_id=$data->user_id;
        //  $order->product_title=$data->product_title;
        //  $order->price=$data->price;
        //  $order->quantity=$data->quantity;
        //  $order->image=$data->image;
        //  $order->product_id=$data->product_id;

        //  $order->payment_status='paid';
        //  $order->delivery_status='processing';

        //  $order->save();

        //  $cart_id=$data->id;
        //  $cart=Cart::find($cart_id);
        //  $cart->delete();

        // }

        //return back()->with('message', 'Card Payment Successfully');
        Session::flash('success', 'Payment successful!');
        return redirect()->to('thankyou');
    }
}

