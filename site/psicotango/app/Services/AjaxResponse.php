<?php

namespace App\Services;


class AjaxResponse {
    
    public function success($data){
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function error($message){
        return response()->json(['success' => false, 'message' => $message]);
    }
}