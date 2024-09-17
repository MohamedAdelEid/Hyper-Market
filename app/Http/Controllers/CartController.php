<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        $items = $cart->get();

        return $this->successResponse($items, 'items retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        try {
            $request->validate([
                'product_id' => 'required|int|exists:products,id|unique:carts,product_id',
                'cookie_id' => 'nullable',
                'quantity' => 'nullable|int|min:1',
            ], [
                'product_id.unique' => 'This product is already in your cart.',
            ]);

            $product = Product::findOrFail($request->product_id);
            if ($product->quantity < $request->quantity) {
                return $this->errorResponse('This product is not available in this quantity.', 400);
            }

            $item = $cart->add($product, $request->cookie_id, $request->quantity);

            return $this->successResponse($item, 'items retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
