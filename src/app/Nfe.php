<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nfe extends Model
{
    protected $table = 'nfe_imports';

    public static function findByAccessKey($accessKey)
    {
        return self::where('access_key', $accessKey)->first();
    }
}
