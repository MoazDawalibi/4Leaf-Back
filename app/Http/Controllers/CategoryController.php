<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function __construct(protected CategoryService $servise) {
       
    }
    public function index(){
       $data = $this->servise->index();

       return $this->sendResponse($data);
    }
    public function store(AddCategoryRequest $request){
       
        $validatedData = $request->validated();
            $data = $this->servise->store($validatedData);
            return $this->sendResponse($data);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();
        $data = $this->servise->update($validatedData, $id);
        return $this->sendResponse($data);
    }
}
