<?php

namespace App\Factories;

use App\Client;
use App\Parsers\IJsonParseable;

class ClientFactory implements IJsonParseable
{
    public function jsonObjectToObject($object): Client
    {
        return new Client( $object->name, $object->email, $object->phone, $object->company->name);
    }

}
