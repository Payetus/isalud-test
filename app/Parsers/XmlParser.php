<?php

namespace App\Parsers;

use App\Parsers\IXmlParseable;

/**
 *
 */
class XmlParser
{
    public function parse(string $xmlString, IXmlParseable $parseable)
    {
        $result = [];
        $xmlObject = simplexml_load_string($xmlString);
        foreach ($xmlObject as $value) {
            $result[] = $parseable->xmlObjectToObject($value);
        }
        return $result;
    }
}
