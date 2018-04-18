<?php

namespace App;

use App\Serializers\ISerializeCSV;

class Client implements ISerializeCSV
{
    protected $name;
    protected $email;
    protected $phone;
    protected $companyName;

    public function __construct(String $name, String $email, String $phone, String $companyName)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->compa = $companyName;
    }
}
