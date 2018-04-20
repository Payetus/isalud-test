<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Client;
use GuzzleHttp\Client as HttpClient;
use App\Factories\ClientFactory;
use App\Parsers\JsonParser;
use App\Parsers\XmlParser;
use App\Serializers\CsvSerializer;

class UpdateClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clients:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $httpClient = new HttpClient();
        $factory = new ClientFactory();
        // Obtain data from api
        $this->line('Obtaining data from internal api');
        $res = $httpClient->get('https://jsonplaceholder.typicode.com/users');
        $apiClients = [];
        if ($res->getStatusCode() == 200) {
            $json = $res->getBody();
            $this->info('OK response');
            // Parse data to clients array
            $parser = new JsonParser();
            $apiClients = $parser->parse($json, $factory);
            $this->info('Obtained '.count($apiClients).' from api');
        }else{
            $this->error('Failed to obtain data');
        }
        // Obtain data from xml file
        $this->line('Obtaining data from file');
        // Parse data to clients
        $xml = file_get_contents("data.xml");
        $parser = new XmlParser;
        $fileClients = $parser->parse($xml, $factory);
        $this->info('Obtained '.count($fileClients).' from file');
        // join data
        $clients = array_merge($apiClients, $fileClients);
        $this->info('Serializing to file');
        // serialize to csv
        $serializer = new CsvSerializer;
        $path = "result.csv";
        $serializer->serializeToFile($path, $clients);

    }
}
