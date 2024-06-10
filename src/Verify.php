<?php

namespace Alirezax5\Zarinpal;
class Verify
{
    private $merchantId;

    /** @var int */
    private $amount;
    private $zarinpalUrl = 'https://{node}.zarinpal.com/pg/services/WebGate/wsdl';
    /** @var string */
    /** @var string */
    private $authority;
    private $node;
    private $sandBox = false;

    public function __construct(string $merchantId, int $amount,$node = 'ir')
    {
        $this->merchantId = $merchantId;
        $this->amount = $amount;
        $this->node = $node;

    }

    public function send()
    {
        $data = [
            'MerchantID' => $this->merchantId,
            'Amount' => $this->amount,
            'Authority' => $this->authority,
        ];
        $jsonData = json_encode($data);
        $node = ($this->sandBox == true) ? 'sandbox' : $this->node;
        $client = new \SoapClient(strtr($this->zarinpalUrl, ['{node}' => $node]), ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification($data);

        $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
        $RefID = (isset($result->RefID) && $result->RefID != "") ? $result->RefID : "";
        $Message = (new ErrorMessage($Status, '', '', false))->msg();


        return [
            "status" => $Status,
            "message" => $Message,
            "refID" => $RefID,
        ];
    }
    public function sandbox(): self
    {
        $this->sandBox = true;
        return $this;

    }
    public function authority(string $authority): self
    {
        $this->authority = $authority;

        return $this;
    }
}