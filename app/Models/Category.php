<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Category extends BaseModel
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function Newlevel($parent)
    {   
        if($parent){
            return $parent->level + 1;
        }
        return 0;
    }

    public function getImageAttribute($value)
    {
        $baseUrl = Config::get('appSetting.app_base_url_image');
        return $value ?  $baseUrl . "" . $value : null ;
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = str_replace(Config::get('appSetting.app_base_url_image'), '', $value);
    }
    
}