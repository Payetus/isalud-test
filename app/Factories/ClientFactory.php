<?php

namespace App\Factories;

use App\Client;
use App\Parsers\IJsonParseable;
use App\Parsers\IXmlParseable;
/**
 * Class containing the information to map from object to client object
 */
class ClientFactory implements IJsonParseable, IXmlParseable
{
    /**
     * Maps jsonObject to Client
     * @param  $object $object jsonObject
     * @return Client         mapped client
     */
    public function jsonObjectToObject($object): Client
    {
        return new Client( $object->name, $object->email, $object->phone, $object->company->name);
    }
    /**
     * Maps xmlObject to Client
     * @param  $object $object xmlObject
     * @return Client         mapped client
     */
    public function xmlObjectToObject($object): Client
    {
        return new Client( $object['name'], (string) $object, $object['phone'], $object['company']);
    }

}
