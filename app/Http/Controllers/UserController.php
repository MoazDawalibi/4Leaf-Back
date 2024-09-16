<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

public function __construct(protected UserService $servise ){
    
}
    public function index(Request $request){
        $param = $request->all();
        $name = $param['name'] ?? null;
        $email = $param['email'] ?? null;
        $perPage = $param['per_page'] ?? 10;

        $data = $this->servise->getAll($name,$email, $perPage);
        return $this->sendResponse($data);
    }
    public function store(UserRequest $request){

        
        $validatedData = $request->validated();
        $data = $this->servise->store($validatedData);
        return $this->sendResponse($data);

    }
}
