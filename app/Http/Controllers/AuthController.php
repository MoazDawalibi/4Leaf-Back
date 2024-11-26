<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateUser;
use App\Http\Resources\Dashboard\Auth\GetAllUserCollection;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {
        
    }

    public function index(Request $request){
        $data = $this->service
        ->indexWithFilter($request->per_page??8, $request->page ,$request->email,$request->role_type);
        $response = new GetAllUserCollection($data);
        return $this->sendResponse($response);
    }
    public function login(LoginRequest $request)
    {
        $response = $this->service->login($request->validated());
    
        if (isset($response['error'])) {
            return $this->sendError(__($response['error']));
        }
    
        return $this->sendResponse($response);
    }
    
    public function register(RegisterRequest $request)
    {
        $response = $this->service->register($request->validated());
    
        if (isset($response['error'])) {
            return $this->sendError(__($response['error']));
        }
    
        return $this->sendResponse($response);
    }
    

    public function logout(Request $request)
    {
        $response = $this->service->logout($request);
    
        if (isset($response['error'])) {
            return $this->sendError(__($response['error']));
        }
    
        return $this->sendResponse($response);
    }

    public function update(UpdateUser $request, $userId)
    {
        // Validate input data
        $validated = $request->validated();

        $response = $this->service->updateUser($validated, $userId);

        if (isset($response['error'])) {
            return $this->sendError(__($response['error']));
        }

        return $this->sendResponse($response);
    }
}
