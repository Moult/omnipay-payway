<?php

namespace Omnipay\Payway\Message;

class PurchaseRequest extends AbstractRequest
{
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

    public function getData()
    {
        $this->validate('amount');
        $this->getCard()->validate();

        $data = array();

        $data['order.type'] = 'capture';
        $data['customer.username'] = $this->getUsername();
        $data['customer.password'] = $this->getPassword();
        $data['customer.merchant'] = $this->getMerchant();
        $data['customer.orderNumber'] = $this->getTransactionId();
        $data['customer.originalOrderNumber'] = $this->getTransactionId();

        $card = $this->getCard();
        $data['card.PAN'] = $card->getNumber();
        $data['card.CVN'] = $card->getCvv();
        $data['card.expiryYear'] = $card->getExpiryDate('Y');
        $data['card.expiryMonth'] = $card->getExpiryDate('m');

        $data['card.currency'] = $this->getCurrency();
        $data['order.amount'] = $this->getAmountInteger();
        $data['order.ECI'] = 'SSL';

        return $data;
    }

    public function sendData($data)
    {
        var_dump('data');
        die();
        $orderNumber = $data['customer.orderNumber'];

        $this->url = 'https://ccapi.client.qvalent.com/payway/ccapi';
        $ch = curl_init( $this->url );
        curl_setopt( $ch, CURLOPT_POST,true );
        curl_setopt( $ch, CURLOPT_FAILONERROR, true );
        curl_setopt( $ch, CURLOPT_FORBID_REUSE, true );
        curl_setopt( $ch, CURLOPT_FRESH_CONNECT, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );

        curl_setopt( $ch, CURLOPT_SSLCERT, TODO );
        curl_setopt( $ch, CURLOPT_CAINFO, TODO );

        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );

        $responseText = curl_exec($ch);
        $errorNumber = curl_errno( $ch );

        curl_close( $ch );

        return $responseText;


        return $this->response = new Response($this, $data);
    }
}
