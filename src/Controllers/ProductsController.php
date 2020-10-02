<?php

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends BaseController
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function addProduct(Request $request, Response $response)
    {
        if (!isAuthenticated($request))
            return $this->unauthorised($response);

        [$product, $error] = $this->productRepository
            ->addProduct($this->requestBodyToJson($request), $request);

        return ($error == null) ?
            response($response, $product, Response::HTTP_CREATED) :
            response($response, $error, $error['code']);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function addToCart(Request $request, Response $response)
    {
        if (!isAuthenticated($request))
            return $this->unauthorised($response);

        [$product, $error] = $this->productRepository
            ->addToCart($this->requestBodyToJson($request), $request);

        return ($error == null) ?
            response($response, $product, Response::HTTP_CREATED) :
            response($response, $error, $error['code']);
    }

}