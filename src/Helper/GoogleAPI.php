<?php

namespace VnCoder\Helper;

use Google_Client as BaseGoogleClient;

class GoogleAPI
{
    protected $client;

    public function getClient()
    {
        $this->client = new BaseGoogleClient();
        $google_token = storage_path(env('GOOGLE_API_TOKEN'));
        $google_credential = storage_path(env('GOOGLE_API_CREDENTIAL'));

        if (!file_exists($google_credential)) {
            throw new \Exception('You have not create client for application.' .' Please create on "console.google.com" and save to your storage "storage/google/credentials.json"!');
        }
        $this->client->setAuthConfig($google_credential);
        $this->client->setAccessType('offline');

        if (!file_exists($google_token)) {
            throw new \Exception('Do not receive access token. Please run command "php artisan google:get-token" to get token!');
        }

        $accessToken = json_decode(file_get_contents($google_token), true);
        $this->client->setAccessToken($accessToken);

        // nếu token hết hạn sẽ tiến hành refresh lại token để sử dụng
        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            file_put_contents($google_token, json_encode($this->client->getAccessToken()));
        }

        return $this->client;
    }
}
