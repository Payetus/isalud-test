<?php

namespace App\Serializers;

/**
 *
 */
class CsvSerializer
{
    protected $delimiter = "|";

    /**
     * Serializes object to csv
     * @param  resource         $handle stream where to input de serailized data
     * @param  ICsvSerializable $object object to serialize
     * @return bool       Succes or failed of operation
     */
    public function serialize($handle, ICsvSerializable $object): bool
    {
        return fputcsv($handle, $object->toCsvArray(), $this->delimiter);
    }
    /**
     * Serializes  array of object to csv
     * @param  resource   $handle stream where to input de serailized data
     * @param  array      $arrayCsv array of objects to serialize
     * @return bool       Succes or failed of operation
     */
    public function serializeArray($handle,  array $arrayCsv): bool
    {
        $result = true;
        foreach ($arrayCsv as $object) {
            $result = $result && $this->serialize($handle, $object);
        }
        return $result;
    }
    /**
     * Serializes  array of object to csv file
     * @param  string   $path path where to create the csv file
     * @param  array      $arrayCsv array of objects to serialize
     * @return bool       Succes or failed of operation
     */
    public function serializeToFile($path, array $arr): bool
    {
        if(count($arr)>0){
            $handle = fopen($path, 'w');
            // add headers
            // // TODO: Make this dynamic
            fputcsv($handle, ['Nombre', 'Email', 'Telefóno', 'Empresa'], $this->delimiter);
            $result = $this->serializeArray($handle, $arr);
            fclose($handle);
            return $result;
        } else {
            return false;
        }
    }
}
