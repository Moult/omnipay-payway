<?php

namespace Omnipay\Payway\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\ResponseInterface;

class Response extends AbstractResponse implements ResponseInterface
{
    public function isSuccessful()
    {
        return $this->data['response_summaryCode'] == 0;
    }

    public function isRedirect()
    {
        return FALSE;
    }

    public function getTransactionReference()
    {
        return $this->data['response_receiptNo'];
    }

    public function getMessage()
    {
        return $this->data['response_text'];
    }

    public function getResponseCode()
    {
        return $this->data['response_responseCode'];
    }
}
