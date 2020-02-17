<?php

namespace App\Http\Controllers;

use App\Nfe;
use Bolton\Domain\NfeSearch;
use Bolton\Util\Response;
use Illuminate\Support\Facades\Log;

class NfeController extends Controller
{
    public function search(String $key)
    {
        try {
            $search = new NfeSearch(new Nfe(), new Response());

            return $search
                ->byAccessKey($key)
                ->getResponse()
                ->toJson();
        } catch (\Exception $e) {
            Log::error("Something gone wrong while trying find a NF-e (NfeController@search): {$e->getMessage()}");
            throw new \Exception('An error has occurred while trying to search a NF-e');
        }
    }
}
