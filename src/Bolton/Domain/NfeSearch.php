<?php

namespace Bolton\Domain;

use Bolton\Repository\NfeRepository;
use Bolton\Util\Response;

class NfeSearch
{
    private $repository;
    private $response;

    public function __construct(NfeRepository $repository, Response $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function byAccessKey($key): NfeSearch
    {
        $nfe = $this->repository->findByAccessKey($key);
        if (!empty($nfe)) {
            $this->response->setData($nfe);
        }
        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
