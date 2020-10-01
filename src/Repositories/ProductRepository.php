<?php


namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
{
    private $entityManager;

    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

    /**
     * @param $productDetails
     * @return array
     */
    public function addProduct($productDetails)
    {
        [$_, $error] = validateProductCreationInput($productDetails);

        if ($error) return [null, $error];

        try {
            $product = new Product();

            $product = $product->setName($productDetails['name'])
                ->setDescription($productDetails['description'])
                ->setPrice($productDetails['price'])
                ->setUser($this->getUser($productDetails['userId']))
                ->setImageUrl($productDetails['imageUrl']);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return [$product->toArray(), null];
        } catch (OptimisticLockException $e) {
            return [null, $e];
        } catch (ORMException $e) {
            return [null, $e];
        }
    }

    /**
     * @param $productDetails
     * @return array
     */
    public function addToCart($productDetails)
    {
        [$_, $error] = validateAddToCartInput($productDetails);

        if ($error) return [null, $error];

        try {
            $cart = new Cart();

            $cart->setProduct($this->getProduct($productDetails['productId']));
            $cart->setUser($this->getUser($productDetails['userId']));

            $this->entityManager->persist($cart);
            $this->entityManager->flush();

            return [$cart->toArray(), null];
        } catch (OptimisticLockException $e) {
            return [null, $e];
        } catch (ORMException $e) {
            return [null, $e];
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public function getUserCart($userId)
    {
        try {
            $cart = $this->getUser($userId)->getCart();

            dd(json_encode($cart));
            return [$cart, null];
        } catch (OptimisticLockException $e) {
            return [null, $e];
        } catch (ORMException $e) {
            return [null, $e];
        }
    }

    public function getProducts()
    {
        try {
            $products = $this->getAllProducts();

            return [toArray($products), null];
        } catch (OptimisticLockException $e) {
            return [null, $e];
        } catch (ORMException $e) {
            return [null, $e];
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public function checkout($cart)
    {
//        try {
//            $cart = $this->getCartBy('userId', $userId);
//
//            return [toArray($cart), null];
//        } catch (OptimisticLockException $e) {
//            var_dump($e);
//        } catch (ORMException $e) {
//            var_dump($e);
//        }
    }
}
