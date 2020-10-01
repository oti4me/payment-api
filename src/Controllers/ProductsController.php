<?php


namespace App\Controllers;

use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductsController
 * @package App\Controllers
 */
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
            return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        $productDetails = array_merge($this->requestBodyToJson($request), ['userId'=>$request->user->id]);

        [$product, $error] = $this->productRepository->addProduct($productDetails);

        if ($error) return response($response, $error, $error['code']);

        return response($response, $product, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function addToCart(Request $request, Response $response)
    {
        if (!isAuthenticated($request)) return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        $userDetails = array_merge($this->requestBodyToJson($request), ['userId' => $request->user->id]);

        [$product, $error] = $this->productRepository->addToCart($userDetails);

        if ($error) return response($response, $error, $error['code']);

        return response($response, $product, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function viewCart(Request $request, Response $response)
    {
        if (!isAuthenticated($request)) return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        [$cart, $error] = $this->productRepository->getUserCart($request->user->id);

        if ($error) return response($response, $error, $error['code']);

        return response($response, $cart, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function checkout(Request $request, Response $response)
    {
        if (!isAuthenticated($request)) return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        $useCart = $this->productRepository->getUserCart($request->user->id);

        [$cart, $error] = $this->productRepository->checkout($useCart);

        if ($error) return response($response, $error, $error['code']);

        return response($response, $cart, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function getProducts(Request $request, Response $response)
    {
        if (!isAuthenticated($request)) return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        [$products, $error] = $this->productRepository->getProducts($request->user->id);

        if($error) return response($response, $error, $error['code']);

        return response($response, $products, Response::HTTP_OK);
    }

}