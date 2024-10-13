<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaticInfo\StoreStaticInfoRequest;
use App\Http\Requests\StaticInfo\UpdateStaticInfoRequest;
use App\Http\Resources\Dashboard\StaticInfo\GetAllStaticInfoCollection;
use App\Http\Resources\Dashboard\StaticInfo\GetOneStaticInfoResource;
use App\Services\StaticInfoService;
use Illuminate\Http\Request;

class StaticInfoController extends Controller
{
    public function __construct(protected StaticInfoService $service) {

    }
    public function index(Request $request){
        $data = $this->service
        ->indexWithPagination($request->per_page??8, $request->page ,$request->key);
        $response = new GetAllStaticInfoCollection($data);

        return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneStaticInfoResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreStaticInfoRequest $request){
        $validatedData = $request->validated();
        $data = $this->service->store($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateStaticInfoRequest $request,$id)
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
