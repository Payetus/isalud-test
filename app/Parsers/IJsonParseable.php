<?php

namespace App\Parsers;

interface IJsonParseable
{
    public function jsonObjectToObject($jsonObject);
}
