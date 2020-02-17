<?php

namespace Bolton\Util;

use Bolton\Entity\Entity;

class Response
{
    private $data;

    public function setData(?Entity $data): Response
    {
        $this->data = $data;

        return $this;
    }

    public function toJson(): Array
    {
        return [
            'data' => $this->data ? $this->data->toArray(): [],
        ];
    }
}
