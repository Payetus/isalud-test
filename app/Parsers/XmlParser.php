<?php

namespace App\Parsers;

use App\Parsers\IXmlParseable;

/**
 * Class parses unserialized json strings
 */
class XmlParser
{
    /**
     * Parses xml string to array of objects
     * @param  string         $xmlString
     * @param  IJsonParseable $parseable  Object with the information on how to map json to object
     * @return array                      array of parsed objects
     */
    public function parse(string $xmlString, IXmlParseable $parseable): array
    {
        $result = [];
        $xmlObject = simplexml_load_string($xmlString);
        foreach ($xmlObject as $value) {
            $result[] = $parseable->xmlObjectToObject($value);
        }
        return $result;
    }
}
