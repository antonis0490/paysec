<?php


namespace Omnipay\Paysec\Message;

class RestPurchaseRequest extends PaymentRequest
{
    public function getData()
    {
        $data = parent::getData();
        return $data;
    }
}
