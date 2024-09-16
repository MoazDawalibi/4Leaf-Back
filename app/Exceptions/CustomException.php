<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class CustomException extends Exception
{
    protected $messages ;

    public function __construct( protected $message = "initial server error", protected $code = 500)
    {

    }

    public function render($request): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => __("$this->message"),
            "status" => $this->code,
            "data" => [],
        ], $this->code);
    }
}
