<?php 

namespace App\Services;

use App\Models\User;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService {

        public function __construct(){
            parent::__construct(User ::class); 
        }
            
        public function getAll($name,$email, $perPage)
        {
            $query = User::query();
            
            if ($name)  $query->where('name', 'LIKE', "%{$name}%");
    
            if ($email) $query->where('email', 'LIKE', "%{$email}%");
            
        
            return $query->paginate($perPage);
        }
        
        
        public function store($data){
                $name = $data["name"] ; 
                $email = $data["email"] ; 
                $password = $data["password"] ; 
            $newUser = [
                "name" =>  $name,
                "email" =>  $email,
                "password" =>  Hash::make($password),
            ] ;
            return User::create($newUser)  ;
        }

}
