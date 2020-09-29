<?php


namespace App\Repositories;


use App\Models\Product;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ProductRepository
{
    private $entityManager;

    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        $this->entityManager = getEntityManager();
    }

    public function addProduct($productDetails){
        [$_, $error] = validateProductCreationInput($productDetails);

        if ($error) return [null, $error];

        try {
            $product = new Product();

            $product->setName($productDetails['name']);
            $product->setDescription($productDetails['description']);
            $product->setPrice($productDetails['price']);
            $product->setOwner($productDetails['owner']);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return [$product->toArray(), null];
        } catch (OptimisticLockException $e) {
            var_dump($e);
        } catch (ORMException $e) {
            var_dump($e);
        }
    }
}