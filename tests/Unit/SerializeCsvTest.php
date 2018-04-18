<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;

class SerializeCsvTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testToCsvArrayClient()
    {
        $name = "John Doe";
        $email = "test@email.com";
        $phone = "666999333";
        $companyName = "iSalud";
        $client = new Client($name, $email, $phone, $companyName);
        $arr = [
             'name' => $name,
             'email' => $email,
             'phone' => $phone,
             'companyName' => $companyName,
        ];
        $this->assertEquals($client->toCsvArray(), $arr);
        $this->assertTrue(true);
    }
}
