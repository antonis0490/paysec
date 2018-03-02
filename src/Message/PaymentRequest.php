<?php

namespace Omnipay\Paysec\Message;

use Cake\Utility\Xml;
use Omnipay\Common\Message\AbstractRequest;

class PaymentRequest extends AbstractRequest
{
    public $liveEndpoint = 'https://paysecure.paysec.com/Intrapay/paysec/v1/payIn/requestToken';
    protected $sandboxEndpoint = 'https://pg-staging.paysec.com/Intrapay/paysec/v1/payIn/requestToken';

    public function getEndpoint()
    {
        return ((bool)$this->getTestMode()) ? $this->sandboxEndpoint : $this->liveEndpoint;
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnURL');

    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnURL', $value);
    }

    public function getFname()
    {
        return $this->getParameter('name');

    }

    public function setFname($value)
    {
        return $this->setParameter('name', $value);
    }

    public function getLname()
    {
        return $this->getParameter('lname');

    }

    public function setLname($value)
    {
        return $this->setParameter('lname', $value);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notifyURL');

    }

    public function setNotifyUrl($value)
    {
        return $this->setParameter('notifyURL', $value);
    }


    public function getUsername()
    {
        return $this->getParameter('username');
    }


    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getNumber()
    {
        return $this->getParameter('number');
    }

    public function setNumber($value)
    {
        return $this->setParameter('number', $value);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getCartId()
    {
        return $this->getParameter('cardId');
    }

    public function setCartId($value)
    {
        return $this->setParameter('cardId', $value);
    }

    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    public function setLocale($value)
    {
        $supported = array('en', 'ru', 'zh', 'ja');
        if (!in_array($value, $supported)) {
            $value = 'en';
        }
        return $this->setParameter('locale', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('success_url');
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter('success_url', $value);
    }

    public function getDeclineUrl()
    {
        return $this->getParameter('decline_url');
    }

    public function setDeclineUrl($value)
    {
        return $this->setParameter('decline_url', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancel_url');
    }

    public function setCancelUrl($value)
    {
        return $this->setParameter('cancel_url', $value);
    }

    public function getHeaderVersion()
    {
        return $this->getParameter('header_v');
    }

    public function setHeaderVersion($value)
    {
        return $this->setParameter('header_v', $value);
    }

    public function getChannelCode()
    {
        return $this->getParameter('channelCode');
    }

    public function setChannelCode($value)
    {
        return $this->setParameter('channelCode', $value);
    }

    public function getPaysecSecret()
    {
        return $this->getParameter('paysec_secret');
    }

    public function setPaysecSecret($value)
    {
        return $this->setParameter('paysec_secret', $value);
    }

    public function getData()
    {

        $concat = $this->getCartId() . ";" . $this->getAmount() . ";" . $this->getCurrency() . ";" . $this->getUsername() . ";" . $this->getHeaderVersion();
        $concat = hash("sha256", $concat);

        $sign = crypt($concat, $this->getPaysecSecret());
        $pos = mb_strpos($sign, $this->getPaysecSecret()) + mb_strlen($this->getPaysecSecret());
        $signature = mb_substr($sign, $pos);

        $input = array
        (
            "header" => array
            (
                "version" => $this->getHeaderVersion(),
                "merchantCode" => $this->getUsername(),
                "signature" => $signature
            ),
            "body" => array
            (
                "channelCode" => "BANK_TRANSFER",
                "notifyURL" => $this->getNotifyUrl(),
                "returnURL" => $this->getReturnUrl(),
                "orderAmount" => $this->getAmount(),
                "orderTime" => (string)round(microtime(true) * 1000),
                "cartId" => $this->getCartId(),
                "currency" => $this->getCurrency(),
                "customerInfo" => array
                (
                    "address" => array
                    (
                        "email" => $this->getEmail()
                    ),
                    "cardHolderFirstName" => $this->getFname(),
                    "cardHolderLastName" => $this->getLname()
                )
            )
        );

        $encoded = json_encode($input);

        return $encoded;
    }


    public function sendData($data)
    {
        return new PaymentResponse($this, $data, $this->getEndpoint());
    }

}
