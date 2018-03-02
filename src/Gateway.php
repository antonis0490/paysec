<?php

namespace Omnipay\Paysec;

use Omnipay\Common\AbstractGateway;

/**
 * Paysec Gateway
 *
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Paysec';
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
    

    /**
     * @param array $parameters
     * @return \Omnipay\Paysec\Message\PaymentRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paysec\Message\PaymentRequest', $parameters);
    }

}
