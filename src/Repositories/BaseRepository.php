<?php


namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;


/**
 * Class BaseRepository
 * @package App\Models
 */
class BaseRepository
{
    /**
     * @param $userId
     * @return object|null
     */
    public function getUser($userId)
    {
        return User::find($userId);
    }

    /**
     * @param $userId
     * @return array
     */
    public function getUserCart($userId)
    {
        if ($user = User::find($userId)) {
            return $user->carts()
                ->with('product')
                ->get();
        }
        return [];
    }

    /**
     * @param $productId
     * @return object|null
     */
    public function getProduct($productId)
    {
        return Product::find($productId);
    }

    /**
     * @param $productId
     * @return object|null
     */
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * @param $cartId
     * @return object|null
     */
    public function getCart($cartId)
    {
        return Cart::find($cartId);
    }

    /**
     * @param $column
     * @param $value
     * @return object|null
     */
    public function getCartBy($column, $value)
    {
        return Cart::where($column, $value)->get();
    }

    /**
     * @param $column
     * @param $values
     * @return mixed
     */
    public function getCartsByIds($column, $values)
    {
        return Cart::whereIn($column, $values)->get();
    }
}