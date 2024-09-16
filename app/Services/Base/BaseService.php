<?php

namespace App\Services\Base;

use App\Exceptions\CustomException;
use App\Exceptions\NotFoundException;
use App\Services\ImageService;

class BaseService
{
    protected $className;
    public function __construct($className)
    {
        $this->className = new $className;
    }


    public function index()
    {
        $className = $this->className;
        $data = $className::all();
        return  $data;
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
    public function destroy($id)
    {
        $className = $this->className;
        $deleted = $className::where("id", $id)->delete();
        if (!$deleted){
            throw new CustomException(404);
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
