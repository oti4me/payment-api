<?php


namespace App\Repositories;

use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Exception;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
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

    /**
     * @param $paymentDetails
     * @param $request
     * @return array
     */
    public function updatePayment($paymentDetails, $request)
    {
        $Ids = $paymentDetails
            ->metadata
            ->custom_fields
            ->ids;

        $productIds = array_column($Ids, 'productIds');

        try {
            $payment = Payment::create([
                'user_id'           => $request->user->id,
                'transaction_id'    => $paymentDetails->id,
                'reference'         => $paymentDetails->reference,
                'amount'            => $paymentDetails->amount,
                'payment_type'      => $paymentDetails->channel,
                'currency'          => $paymentDetails->currency,
                'customer_id'       => $paymentDetails->customer->id,
                'product_ids'       => implode(',', $productIds)
            ]);

          $carts = $this->getCartsByIds('id', array_column($Ids, 'cartIds'));

            foreach ($carts as $cart) {
                $cart->delete();
            }

            return [$payment->toArray(), null];
        } catch (Exception $e) {
            [null, $e];
        }
    }
}
