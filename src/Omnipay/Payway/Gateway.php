<?php

namespace Omnipay\Payway;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\GatewayInterface;

class Gateway extends AbstractGateway implements GatewayInterface
{
    public function getName()
    {
        return 'Westpac PayWay';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'merchant' => ''
        );
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($username)
    {
        return $this->setParameter('username', $username);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }

    public function getMerchant()
    {
        return $this->getParameter('merchant');
    }

    public function setMerchant($merchant)
    {
        return $this->setParameter('merchant', $merchant);
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($certificate)
    {
        return $this->setParameter('certificate', $certificate);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Payway\Message\PurchaseRequest', $parameters);
    }
}
