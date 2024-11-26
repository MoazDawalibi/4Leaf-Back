<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Dashboard\Customer\GetAllCustomerCollection;
use App\Http\Resources\Dashboard\Customer\GetOneCustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service) {

    }
    public function index(Request $request){
        $data = $this->service
        ->indexWithFilter($request->per_page??8, $request->page ,$request->account_name,$request->phone_number,$request->customer_type);
        $response = new GetAllCustomerCollection($data);
        return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneCustomerResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreCustomerRequest $request){
       
        $validatedData = $request->validated();
        $data = $this->service->store($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateCustomerRequest $request,$id)
    {
        $validatedData = $request->validated();
        $data = $this->service->update($id,$validatedData);
        return $this->sendResponse($data);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return $this->sendResponse(); 
    }
    
}
