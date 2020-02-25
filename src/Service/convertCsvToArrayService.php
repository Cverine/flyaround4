<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 26/02/19
 * Time: 15:50
 */

namespace App\Service;


class convertCsvToArrayService
{
    public function convert($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = [];
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 150)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}