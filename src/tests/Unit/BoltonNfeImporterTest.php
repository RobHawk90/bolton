<?php

namespace Tests\Unit;

use App\Nfe;
use Bolton\Domain\NfeImporter;
use Bolton\XmlParser;
use PHPUnit\Framework\TestCase;
use Tests\Mock\ArquiveiMock;

class BoltonNfeImporterTest extends TestCase
{
    public function testExtractItemsFromResponses()
    {
        $importer = new NfeImporter(new Nfe(), new ArquiveiMock(), new XmlParser());

        $responses[] = json_decode(json_encode(['data' => [1, 2, 3]]));
        $responses[] = json_decode(json_encode(['data' => [4, 5, 6]]));

        $items = $importer->extractItemsFromResponses($responses);

        $this->assertCount(6, $items);
    }
}
