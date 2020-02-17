<?php

namespace Bolton\Domain;

use Bolton\Entity\Nfe;
use Bolton\Repository\NfeRepository;
use Bolton\Rest\Api\Arquivei;
use Bolton\XmlParser;

class NfeImporter
{
    private $api;
    private $parser;
    private $repository;

    public function __construct(NfeRepository $repository, Arquivei $api, XmlParser $parser)
    {
        $this->api = $api;
        $this->parser = $parser;
        $this->repository = $repository;
    }

    public function importAll(): void
    {
        try {
            $this->repository->beginTransaction();

            $this->repository->clear();

            $responses = $this->recursiveFetchNfe();
            $items = $this->extractItemsFromResponses($responses);
            $parsedXmlItems = $this->mapToParsedXmlItems($items);
            $nfeItems = $this->mapToNfeItems($parsedXmlItems);
            $chunksOfNfeItems = array_chunk($nfeItems, 1000);

            $this->saveChunksOfNfeItems($chunksOfNfeItems);

            $this->repository->commit();
        } catch (\Exception $e) {
            $this->repository->rollBack();

            throw new \Exception("Something gone wrong while trying to import all NF-e (NfeImporter@importAll): {$e->getMessage()}");
        }
    }

    public function recursiveFetchNfe(String $next = '', $responses = []): Array
    {
        $response = $this->api->nfeReceived($next);

        if (empty($response) || !$response->count) {
            return $responses;
        }

        $responses[] = $response;

        return $this->recursiveFetchNfe($response->page->next, $responses);
    }

    public function extractItemsFromResponses(Array $responses): Array
    {
        $items = [];
        foreach ($responses as $response) {
            foreach ($response->data as $item) {
                $items[] = $item;
            }
        }
        return $items;
    }

    public function mapToParsedXmlItems(Array $items): Array
    {
        $parser = $this->parser;
        return array_map(function (Object $item) use ($parser) {
            $newItem = clone $item;
            $newItem->xml = $parser->parseBase64($item->xml);
            return $newItem;
        }, $items);
    }

    public function mapToNfeItems(Array $parsedXmlItems): Array
    {
        return array_map(function ($item) {
            return new Nfe(
                $item->access_key,
                $item->xml->getNfeTotalValue()
            );
        }, $parsedXmlItems);
    }

    public function saveChunksOfNfeItems($chunks): void
    {
        foreach ($chunks as $chunk) {
            $this->repository->saveAll($chunk);
        }
    }
}
