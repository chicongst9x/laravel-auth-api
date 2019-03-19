<?php namespace App\Helpers;

trait MacroResponse
{
    /*
     * Success response
     */
    public function success($data, $httpCode = 200){
        return response()->json([
            'status' => true,
            'data' => $data
        ], $httpCode);
    }

    /*
     * Error response
     */
    public function error($message, $httpCode){
        return response()->json([
            'status' => false,
            'message' => $message
        ], $httpCode);
    }

}