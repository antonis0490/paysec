<?php
namespace Omnipay\Paysec\Message;

use Omnipay\Common\Message\AbstractResponse;
use Cake\Utility\Xml;

class StatusCallback extends AbstractResponse
{

    const STATUS_SUCCESSFUL = 'success';
    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';

    /**
     * Construct a StatusCallback with the respective POST data.
     *
     * @param array $post post data
     */
    public function __construct(array $post)
    {
        $this->data = $post;
    }


    public function isSuccessful()
    {
        return  ($this->getStatus() == self::STATUS_SUCCESSFUL);
    }

    public function isPending()
    {
        return  ($this->getStatus() == self::STATUS_PENDING || $this->getStatus() == self::STATUS_SENT);
    }

    public function getStatus()
    {
        return mb_strtolower($this->data['status']);
    }

    public function getMessage()
    {
        return $this->data['status'].$this->data['statusMessage'];
    }

    public function getCardMask()
    {
        return $this->data['card_num'];
    }

    public function getCardHolder()
    {
        return $this->data['card_holder'];
    }

    public function IdFilled(){
        return ($this->data['cartId'] != '' ? true : false);
    }

    /**
     * @param $wallet
     * @param $secret
     * @return string
     */
    public function getResponseChecksum($wallet, $secret)
    {
        $concat = $this->data["cartId"].";". $this->data["orderAmount"].";". $this->data["currency"].";";
        $concat .= $wallet.";".$this->data["version"].";".$this->data["status"];
        $concat = hash("sha256", $concat);
        $sign = crypt($concat, $secret);
        $pos = mb_strpos($sign, $secret) + mb_strlen($secret);
        $signature = mb_substr($sign, $pos);
        return $signature;
    }

    /**
     * @param $wallet
     * @param $secret
     * @return bool
     */
    public function ValidSignature($wallet, $secret){
        $concat = $this->getResponseChecksum($wallet, $secret);
        $valid = mb_strtolower($concat) == mb_strtolower($this->data["signature"]);
        return $valid;
    }

}
