<?php 

namespace App\Services;

use App\Models\Customer;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Hash;

class CustomerService extends BaseService {

        public function __construct(){
            parent::__construct(Customer ::class); 
        }

}
