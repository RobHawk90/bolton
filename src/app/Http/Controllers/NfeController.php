<?php

namespace App\Http\Controllers;

use App\Nfe;

class NfeController extends Controller
{
    public function find(String $key)
    {
        $nfe = Nfe::findByAccessKey($key);

        if (empty($nfe)) {
            return response()->json([
                'data' => [
                    'message' => "Nenhuma NFe com a chave '$key' foi encontrada.",
                ],
            ], 404);
        }

        return response()->json([
            'data' => [
                'key' => $nfe->access_key,
                'value' => $nfe->total_value,
            ]
        ], 200);
    }
}
