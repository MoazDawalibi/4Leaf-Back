<?php 

namespace App\Services;

use App\Models\Customer;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\Hash;

class CustomerService extends BaseService {

    public $columnSearch = "account_name";
    public function __construct(){
        parent::__construct(Customer ::class); 
    }
    public function indexWithFilter(
        $per_page = 8,
        $page = 1,
        $search = null,
        $phone_number = null,
        $customer_type = null) 
    {
        $data = Customer::when($phone_number, function ($q) use ($phone_number) {
            return $q->wherePhoneNumber( $phone_number);
        })
        ->when($customer_type, function ($q) use ($customer_type) {
            return $q->whereCustomerType($customer_type); 
        });

        if ($search) {
            $data->where($this->columnSearch, 'LIKE', '%' . $search . '%');
        }
    
        $customer = $data->paginate($per_page, ['*'], 'page', $page);
        
        return $customer;
    }

}
