<?php

namespace App;

use App\Serializers\ICsvSerializable;

class Client implements ICsvSerializable
{
    public $name;
    public $email;
    public $phone;
    public $companyName;

    public function __construct(String $name, String $email, String $phone, String $companyName)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->companyName = $companyName;
    }
    public function toCsvArray()
    {
        return (array) $this;
    }
}
