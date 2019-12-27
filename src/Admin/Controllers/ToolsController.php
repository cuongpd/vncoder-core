<?php

namespace VnCoder\Admin\Controllers;

class ToolsController extends AdminController
{
    public function Debugbar_Action()
    {
        $debugbar = vn_cookie('_debugbar');
        if ($debugbar == 'on') {
            vn_cookie(['_debugbar' => NULL]);
            $message = "Chế độ Debug đã tắt";
        } else {
            vn_cookie(['_debugbar' => 'on']);
            $message = "Chế độ Debug đã được bật";
        }
        flash_message($message);
        return response()->json(['message' => $message]);
    }
}
