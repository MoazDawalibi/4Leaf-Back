<?php

namespace App\Services\Base;

use App\Exceptions\CustomException;
use App\Exceptions\NotFoundException;
use App\Services\ImageService;

class BaseService
{
    protected $className;
    public $columnSearch = "name";
    public function __construct($className)
    {
        $this->className = new $className;
    }


    public function index()
    {
        $className = $this->className;
        $data = $className::get();
        return  $data;
    }

public function indexWithPagination($per_page = 8, $page = 1, $search = null)
{
    $className = $this->className;

    $query = $className::query(); 

    if ($search) {

        $query = $query->where($this->columnSearch, 'LIKE', '%' . $search . '%'); 
    }

    $data = $query->paginate($per_page, ['*'], 'page', $page);
    
    return $data;
}

    public function show($id)
    {
        $className = $this->className;

        $data = $className::find($id);
        if (!$data){
            throw new CustomException(404);
        }
        return $data;
    }

    public function store( $data )
    {
        $BaseData = $this->className::create($data);
        return $BaseData;
    }
    public function update( $id, $data )
    {
        $BaseData = $this->className::find($id);
        
        if ($BaseData) {
            $BaseData->update($data);
            
            return $BaseData; 
        }
        return null;
    }
    
    public function destroy($id)
    {
        $className = $this->className;
        $deleted = $className::where("id", $id)->delete();
        if (!$deleted){
            throw new CustomException('Resource Not Found',404);
        }
    }
  


    public function delete_with_image($id, $image_field_name)
    {
        $className = $this->className;
        $data = $className::where("id", $id)->first();
        if (!$data) {
            throw new CustomException(404);
        }
        ImageService::delete_image($data->$image_field_name);
        $data->delete();
    }
    
}
