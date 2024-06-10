<?php

namespace Alirezax5\Zarinpal;

use Alirezax5\Zarinpal\ErrorMessage;
class Request
{
    /** @var string */
    private $merchantId;

    /** @var int */
    private $amount;

    /** @var string */
    private $description;

    /** @var string */
    private $callbackUrl;

    /** @var string */
    private $mobile;

    /** @var string */
    private $email;

    /** @var string */
    private $node;
    /** @var string */
    private $zarinpalUrl = 'https://{node}.zarinpal.com/pg/services/WebGate/wsdl';
    /** @var string */
    private $zarinpalUrlPay = 'https://{node}.zarinpal.com/pg/StartPay/{Authority}';
    /** @var bool */
    private $sandBox = false;


    public function __construct(string $merchantId, int $amount, $node)
    {
        $this->merchantId = $merchantId;
        $this->amount = $amount;
        $this->node = $node;

    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function callbackUrl(string $callbackUrl): self
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    public function sandbox(): self
    {
        $this->sandBox = true;
        return $this;

    }

    public function mobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function email(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function send()
    {
        $data = [
            'MerchantID' => $this->merchantId,
            'Amount' => $this->amount,
            'Description' => $this->description,
            'CallbackURL' => $this->callbackUrl,
        ];
        $jsonData = json_encode($data);
        $node = ($this->sandBox == true) ? 'sandbox' : $this->node;
        $client = new \SoapClient(strtr($this->zarinpalUrl, ['{node}' => $node]), ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest($data);


        $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
        $Message = (new ErrorMessage($Status, $this->description, $this->callbackUrl, true))->msg();
        $Authority = (isset($result->Authority) && $result->Authority != "") ? $result->Authority : "";

        $StartPay = (isset($result->Authority) && $result->Authority != "") ? strtr($this->zarinpalUrlPay, ['{Authority}' => $Authority, '{node}' => $node]) : "";
        $StartPayUrl = ($this->sandBox == true) ? "{$StartPay}/ZarinGate" : $StartPay;


        return [
            "status" => $Status,
            "message" => $Message,
            "startPay" => $StartPayUrl,
            "authority" => $Authority
        ];
    }
}