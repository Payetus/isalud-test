<?php

namespace App\Serializers;

/**
 *
 */
class CsvSerializer
{
    public function serialize($handle, ICsvSerializable $object)
    {
        fputcsv($handle, $object->toCsvArray());
    }

    public function serializeArray($handle,  array $arrayCsv)
    {
        foreach ($arrayCsv as $object) {
            $this->serialize($handle, $object);
        }
    }
    public function serializeToFile($path, array $arr)
    {
        $handle = fopen($path, 'w');
        $this->serializeArray($handle, $arr);
        fclose($handle);
    }
}
