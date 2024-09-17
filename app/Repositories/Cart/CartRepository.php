<?php

namespace App\Repositories\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

interface CartRepository
{
    public function get();

    public function add(Product $product, $cookie_id, $quantity = 1);

    public function update(Product $product, $quantity);

    public function delete(Product $product);

    public function empty();

    public function total();
}