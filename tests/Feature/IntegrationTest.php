<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class IntegrationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

    }
    /**
     * Integration test
     *
     * @return void
     */
    public function testCommand()
    {
        Artisan::Call('client:update', [
            'path' => 'integration.csv'
        ]);

        $this->assertFileEquals('integration.csv', 'tests/resources/result.csv');
    }

    public function testCommandOptions()
    {
        Artisan::Call('client:update', [
            'path' => 'integrationO.csv',
            '--file' => 'data.xml',
            '--api' => 'https://jsonplaceholder.typicode.com/users'
        ]);

        $this->assertFileEquals('integrationO.csv', 'tests/resources/result.csv');
    }
}
