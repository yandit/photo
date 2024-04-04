<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CartCheckout;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_details(Request $request, $slug=null)
    {
        $cart = cart();
        if(!count($cart->uploads)){
            return redirect()->route('upload.index', ['slug'=> $slug]);
        }

        $price = $cart->frames_stickable->price;
        $uploads = $cart->uploads->count();
        $totalPrice = $price * $uploads;
        $totalPrice = number_format($totalPrice, 0, ',', '.');
        
        if($request->isMethod('post')){
            $postData = $request->all();

            CartCheckout::updateOrCreate(
                ['cart_id' => $cart->id],
                [
                    'name' => $postData['name'],
                    'email' => $postData['email'],
                    'address' => $postData['address'],
                ]
            );

            $cart->status = 'waiting-for-payment';
            $cart->save();
        }
        return view('checkout.order-details', compact('slug', 'cart', 'totalPrice'));
    }
}
