<?php

namespace Bolton;

use Bolton\Rest\Api\ArquiveiApi;
use App\Nfe;

class ImportNfe
{
    public function importAll()
    {
        $api = new ArquiveiApi();
        $xmlParser = new XmlParser();

        Nfe::truncate();

        $this->recursiveFetchNfe($api, $xmlParser);
    }

    public function recursiveFetchNfe(ArquiveiApi $api, XmlParser $xmlParser, String $next = '')
    {
        $response = $api->nfeReceived($next);

        if (empty($response)) {
            return;
        }

        $batch = $this->mapToInsertBatch($response->data, $xmlParser);

        Nfe::insert($batch);

        if ($response->count > 0) {
            return $this->recursiveFetchNfe($api, $xmlParser, $response->page->next);
        }
    }

    public function mapToInsertBatch(Array $items, XmlParser $xmlParser)
    {
        $batch = [];
        foreach ($items as $item) {
            $batch[] = $this->getAccessKeyAndTotalValue($item, $xmlParser);
        }
        return $batch;
    }

    public function getAccessKeyAndTotalValue(Object $item, XmlParser $xmlParser)
    {
        return [
            'access_key' => $item->access_key,
            'total_value' => $this->getTotalValue($item->xml, $xmlParser)
        ];
    }

    public function getTotalValue(String $xmlEncoded, XmlParser $xmlParser)
    {
        $nfe = $xmlParser->parseBase64($xmlEncoded);

        $infNFe = $this->getNfeInfo($nfe);

        return $infNFe['total']['ICMSTot']['vNF'];
    }

    public function getNfeInfo(Array $nfe)
    {
        if (isset($nfe['infNFe'])) {
            return $nfe['infNFe'];
        }

        return $nfe['NFe']['infNFe'];
    }
}
