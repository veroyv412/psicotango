<?php

namespace App\Services;


class AjaxResponse {
    
    public function success($data){
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function error($message){
        return response()->json(['success' => false, 'message' => $message], 400);
    }
}