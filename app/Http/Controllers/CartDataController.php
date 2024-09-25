<?php

namespace App\Http\Controllers;

use App\Models\CartData;
use App\Models\Products;
use Auth;
use Illuminate\Http\Request;

class CartDataController extends Controller
{
     //show cart
     public function index()
     {
         $user = Auth::user();
 
       
         $cartItems = CartData::where('user_id', $user->id)->with('product')->get();
 
         return response()->json([
             'status' => 'success',
             'cartItems' => $cartItems
         ], 200);
     }
 
     //store products
     public function store(Request $request)
     {
         $user = Auth::user();
 
         
         $validated = $request->validate([
             'product_id' => 'required|exists:products,id',
             'quantity' => 'required|integer|min:1'
         ]);
 
         
         $cartItem = CartData::where('user_id', $user->id)
             ->where('product_id', $validated['product_id'])
             ->first();
 
         if ($cartItem) {
             $cartItem->quantity += $validated['quantity'];
             $cartItem->save();
         } else {
             CartData::create([
                 'user_id' => $user->id,
                 'product_id' => $validated['product_id'],
                 'quantity' => $validated['quantity'],
                 'price' => Products::find($validated['product_id'])->price,
                 'status' => 'active'
             ]);
         }
 
         return response()->json([
             'status' => 'success',
             'message' => 'Product added to cart successfully'
         ], 201);
     }
 
     // Update cart
     public function update(Request $request, $id)
     {
         $user = Auth::user();
 
         $validated = $request->validate([
             'quantity' => 'required|integer|min:1'
         ]);
 
         $cartItem = CartData::where('user_id', $user->id)
             ->where('id', $id)
             ->first();
 
         if (!$cartItem) {
             return response()->json([
                 'status' => 'fail',
                 'message' => 'Cart item not found'
             ], 404);
         }
 
         $cartItem->quantity = $validated['quantity'];
         $cartItem->save();
 
         return response()->json([
             'status' => 'success',
             'message' => 'Cart item updated successfully'
         ], 200);
     }

     //destory cart 
     public function destroy($id)
     {
         $user = Auth::user();
 
         $cartItem = CartData::where('user_id', $user->id)
             ->where('id', $id)
             ->first();
 
         if (!$cartItem) {
             return response()->json([
                 'status' => 'fail',
                 'message' => 'Cart item not found'
             ], 404);
         }
 
    
         $cartItem->delete();
 
         return response()->json([
             'status' => 'success',
             'message' => 'Cart item removed successfully'
         ], 200);
     }
}
