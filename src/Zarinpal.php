<?php

namespace Alirezax5\Zarinpal;


class Zarinpal
{

    /** @var string */
    private $merchantId;

    /** @var int */
    private $amount;

    public function amount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function merchantId(string $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function request($node = 'www'): Request
    {
        return new Request($this->merchantId, $this->amount,$node);
    }

    public function verification($node = 'www'): Verify
    {
        return new Verify($this->merchantId = $this->merchantId, $this->amount,$node);
    }

}