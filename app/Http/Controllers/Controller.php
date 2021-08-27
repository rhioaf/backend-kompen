<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Send valid response API
    public function sendResponse($result, $message='Berhasil'){
        $responses = [
            'success'   =>  true,
            'data'      =>  $result,
            'message'   =>  $message
        ];
        return response()->json($responses, 200);
    }

    // Send invalid response API
    public function sendError($error, $code = 404){
        $responses = [
            'success'   =>  false,
            'message'   =>  $error
        ];

        return response()->json($responses, $code);
    }

}
