<?php

namespace App\Controllers;

use App\Repositories\ProductRepository;
use GuzzleHttp\Exception\GuzzleException;
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
            response($response, $error, is_array($error) ? $error['code'] : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function viewCart(Request $request, Response $response)
    {
        if (!isAuthenticated($request))
            return $this->unauthorised($response);

        $carts = $this->productRepository
            ->getUserCart($request->user->id);

        response($response, $carts, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function verifyPayment(Request $request, Response $response)
    {
        if (!isAuthenticated($request))
            return $this->unauthorised($response);

        [$_, $error] = validatePaymentReference($this->requestBodyToJson($request));

        if($error) return response($response, $error, Response::HTTP_BAD_REQUEST);

        $body = $this->requestBodyToJson($request);

        try {
            $res = getHttp()
                ->request(
                    'GET', 'https://api.paystack.co/transaction/verify/' . $body['reference'],
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . envGet('PAYSTACK_KEY')
                        ]
                    ])
                ->getBody()
                ->getContents();

            $res = json_decode($res);

            if($res->status == true && $res->data->status == 'success') {
                [$payment, $error] = $this->productRepository->updatePayment($res->data, $request);

                return $error ?
                    response($response, $error, Response::HTTP_BAD_REQUEST) :
                    response($response, $payment, Response::HTTP_OK);
            }

        } catch (GuzzleException $error) {
            response($response, $error->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function getProducts(Request $request, Response $response)
    {
        if (!isAuthenticated($request)) return response($response, 'Unauthorised', Response::HTTP_UNAUTHORIZED);

        $products = $this->productRepository
            ->getAllProducts($request->user->id);

        response($response, $products, Response::HTTP_OK);
    }

}
