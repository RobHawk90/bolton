<?php

namespace Bolton\Entity;

class Nfe implements Entity
{
    private $accessKey;
    private $totalValue;

    public function __construct(String $accessKey, float $totalValue)
    {
        $this->accessKey = $accessKey;
        $this->totalValue = $totalValue;
    }

    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    public function getTotalValue(): float
    {
        return $this->totalValue;
    }

    public function toJson(): String
    {
        return json_encode($this->toArray());
    }

    public function toArray(): Array
    {
        return [
            'key' => $this->accessKey,
            'value' => $this->totalValue,
        ];
    }
}
