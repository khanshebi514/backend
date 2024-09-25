<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //all products
    public function index()
    {
       
        $products = Products::all();

       
        if (count($products) > 0) {
            return response()->json([
                'status' => 'success',
                'products' => $products
            ], 200);
        }
        
        elseif (count($products) == 0) {
            return response()->json([
                'status' => 'success',
                'products' => 'No products found'
            ], 200);
        }

        
        return response()->json([
            'status' => 'fail',
            'message' => 'Data fetching failed...!'
        ], 400);
    }
    //single product
    public function show($id)
    {

        $product = Products::find($id);


        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found!',
            ], 404);
        }


        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully!',
            'product' => $product,
        ], 200);
    }

    //create product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku'=>'nullable|string|unique',
            'category' => 'required|in:men,women,kids',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }


        $product = Products::create($validatedData);


        return response()->json([
            'status' => true,
            'message' => 'Product added successfully!',
            'product' => $product,
        ], 201);
    }

    //update
    public function update(Request $request, $id)
    {

        $product = Products::find($id);


        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found!',
            ], 404);
        }


        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku'=>'nullable|string|unique',
            'category' => 'required|in:men,women,kids',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);


        if ($request->hasFile('image')) {

            if ($product->image) {
                \Storage::disk('public')->delete($product->image);


                $imagePath = $request->file('image')->store('products', 'public');
                $validatedData['image'] = $imagePath;
            }


            $product->update($validatedData);


            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully!',
                'product' => $product,
            ], 200);
        }
    }

    //destroy
    public function destroy($id)
    {

        $product = Products::find($id);


        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found!',
            ], 404);
        }


        if ($product->image) {
            \Storage::disk('public')->delete($product->image);


            $product->delete();


            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully!',
            ], 200);
        }
    }
}
