<?php 


namespace App\Services ;
use App\Models\User;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService {

    public function __construct() {
        parent::__construct(className: User::class);
    }

    public function login(array $data){
        // dd($data);
        return $data;
    }
    public function register($data){
    // $data['password'] = Hash::make($data['password']);
    $user = $this->className::create($data);
    return $user;
    }
    public function logout($request){
    return $request;
    }  

}