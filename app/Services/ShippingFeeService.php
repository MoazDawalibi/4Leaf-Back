<?php

namespace App\Services;

use App\Models\ShippingFee;
use App\Services\Base\BaseService;

class ShippingFeeService extends BaseService
{
    public function __construct()
    {
        parent::__construct(ShippingFee::class);
    }
    public function storeShippingFee($data)
    {
   
        $image = ImageService::upload_image($data['image'], 'shipping_fee');
        $data = ShippingFee::create([
            'image' => $image,
            'name' => $data['name'],
            'price'=> $data['price'],
            'is_disabled' => $data['is_disabled']
        ]);
        $data->save();

        return $data;
    }

    public function updateShippingFee(int $id, $data)
    {
        $shippingFee = ShippingFee::find($id);

        if (!$shippingFee) {
            return null; 
        }

        // Check if a new image is provided in the $data
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Use the update_image function if there's a new uploaded image
            $newImage = ImageService::update_image($data['image'], $shippingFee->image, 'shipping_fee');
            $data['image'] = $newImage; // Set the new image path in the data array
        } else {
            // If no new image is uploaded, remove the 'image' key to prevent overwriting the existing path
            unset($data['image']);
        }

        $shippingFee->update($data);

        return $shippingFee;
    }

    public function delete(int $id)
    {

        $data = ShippingFee::find($id);
        
        $data->delete();
        
        ImageService::delete_image($data->image);
        
        return [];
    }
}
