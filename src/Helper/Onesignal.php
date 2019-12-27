<?php

namespace VnCoder\Helper;

class Onesignal
{
    public static function pushNotify($app_url, $en_title, $en_message, $app_icon)
    {
        $appConfig = [
            'mono' => [
                'app_id' => '5edaea02-15f3-4697-96e8-09acf441b653',
                'app_key' => 'YmQ5OGI0MGMtM2IyZS00ZWMyLWE0MGUtZmQyOTQ3OGE0Nzk5',
                'total' => '304k'
            ],

            'oza' => [
                'app_id' => 'f4e52014-440c-4794-91f2-89025e3a9d4f',
                'app_key' => 'MDE2YjQzOWMtM2Y1YS00YTU2LWJkOTktMTg1NWY0MDhkYTM4',
                'total' => '15k'
            ],

            'mario' => [
                'app_id' => '8e313ee1-c755-459a-9e85-046d7afe1e66',
                'app_key' => 'YmRhNzA0NDgtNTExNS00NTMxLWJiMGEtMGIwZDNjYzljZTM3',
                'total' => '550.7k'
            ],

            'vngame' => [
                'app_id' => '1e5bc905-70ef-4d2e-bd26-40afb0b2c4e2',
                'app_key' => 'NGZiMjZjNjItMTkxOS00ZjdlLThiMjYtMmE1ODRkMDczMjU1',
                'total' => '520.3k'
            ],

            'rambo' => [
                'app_id' => 'f21b3812-c20c-4993-a7fb-665f451164dc',
                'app_key' => 'ZmNmYTA1ODEtNTc3Ny00MGY1LTg2MDMtYmFkMWJiZGRhY2E0',
                'total' => '185.0k'
            ],
            'm3' => [
                'app_id' => '0141f3ed-acbf-493f-a019-d57aab81d080',
                'app_key' => 'NGU5Mzc1MjUtYmQ3NC00MWE1LTg4ZmItZmYwODRhOTM5ZjYw',
                'total' => '76.5k'
            ],
            'td' => [
                'app_id' => 'a332b38c-45a0-48ae-9730-1d046308c0fa',
                'app_key' => 'MDRhOWNmZWEtMmM3Ny00MzM2LTk1ZDQtMGFhYWE4ZGJjNWFj',
                'total' => '117.5k'
            ],
            'sk' => [
                'app_id' => '47698292-0ae7-43ed-a5fd-5d35aedb7c92',
                'app_key' => 'Mzg0NzAzMTMtMWZiOC00NTdlLWFlZDEtZDQ1NGQ0NzI3ZDRh',
                'total' => '117.5k'
            ]
        ];

        foreach ($appConfig as $key => $item) {
            $app_api = $item['app_id'];
            $app_key = $item['app_key'];
            echo "Push to ".$app_api." - ".@$item['total']."\n";
            $response = self::sendMessage($app_api, $app_key, $app_url, $en_title, $en_message, $app_icon);
            print_r($response);
            echo "\n";
        }
    }

    public static function pushNotifyID($app_url, $en_title, $en_message, $app_icon)
    {
        $app_api = "9c2f8c49-675c-49d6-8418-bdcc60c1a6e6";
        $app_key = "ZmQ0OTE1MDEtMDZiOC00YWZkLWJhYjgtOWYwNDRlNTA1Yjcz";

        // $app_api = "16c14e75-0d2c-40b3-8dec-857b3e6629ef";
        // $app_key = "OWIyN2VjYjgtOGQ2MS00Nzg3LTkyMjItZGRkMjNkM2YxZGU3";

        $response = self::sendMessage($app_api, $app_key, $app_url, $en_title, $en_message, $app_icon);
        print_r($response);
        echo "\n";
    }

    public static function sendMessage($app_api, $app_key, $app_url, $en_title, $en_message, $app_icon)
    {
        $title = array(
            "en" => $en_title
        );

        $message = array(
            "en" => $en_message
        );

        $fields = array(
            'app_id' => $app_api,
            'included_segments' => array('All'),
            'headings' => $title,
            'contents' => $message,
            'app_url' => $app_url,
            'small_icon' => $app_icon.'=s80',
            'large_icon' => $app_icon.'=s250',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$app_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
