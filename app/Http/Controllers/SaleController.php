<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\SaleStoreRequest;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(SaleStoreRequest $request)
    {   
        
      
      $sale = Sale::create([
            'user_id' => $request->user()->id,
       ]);

       $cart = $request->user()->cart()->get();
       foreach($cart as $item) {
           $sale->items()->create([
            'price' => $item->price,
            'quantity' => $item->pivot->quantity,
            'products_id' => $item->id,
           ]);
           $item->quantity = $item->quantity - $item->pivot->quantity;
           $item->save();
       }
       $request->user()->cart()->detach();
       $sale->payments()->create([
           'amount' => $request->amount,
           'user_id' => $request->user()->id,
       ]);

       $request->user()->cart()->detach();
       return 'success';
    }
}
