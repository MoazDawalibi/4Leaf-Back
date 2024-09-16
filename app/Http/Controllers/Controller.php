<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($data = [], $status = 200, $customMessage = null)
    {
        $methodMessage = $customMessage ?? $this->getMethodMessage(request()->method());

        return response()->json([
            "success" => true,
            'message' => $methodMessage,
            "status" => $status,
            "data" => $data,
        ], $status);
    }



    private function getMethodMessage($method)
    {
        switch ($method) {
            case 'POST':
                return __('message.create');
            case 'GET':
                return __('message.index');
            case 'PUT':
                return __('message.update');
            case 'DELETE':
                return __('message.destroy');
            default:
                return __("message.successful");
        }
    }

    public function sendError($errorMessages = null, $status = 400)
    {
        $errorMessage = $errorMessages ?? __("message.error");
    
        return response()->json([
            "success" => false,
            'message' => $errorMessage,
            "status" => $status,
        ], $status);
    }
    
}



