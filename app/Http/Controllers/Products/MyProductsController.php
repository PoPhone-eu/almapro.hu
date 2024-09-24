<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public.myproducts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $attr_type = $request->attr_type;
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        return view('public.myproducts.create', compact('attr_type', 'category_id', 'subcategory_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product == null) {
            return redirect()->back();
        }
        $product_id = $product->id;
        return view('public.myproducts.edit', compact('product_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // myfavorites table
    public function myfavorites()
    {
        return view('public.myfavorites.index');
    }
}
