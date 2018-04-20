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
        //Obtaining arguments and options
        $resultPath = $this->argument('path');
        $apiUrl = $this->option('api');
        $filePath = $this->option('file');

        $httpClient = new HttpClient();
        $factory = new ClientFactory();
        // Obtain data from api
        $this->line('Obtaining data from internal api');
        $res = $httpClient->get($apiUrl);
        $apiClients = [];
        if ($res->getStatusCode() == 200) {
            $json = $res->getBody();
            $parser = new JsonParser();
            $apiClients = $parser->parse($json, $factory);
            $this->info('Obtained '.count($apiClients).' from api');
        }else{
            $this->error('Failed to obtain data from api');
        }
        // Obtain data from xml file
        $this->line('Obtaining data from file');
        // Parse data to clients
        $xml = file_get_contents($filePath);
        $parser = new XmlParser;
        $fileClients = $parser->parse($xml, $factory);
        $this->info('Obtained '.count($fileClients).' from file: '.$filePath);
        // join data
        $clients = array_merge($apiClients, $fileClients);
        $this->info('Serializing to file: '.$resultPath);
        // serialize to csv
        $serializer = new CsvSerializer;
        $serializer->serializeToFile($resultPath, $clients);

    }
}
