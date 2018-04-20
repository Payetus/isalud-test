<?php

namespace App\Factories;

use App\Client;
use App\Parsers\IJsonParseable;
use App\Parsers\IXmlParseable;

class ClientFactory implements IJsonParseable, IXmlParseable
{
    public function jsonObjectToObject($object): Client
    {
        return new Client( $object->name, $object->email, $object->phone, $object->company->name);
    }

    public function xmlObjectToObject($object): Client
    {
        return new Client( $object['name'], (string) $object, $object['phone'], $object['company']);
    }

}
