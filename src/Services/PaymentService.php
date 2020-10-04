<?php
use Flutterwave\Card;

class PaymentService
{
    /**
     * @var Card
     */
    private Card $card;

    /**
     * PaymentService constructor.
     */
    public function __construct()
    {
        $this->card = new Card();
    }

    public function cardPayment() {

    }
}