<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Products;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index()
    {
        $product = Products::all();
        return view('cart/barcode')->with('products', $product);
    }

}
