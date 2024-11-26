<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Dashboard\Product\GetAllProductCollection;
use App\Http\Resources\Dashboard\Product\GetOneProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {

    }
    public function index(Request $request){
        // dd($request);
        $data = $this->service
        ->indexWithFilter(
         $request->per_page??8,
          $request->page,
          $request->name,
          $request->shipment_id,
          $request->customer_id,
          $request->status);
        $response = new GetAllProductCollection($data);

        return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->showProduct($id);
        $response = new GetOneProductResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreProductRequest $request){       
        $validatedData = $request->validated();
        $data = $this->service->create($validatedData);   
        return $this->sendResponse($data);
    }

    public function update(UpdateProductRequest $request,$id)
    {
        $validatedData = $request->validated();
        $data = $this->service->update($id,$validatedData);
        return $this->sendResponse($data);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->sendResponse(); 
    }
    
}
