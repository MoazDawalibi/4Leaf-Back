<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service){

    }

    public function login(LoginRequest $request){
        $user = $this->service->login($request->validated());
        if (!$user){
            return $this->sendError(__('login failed'));  
        }
        return $this->sendResponse($user);   
    }

    public function register(Request $request){
        $registerData = $this->service->register($request->all());
        return $this->sendResponse($registerData);    
    }

    public function logout(Request $request)
    {
        $data = $this->service->logout($request);
        if(!$data){
            return $this->sendError(__('failed'));  
        }
        return $this->sendResponse('logut succdata: essfully');
    }
}
