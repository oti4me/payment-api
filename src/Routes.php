<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controllers\WelcomeController;
use Symfony\Component\HttpFoundation\Response;


class Routes
{
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var JsonResponse
     */
    private JsonResponse $response;

    /**
     * Routes constructor.
     * @param Request $request
     * @param JsonResponse $response
     */
    public function __construct(Request $request, JsonResponse $response) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Registers route handlers for Request GET method
     *
     * @return  void
     */
    public function registerHandlers() {
        switch($this->request->getMethod()) {
            case 'GET':
                $this->registerGet($this->request, $this->response);
                break;
            case 'POST':
                $this->registerPost($this->request, $this->response);
                break;
            default:
                $this->response->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED)->send();
        }
    }

    /**
     * Registers route handlers for Request GET method
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    private function registerGet(Request $request, JsonResponse $response) {
        switch($this->request->getPathInfo()) {
            case '/':
                (new WelcomeController())->index($request, $response);
                break;
            default:
                $this->notFound($request, $response);;
        }
    }

    /**
     * Registers route handlers for Request GET method
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    private function registerPost(Request $request, JsonResponse $response) {
        switch($request->getPathInfo()) {
            case '/':
                $response->setData(['message' => 'post request to /'])->send();;
                break;
            default:
                $this->notFound($request, $response);

        }
    }

    /**
     * Sends a not found response to the client
     *
     * @param Request $request
     * @param JsonResponse $response
     */
    private function notFound(Request $request, JsonResponse $response) {
        $response->setStatusCode(Response::HTTP_NOT_FOUND)
            ->setData([
                'status' => 'Failure',
                'message' => 'Resource '. $request->getMethod() . ':' . $request->getPathInfo() .' not found']
            )->send();
    }


}