<?php

namespace App\Parsers;

use App\Parsers\IJsonParseable;

/**
 *
 */
class JsonParser
{
    public function parse(string $jsonString, IJsonParseable $parseable)
    {
        $result = [];
        $jsonObject = json_decode($jsonString);
        foreach ($jsonObject as $value) {
            $result[] = $parseable->jsonObjectToObject($value);
        }
        return $result;
    }
}
