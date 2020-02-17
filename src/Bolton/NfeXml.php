<?php

namespace Bolton;

class NfeXml {
    private $xml;

    public function __construct(Object $xml)
    {
        $this->xml = $xml;
    }

    public function getNfeTotalValue(): float
    {
        $nfe = $this->getNfeInfo();

        return (float) $nfe->total->ICMSTot->vNF;
    }

    public function getNfeInfo()
    {
        if (isset($this->xml->infNFe)) {
            return $this->xml->infNFe;
        }

        return $this->xml->NFe->infNFe;
    }
}
