<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shipment\StoreShipmentRequest;
use App\Http\Requests\Shipment\UpdateShipmentRequest;
use App\Http\Resources\Dashboard\Shipment\GetAllShipmentCollection;
use App\Http\Resources\Dashboard\Shipment\GetOneShipmentResource;
use App\Services\ShipmentService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function __construct(protected ShipmentService $service) {

    }
    public function index(Request $request){
       $data = $this->service
       ->indexWithFilter(
        $request->per_page??8,
         $request->page ,
         $request->name,
         $request->start_date,
         $request->end_date,
         $request->currency_price,
         $request->status);
       $response = new GetAllShipmentCollection($data);

       return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneShipmentResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreShipmentRequest $request){
       
        $validatedData = $request->validated();
        $data = $this->service->store($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateShipmentRequest $request,$id)
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
