<?php

namespace App\Services;

use App\enum\CategoryChildrentTypeEnum;
use App\Exceptions\CustomException;
use App\Models\Category;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
    public function index()
    {
        return Category::all();
    }
    
    public function store(array $data)
    
    {
        $name = $data['name'];
        $parentId = $data['parent_id'] ?? null;
        $Image = $data['image'] ?? null;
        $imagePath = null;
        $level = 0;
        if ($parentId) {
            $parent = Category::whereId($parentId)->first();
            if (!$parent) {
                throw new CustomException("parent not exit", 404);
            }
            $level = Category::NewLevel($parent);
        }
        if ($Image) {
            $imagePath = ImageService::upload_image($Image);
        }

        return Category::create([
            "name" => $name,
            "level" => $level,
            "parent_id" => $parentId,
            "image" => $imagePath,
        ]);
    }

    public function update(array $data, $id)
    {
        $category = Category::find($id);
    
        if ($category) {
            $category->update($data);
            
            return $category; 
        }
    
        return null;
    }
    
    public function destroyWithImage(array $data)
    {
        return [];
    }
}
