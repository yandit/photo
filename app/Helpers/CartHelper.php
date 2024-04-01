<?php

use App\Cart;

// model
use Modules\Frames\Entities\StickableFrame;
use App\CartCheckout;

if (!function_exists('cart')) {
    
    /**
     * Handle cart.
     *
     * @return App\Cart
     */
    function cart()
    {
        $session_id = session()->getId();

        // default initial frame value
        $default_frame = StickableFrame::first();

        // find cart by session_id & status on-progress
        $cart = Cart::where(['session_id'=> $session_id, 'status'=> 'on-progress'])->first();

        // if it doesn't exists create new cart
        if(!$cart){
            $cart = Cart::create(['session_id'=> $session_id, 'status'=> 'on-progress', 'frames_stickable_id'=> $default_frame->id]);
            
            // fill new cart checkout data with the old cart checkout data
            $old_cart = Cart::where(['session_id'=> $session_id, 'status'=> 'finish'])->orderBy('created_at', 'desc')->first();
            if($old_cart){
                $old_cart_checkout = $old_cart->cart_checkout;
                $cart_checkout = new CartCheckout;
                $cart_checkout->cart_id = $cart->id;
                $cart_checkout->name = $old_cart_checkout->name;
                $cart_checkout->address = $old_cart_checkout->address;
                $cart_checkout->email = $old_cart_checkout->email;
                $cart_checkout->save();

            }
        }

        return $cart;
    }
}