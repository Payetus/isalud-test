<?php

namespace App\Parsers;

use App\Parsers\IJsonParseable;

/**
 * Class parses unserialized json strings
 */
class JsonParser
{
    /**
     * Parses jsonString to array of objects
     * @param  string         $jsonString
     * @param  IJsonParseable $parseable  Object with the information on how to map json to object
     * @return array                      array of parsed objects
     */
    public function parse(string $jsonString, IJsonParseable $parseable): array
    {
        $result = [];
        $jsonObject = json_decode($jsonString);
        foreach ($jsonObject as $value) {
            $result[] = $parseable->jsonObjectToObject($value);
        }
        return $result;
    }
}
