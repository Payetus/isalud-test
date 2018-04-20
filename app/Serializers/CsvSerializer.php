<?php

namespace App\Serializers;

/**
 *
 */
class CsvSerializer
{
    protected $delimiter = "|";

    
    public function serialize($handle, ICsvSerializable $object)
    {
        fputcsv($handle, $object->toCsvArray(), $this->delimiter);
    }

    public function serializeArray($handle,  array $arrayCsv)
    {
        foreach ($arrayCsv as $object) {
            $this->serialize($handle, $object);
        }
    }

    public function serializeToFile($path, array $arr)
    {
        if(count($arr)>0){
            $handle = fopen($path, 'w');
            // add headers
            // // TODO: Make this dynamic
            fputcsv($handle, ['Nombre', 'Email', 'Telefóno', 'Empresa'], $this->delimiter);
            $this->serializeArray($handle, $arr);
            fclose($handle);
        } else {
            return false;
        }
    }
}
