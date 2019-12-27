<?php

namespace VnCoder\Helper;

define("GOOGLE_DRIVE_API", "AIzaSyDpaRVdqN36FfZbF3HI52JjWLzvzLiv4js");

class DriveVideo
{
    public static function getInfo($url = "")
    {
        $gid = self::getDriveId($url);
        if ($gid) {
            return self::getVideoById($gid);
        }
    }

    protected static function getVideoById($gid)
    {
        $info = file_get_contents('https://content.googleapis.com/drive/v2/files/'.$gid.'?key='.GOOGLE_DRIVE_API);
        return json_decode($info, true);
        $image = sprintf('https://drive.google.com/thumbnail?id=%s&authuser=0&sz=w640-h360-n-k-rw', $gid);
        $json_api = file_get_contents(sprintf('https://filedeo.com/api?id=%1$s&api=%2$s', $gid, GOOGLE_DRIVE_API));
        $source = json_decode($json_api, true);
        $output = ['id' => $gid, 'title' => $title, 'image' => $image, 'label' => 'HD', 'file' => $source, 'type' => 'video/mp4'];
        $output = json_encode($output, JSON_PRETTY_PRINT);
        return $output;
    }

    protected static function getDriveId($string)
    {
        if (strpos($string, 'drive.google.com') !== false) {
            if (strpos($string, "/edit")) {
                $string = str_replace("/edit", "/view", $string);
            } elseif (strpos($string, "?id=")) {
                $parts = parse_url($string);
                parse_str($parts['query'], $query);
                return $query['id'];
            } elseif (!strpos($string, "/view")) {
                $string = $string . "/view";
            }
            $start  = "file/d/";
            $end = "";
            if (strpos($string, "/preview")) {
                $end = "/preview";
            } elseif (strpos($string, "/view")) {
                $end = "/view";
            }
            $string = " " . $string;
            $ini    = strpos($string, $start);
            if ($ini == 0) {
                return null;
            }
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        return false;
    }
}
