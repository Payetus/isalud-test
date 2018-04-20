<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Client;
use App\Serializers\CsvSerializer;

class SerializeCsvTest extends TestCase
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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testToCsvArrayClient()
    {
        // Arrange
        $arr = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'companyName' => $this->companyName,
        ];
        // Act
        $csvArray = $this->client->toCsvArray();
        // Assert
        $this->assertEquals($csvArray, $arr);
        $this->assertTrue(true);
    }

    public function testCsvSerializer()
    {
        // Arrange
        $serializer = new CsvSerializer();
        $handle = fopen('test.csv', 'w');
        // act
        $serializer->serialize($handle, $this->client);
        $this->assertFileEquals('test.csv', 'tests/resources/1client.csv');
        fclose($handle);
        // assert
    }

    public function testCsvSerializerArray()
    {
        // Arrange
        $arr = [$this->client, $this->client];
        $serializer = new CsvSerializer();
        $handle = fopen('test2.csv', 'w');
        // act
        $serializer->serializeArray($handle, $arr);
        fclose($handle);
        // assert
        $this->assertFileEquals('test2.csv', 'tests/resources/2clients.csv');
    }

    public function testCsvSerializerToFile()
    {
        // Arrange
        $arr = [$this->client, $this->client];
        $serializer = new CsvSerializer();
        // act
        $serializer->serializeToFile('test3.csv', $arr);
        // assert
        $this->assertFileEquals('test3.csv','tests/resources/fileSerialize.csv');

    }
}
