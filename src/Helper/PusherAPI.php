<?php

namespace VnCoder\Helper;

use Pusher\Pusher;
use Pusher\PusherException;
use VnCoder\Core\Models\VnUsers;

class PusherAPI
{
    protected $pusher;
    protected $channel;

    function __construct()
    {
        try {
            $this->pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), ['cluster' => env('PUSHER_APP_CLUSTER'), 'useTLS' => true]);
        } catch (PusherException $e) {
            info($e->getMessage());
        }

        $this->channel = env('PUSHER_APP_CHANNEL' , 'vncoder-channel');
    }

    public function toUser($user_id , $data = []){
        $userInfo = VnUsers::getInfo($user_id);
        if($userInfo){
            $this->pusher->trigger($this->channel, 'user-'.$userInfo->code, $data);
        }
    }


}