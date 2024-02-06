<?php

use App\Cart;

// model
use Modules\Frames\Entities\StickableFrame;

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
        }

        return $cart;
    }
}