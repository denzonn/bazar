<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product.index');
    }

    public function getData()
    {
        $symptom = Product::with(['category'])->get();

        return DataTables::of($symptom)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();

        return view('pages.product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid() . "." . $extension;
            $data['photo'] = $images->storeAs('product', $file_name, 'public');
        }

        Product::create($data);

        return redirect()->route('product.index')->with('toast_success', 'Product created successfully');
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
    public function edit(string $id)
    {
        $category = Category::all();
        $data = Product::find($id);

        return view('pages.product.edit', compact('data', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $product = Product::find($id);

        if ($request->hasFile('photo')) {
            if($product->photo){
                Storage::disk('public')->delete($product->photo);
            }

            $images = $request->file('photo');
            $extension = $images->getClientOriginalExtension();
            $file_name = uniqid() . "." . $extension;
            $data['photo'] = $images->storeAs('product', $file_name, 'public');
        }

        $product->update($data);

        return redirect()->route('product.index')->with('toast_success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if($product->photo){
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->route('product.index')->with('toast_success', 'Product deleted successfully');
    }
}
