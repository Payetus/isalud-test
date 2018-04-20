# Prueba tècnica iSalud

## Guia de instalacion
* unzip isalud-test
* `cd isalud-test`
* `composer install`
* `php artisan key:generate`

## Guia de ejecución
El comando para ejecutar la prueba es el siguiente:

`php artisan clients:update`

El comando espera una serie de parametros:
* El path donde debe ubicar el csv resultante (obligatorio)
* El path del fichero xml que contiene los datos de cliente (opcional tiene un valor por defecto)
* La URL de la api que se debe atacar (opcional tiene un valor por defecto)

Usage:
> `clients:update [options] [--] <path>`

Arguments:

>path                  Path of the file where the csv is stored

Options:

      --api[=API]       Api url endpoint where to obtain the json data [default: "https://jsonplaceholder.typicode.com/users"]

      --file[=FILE]     Path of the xml file where to obatain the data [default: "data.xml"]


Para mas información podeis consultar como usar el comando mediante el comando

`php artisan clients:update -h`

## Ejecutar unit tests

Se pueden ejecutar los Unit con el comando:

`phpunit`

En caso de que el comando anterior no funcione probad el siguiente comando

`vendor/bin/phpunit`

## Librerias adicionales usadas
* 'guzzle/guzzle' Para las llamadas http a la api

## Codigo interesante de ser revisado
* app\Serializers\\*
* app\Factories\\*
* app\Parsers\\*
* app\Client.php
* app\Console\Commands\UpdateClients.php
