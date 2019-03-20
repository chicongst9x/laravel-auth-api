<?php namespace App\Helpers;

trait MacroResponse
{
    /*
     * Success response
     */
    public function success($message = '', $data, $httpCode = 200){
        return response()->json([
            'status' => true,
            'message' => $message,
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