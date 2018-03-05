<?php


namespace Omnipay\Paysec\Message;

class RestCompletePurchaseRequest extends PaymentRequest
{
    public function getData()
    {
        $data = parent::getData();
        return $data;
    }
}
