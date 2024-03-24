<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_details(Request $request, $slug=null)
    {
        return view('checkout.order-details', compact('slug'));
    }
}
