<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingFee\StoreShippingFeeRequest;
use App\Http\Requests\ShippingFee\UpdateShippingFeeRequest;
use App\Http\Resources\Dashboard\ShippingFees\GetAllShippingFeeCollection;
use App\Http\Resources\Dashboard\ShippingFees\GetOneShippingFeeResource;
use App\Services\ShippingFeeService;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    public function __construct(protected ShippingFeeService $service) {

    }
    public function index(Request $request){
        $data = $this->service
        ->indexWithPagination($request->per_page??8, $request->page ,$request->name);
        $response = new GetAllShippingFeeCollection($data);

        return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneShippingFeeResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreShippingFeeRequest $request){
        $validatedData = $request->validated();
        $data = $this->service->storeShippingFee($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateShippingFeeRequest $request,$id)
    {
        $validatedData = $request->validated();
        $data = $this->service->updateShippingFee($id,$validatedData);
        return $this->sendResponse($data);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->sendResponse(); 
    }
    
}
