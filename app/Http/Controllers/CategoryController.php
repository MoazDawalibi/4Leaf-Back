<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Dashboard\Category\GetAllCategoryCollection;
use App\Http\Resources\Dashboard\Category\GetOneCategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {

    }
    public function index(Request $request){
        $data = $this->service
        ->indexWithPagination($request->per_page??8, $request->page ,$request->name);
        $response = new GetAllCategoryCollection($data);

        return $this->sendResponse($response);
    }
    public function show($id){   
        $data = $this->service->show($id);
        $response = new GetOneCategoryResource($data);
        return $this->sendResponse($response);
    }
    public function store(StoreCategoryRequest $request){
        $validatedData = $request->validated();
        $data = $this->service->store($validatedData);
        return $this->sendResponse($data);
    }

    public function update(UpdateCategoryRequest $request,$id)
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
