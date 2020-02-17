<?php

namespace Tests\Feature;

use App\Nfe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoltonApiTest extends TestCase
{
    use RefreshDatabase;

    public function testFindNfe()
    {
        Nfe::insert([
            'access_key' => '987654321',
            'total_value' => '50',
        ]);

        $response = $this->get('/api/nfe/987654321');

        $response->assertOk()
                ->assertJson([
                    'data' => [
                        'key' => '987654321',
                        'value' => '50',
                    ],
                ]);
    }

    public function testNotFound()
    {
        $response = $this->get('/api/nfe/123456789');

        $response->assertNotFound()
                ->assertJson([
                    'data' => [
                        'message' => "Nenhuma NFe com a chave '123456789' foi encontrada.",
                    ],
                ]);
    }
}
