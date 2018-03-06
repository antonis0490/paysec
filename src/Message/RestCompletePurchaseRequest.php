<?php


namespace Omnipay\Paysec\Message;

class RestCompletePurchaseRequest extends PaymentCompleteRequest
{
    public function getData()
    {
        $data = parent::getToken();
        return $data;
    }
}
