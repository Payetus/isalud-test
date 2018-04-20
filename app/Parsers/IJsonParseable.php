<?php

namespace App\Parsers;

use App\Client;

/**
 *
 */
interface IJsonParseable
{
    public function jsonObjectToObject($jsonObject);
}
