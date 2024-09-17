<?php

namespace App\Repositories\Cart;
use App\Models\Cart;
use App\Models\Product;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    public function get()
    {
        return Cart::where('cookie_id', $this->getCookieId())->get();
    }

    public function add(Product $product, $cookie_id, $quantity = 1)
    {
        $item = Cart::create([
            'cookie_id' => $this->getCookieId($cookie_id),
            'user_id' => Auth::id(),   // IF USER AUTH THEN WILL RETUTN id VALUE
            'product_id' => $product->id,
            'quatity' => $quantity
        ]);

        return $item;
    }

    public function update(Product $product, $quantity)
    {
        Cart::where('cookie_id', $this->getCookieId())
            ->where('product_id', $product->id)
            ->update([
                'quantity' => $quantity
            ]);
    }

    public function delete(Product $product)
    {
        Cart::where('cookie_id', $this->getCookieId())
            ->where('product_id', $product->id)
            ->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id', $this->getCookieId())->delete();
    }

    public function total()
    {
        return Cart::where('cookie_id', $this->getCookieId())
            ->join('products', 'product.id', '=', 'carts.product_id')
            ->selectRaw('SUM(product.price * carts.quantity) as total')
            ->value('total');
    }

    protected function getCookieId($cookie_id)
    {
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
        }
        return $cookie_id;
    }

}