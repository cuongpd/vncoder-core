<?php

namespace VnCoder\Helper;

use Illuminate\Support\Facades\Response;

class Output extends Response
{
    public static function csv($data, $filename = 'lumen-csv')
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$filename}.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $outputBuffer = fopen("php://output", 'w');
        foreach ($data as $val) {
            fputcsv($outputBuffer, $val);
        }
        fclose($outputBuffer);
    }

    public static function excel()
    {
    }

    public static function xml($data = null)
    {
        header('Content-Type: text/xml');

        if (null === $data) {
            $data = new \ArrayObject();
        }

        return response()->content(XmlTools::serialize($data));
    }
}
