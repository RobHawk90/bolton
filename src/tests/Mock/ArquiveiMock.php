<?php

namespace Tests\Mock;

use Bolton\Rest\Api\Arquivei;

class ArquiveiMock implements Arquivei
{
    public function nfeReceived(String $page = ''): ?Object
    {
        return null;
    }
}

