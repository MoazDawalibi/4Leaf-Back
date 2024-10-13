<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Dashboard\Order\GetAllOrderCollection;
use App\Http\Resources\Dashboard\Order\GetOneOrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service) {

    }
    public function index(Request $request){
        $data = $this->service
        ->indexWithFilter(
         $request->per_page??8,
          $request->page,
          $request->user_id,
          $request->status);
        $response = new GetAllOrderCollection($data);
 
        return $this->sendResponse($response);
     }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneOrderResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreOrderRequest $request){
       
        $validatedData = $request->validated();
        $data = $this->service->store($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateOrderRequest $request,$id)
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
