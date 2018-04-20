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
    protected $signature = 'clients:update
        {path : Path of the file where the csv is stored }
        {--api=https://jsonplaceholder.typicode.com/users : Api url endpoint where to obtain the json data}
        {--file=data.xml : Path of the xml file where to obatain the data}
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $factory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->factory = new ClientFactory();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Obtaining arguments and options
        $resultPath = $this->argument('path');
        $apiUrl = $this->option('api');
        $filePath = $this->option('file');

        // Obtain data from api
        $this->line('Obtaining data from internal api');
        $apiClients = $this->getApiClients($apiUrl);

        // Obtain data from xml file
        $this->line('Obtaining data from file');
        $fileClients = $this->getFileClients($filePath);
        // join data
        $clients = array_merge($apiClients, $fileClients);
        $this->info('Total number of clients: '.count($clients));
        $this->info('Serializing to file: '.$resultPath);
        // serialize to csv
        $serializer = new CsvSerializer;
        $serializer->serializeToFile($resultPath, $clients);

    }
    /**
     * Gets the client from the Api
     * @param  String $url Api url endpoint
     * @return array    Array of clients
     */
    private function getApiClients($url)
    {
        // TODO: Refactor: encapsulate in a new class
        $httpClient = new HttpClient;
        $res = $httpClient->get($url);
        $apiClients = [];
        if ($res->getStatusCode() == 200) {
            $json = $res->getBody();
            // Parse data
            $parser = new JsonParser();
            $apiClients = $parser->parse($json, $this->factory);
            $this->info('Obtained '.count($apiClients).' from api');
        }else{
            $this->error('Failed to obtain data from api');
        }
        return $apiClients;
    }
    /**
     * Gets clients from xml file
     * @param  String $path Path to the xml file
     * @return array        Array of clients
     */
    private function getFileClients($path): array
    {
        // TODO: Refactor: encapsulate in a new class
        $xml = file_get_contents($path);
        // Parse Xml
        $parser = new XmlParser;
        $fileClients = $parser->parse($xml, $this->factory);
        $this->info('Obtained '.count($fileClients).' from file: '.$path);
        return $fileClients;
    }
}
