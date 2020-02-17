<?php

namespace Bolton\Repository;

use Bolton\Entity\Nfe;

interface NfeRepository extends Repository
{
    public function clear(): void;

    public function saveAll(Array $nfeBatch): void;

    public function findByAccessKey(String $accessKey): ?Nfe;
}
