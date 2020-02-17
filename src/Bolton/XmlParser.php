<?php

namespace Bolton;

class XmlParser {
    public function parseBase64(String $encoded)
    {
        $xmlString = base64_decode($encoded);
        $xml = simplexml_load_string($xmlString);
        $xmlArray = json_decode(json_encode($xml), true);
        return $xmlArray;
    }
}
