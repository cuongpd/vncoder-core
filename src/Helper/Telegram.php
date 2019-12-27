<?php

namespace VnCoder\Helper;

class Telegram
{
    public static function sendMessage($message, $chatId = "")
    {
        if (!$chatId) {
            $chatId = env('TELEGRAM_ID');
        }
        $telegramUrl = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendMessage";

        $params = [
            "chat_id" => $chatId,
            "parse_mode" => 'markdown',
            "text" => $message
        ];
        $ch = curl_init($telegramUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
