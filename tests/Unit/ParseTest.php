<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;
use App\Factories\ClientFactory;
use App\Parsers\JsonParser;
use App\Parsers\XmlParser;

class ParseTest extends TestCase
{
    protected $client;
    protected $clients;
    protected $name = "John Doe";
    protected $email = "test@email.com";
    protected $phone = "666999333";
    protected $companyName = "iSalud SL";

    protected function setUp()
    {
        $this->client = new Client($this->name, $this->email, $this->phone, $this->companyName);
    }

    public function testXmlParse()
    {
        // arrange
        $xml = '<readings>\n
        \t<reading clientID="1" name="'.$this->name.'" phone="'.$this->phone.'" company="'.$this->companyName.'">'.$this->email.'</reading>
        \n</readings>';
        $parser= new XmlParser;
        // Act
        $result = $parser->parse($xml, new ClientFactory);
        // assert
        $this->assertEquals([$this->client], $result);
    }

    public function testJsonParse()
    {
        // Arrange
        $json = '[
          {
            "id": 10,
            "name": "'.$this->name.'",
            "username": "Moriah.Stanton",
            "email": "'.$this->email.'",
            "address": {
              "street": "Kattie Turnpike",
              "suite": "Suite 198",
              "city": "Lebsackbury",
              "zipcode": "31428-2261",
              "geo": {
                "lat": "-38.2386",
                "lng": "57.2232"
              }
            },
            "phone": "'.$this->phone.'",
            "website": "ambrose.net",
            "company": {
              "name": "'.$this->companyName.'",
              "catchPhrase": "Centralized empowering task-force",
              "bs": "target end-to-end models"
            }
          }
        ]';
        $parser= new JsonParser;
        // Act
        $result = $parser->parse($json, new ClientFactory);
        // assert
        $this->assertEquals([$this->client], $result);
    }


}
