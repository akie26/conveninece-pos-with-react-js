<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();  
        if (request()->wantsJson()){
            return ProductResource::collection($products);
        }
        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        if($request->hasFile('image')){
            // Get filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload
            $path = $request->file('image')->storeAs('public/image', $fileNameToStore);
        }else{
            $fileNameToStore= 'noimage.jpg';
        }
        
        //CREATE products
        $product = new Products;
        $product->name = $request->input('name');
        $product->info = $request->input('info');
        $product->barcode = $request->input('barcode');
        $product->price= $request->input('price');
        $product->image= $fileNameToStore;
        $product->quantity = $request->input('quantity');
        if($request->hasFile('image')){
            $product->image = $fileNameToStore;
        }
        $product->save();

        return redirect('admin/products')->with('success', 'PRODUCT ADDED!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Products::find($id);
        return view('products.edit')->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $this->validate($request,[
            'name' => 'required',
            'info' => 'required'
        ]);

            $products = Products::find($id);

        if($request->hasFile('image')){
            // Get filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload
            $path = $request->file('image')->storeAs('public/image', $fileNameToStore);
            Storage::delete('public/image/'.$products->image);
        }else{
            $fileNameToStore= 'noimage.jpg';
        }
        
        //UPDATE products
        $product = Products::find($id);
        $product->name = $request->input('name');
        $product->info = $request->input('info');
        $product->barcode = $request->input('barcode');
        $product->price= $request->input('price');
        $product->quantity = $request->input('quantity');
        if($request->hasFile('image')){
            $product->image = $fileNameToStore;
        }
        $product->save();

        return redirect('/admin/products')->with('success', 'PRODUCT UPDATED!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products, $id)
    {
        $products = Products::find($id);
        if ($products->image) {
            Storage::delete('public/image/'.$products->image);
        }
        $products->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
