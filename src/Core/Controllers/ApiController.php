<?php

namespace VnCoder\Core\Controllers;

class ApiController
{
    protected $status = 0;
    protected $data;
    protected $message = "";

    public function Index_Action()
    {
        $this->status = 1;
        $this->message = "Index Action";
        return $this->json();
    }

    public function Home_API(){
        $this->status = 1;
        $this->message = "Home API";
        return $this->json();
    }

    protected function json()
    {
        $data = [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
        if(env('APP_DEBUG')){
            $data['method'] = request()->method();
        }

        return response()->json($data);
    }

    protected function json_data($data = [])
    {
        return response()->json($data);
    }

    protected function views($blade){
        return view('api::'.$blade)->render();
    }



}
