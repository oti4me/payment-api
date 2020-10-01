<?php


namespace App\Repositories;


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
    protected function getUser($userId) {
        return getEntityManager()->getRepository('\\App\Models\\User')
            ->find($userId);
    }

    /**
     * @param $productId
     * @return object|null
     */
    protected function getProduct($productId) {
        return getEntityManager()->getRepository('\\App\Models\\Product')
            ->find($productId);
    }

    /**
     * @param $productId
     * @return object|null
     */
    protected function getAllProducts() {
        return getEntityManager()->getRepository('\\App\Models\\Product')
            ->findAll();
    }

    /**
     * @param $cartId
     * @return object|null
     */
    protected function getCart($cartId) {
        return getEntityManager()->getRepository('\\App\Models\\Cart')
            ->find($cartId);
    }

    /**
     * @param $column
     * @param $cartId
     * @return object|null
     */
    protected function getCartBy($column, $cartId) {
        return getEntityManager()->getRepository('\\App\Models\\Cart')
            ->findBy([
                $column => $cartId
            ]);
    }
}