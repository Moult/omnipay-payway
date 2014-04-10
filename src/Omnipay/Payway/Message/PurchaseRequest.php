<?php

namespace Omnipay\Payway\Message;

use Omnipay\Common\Message\RequestInterface;

class PurchaseRequest extends AbstractRequest implements RequestInterface
{
    protected $url = 'https://ccapi.client.qvalent.com/payway/ccapi';

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
        $data['card.expiryYear'] = $card->getExpiryDate('y');
        $data['card.expiryMonth'] = $card->getExpiryDate('m');
        $data['card.cardHolderName'] = $card->getFirstName().' '.$card->getLastName();

        $data['card.currency'] = $this->getCurrency();
        $data['order.amount'] = $this->getAmountInteger();
        $data['order.ECI'] = 'SSL';

        return $data;
    }

    public function sendData($data)
    {
        $options = array(
            'timeout' => 60,
            'connect_timeout' => 60,
            'cert' => $this->getCertificate()
        );

        $request = $this->httpClient->post($this->url, NULL, $data, $options);
        $request->getCurlOptions()
            ->set('CURLOPT_FORBID_REUSE', TRUE)
            ->set('CURLOPT_FRESH_CONNECT', TRUE);

        $response = $request->send();
        parse_str((string) $response->getBody(), $responseData);

        return $this->response = new Response($this, $responseData);
    }
}
