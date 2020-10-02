<?php


namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Exception;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository
{
    /**
     * @param $productDetails
     * @param $request
     * @return array
     */
    public function addProduct($productDetails, $request)
    {
        [$_, $error] = validateProductCreationInput($productDetails);

        if ($error) return [null, $error];

        try {
            $product = User::find($request->user->id)
                ->products()
                ->save(new Product([
                    'name' => $productDetails['name'],
                    'description' => $productDetails['description'],
                    'price' => $productDetails['price'],
                    'image_url' => $productDetails['image_url'],
                ]));

            return [$product->toArray(), null];
        } catch (Exception $e) {
            return [null, $e];
        }
    }

    /**
     * @param $productDetails
     * @return array
     */
    public function addToCart($productDetails, $request)
    {
        [$_, $error] = validateAddToCartInput($productDetails);

        if ($error) return [null, $error];

        try {
            $cart = User::find($request->user->id)
                ->carts()
                ->save(new Cart(['product_id' => $productDetails['product_id']]));

            return [$cart->toArray(), null];
        } catch (Exception $e) {
            return [null, $e];
        }
    }
}
