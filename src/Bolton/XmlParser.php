<?php

namespace Bolton;

class XmlParser {
    public function parseBase64(String $encoded): NfeXml
    {
        $xmlString = base64_decode($encoded);
        $xml = simplexml_load_string($xmlString);
        $xmlObject = json_decode(json_encode($xml));
        return new NfeXml($xmlObject);
    }
}
