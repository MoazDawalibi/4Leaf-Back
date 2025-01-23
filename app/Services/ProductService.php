<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }
        public function indexWithFilter(
            $per_page = 8,
            $page = 1,
            $search = null,
            $order_id = null,
            $price = null,
            $discount = null,
            $product_quantity = null,
            $product_options = null,
            )
        {
            $data = Product::with(['orders', 'shippingFee'])
            ->when($order_id, function ($q) use ($order_id) {
                return $q->whereOrderId($order_id); 
            })
            ->when($price, function ($q) use ($price) {
                return $q->wherePrice($price); 
            })
            ->when($discount, function ($q) use ($discount) {
                return $q->whereDiscount($discount); 
            })
            ->when($product_quantity, function ($q) use ($product_quantity) {
                return $q->whereProductQuantity($product_quantity); 
            })
            ->when($product_options, function ($q) use ($product_options) {
                return $q->whereProductOptions($product_options); 
            });
            if ($search) {
                $data->where($this->columnSearch, 'LIKE', '%' . $search . '%');
            }
        
            $product = $data->paginate($per_page, ['*'], 'page', $page);
            
            return $product;
        }


    public function showProduct($id)
    {
        $data = Product::with('orders')->find($id);
        return $data;
    }

    public function create($data)
    {
        $image = ImageService::upload_image($data['image'], 'products');
        $data['image'] = $image;
        
        $order = Order::find($data['order_id']);
        if (!$order) {
            return ['error' => 'Order not found'];
        }
    
        $shipment = Shipment::find($order->shipment_id);
        if (!$shipment) {
            return ['error' => 'Shipment not found'];
        }
        
        $customer_currency_price = $shipment['customer_currency_price'];
        $currency_price = $shipment['currency_price'];

        $price_with_currency = $data['price'] * $customer_currency_price;
        $price_with_quantity = $data['price'] * $data['product_quantity'] * $customer_currency_price;
    
        $data['price_with_currency'] = $price_with_currency;
        $data['price_with_quantity'] = $price_with_quantity;
    
        $product = Product::create($data);
    
        $product_quantity = $data['product_quantity'];
        $product_shipping_fees = $product_quantity * $data['shipping_fees'];

        $product_price = $product_quantity * $price_with_currency;
    
        $product_customer_currency_price = $data['price'] * $product_quantity * $customer_currency_price;
        $product_currency_price = $data['price'] * $product_quantity * $currency_price;
    
        $product_currency_profit = $product_customer_currency_price - $product_currency_price;

        $order->update([
            'product_count' => $order->product_count + $product_quantity,
            'shipping_fees_total_profit' => $order->shipping_fees_total_profit += $product_shipping_fees,
            'currency_profit' => $order->currency_profit += $product_currency_profit,
            'total_profit' => $order->total_profit + $product_shipping_fees + $product_currency_profit,
            'total_price' => $order->total_price + $product_shipping_fees + $product_price,
            'updated_at' => now(),
        ]);
    

        $shipment->update([
            'product_count' => $shipment->product_count + $product_quantity,
            'shipping_fees_total_profit' => $shipment->shipping_fees_total_profit += $product_shipping_fees,
            'currency_profit' => $shipment->currency_profit += $product_currency_profit,
            'total_profit' => $shipment->total_profit + $product_shipping_fees + $product_currency_profit,
            'total_price' => $shipment->total_price + $product_shipping_fees + $product_price,
            'updated_at' => now(),
        ]);
    
        return $product;
    }
    // private function updateEntity($entity, $original, $adjusted)
    // {
    //     $entity->update([
    //         'product_count' => ($entity->product_count - $original['quantity']) + $adjusted['quantity'],
    //         'shipping_fees_total_profit' =>
    //             ($entity->shipping_fees_total_profit - $original['shipping_fees']) + $adjusted['shipping_fees'],
    //         'currency_profit' =>
    //             ($entity->currency_profit - $original['currency_profit']) + $adjusted['currency_profit'],
    //         'total_profit' =>
    //             ($entity->total_profit - $original['total_profit']) + $adjusted['total_profit'],
    //         'total_price' =>
    //             ($entity->total_price - $original['total_price']) + $adjusted['total_price'],
    //         'updated_at' => now(),
    //     ]);
    // }

    // public function updateProduct($id, $data)
    // {
    //     $product = Product::find($id);
    //     if (!$product) {
    //         throw new CustomException('Product Not Found', 404);
    //     }
    
    //     $order = Order::find($product->order_id);
    //     if (!$order) {
    //         throw new CustomException('Order not found', 404);
    //     }
    
    //     $shipment = Shipment::find($order->shipment_id);
    //     if (!$shipment) {
    //         throw new CustomException('Shipment not found', 404);
    //     }
    
    //     if (!is_numeric($data['product_quantity']) || !is_numeric($data['price'])) {
    //         throw new CustomException('Invalid input for product quantity or price', 400);
    //     }
    
    //     $originalValues = [
    //         'quantity' => $product->product_quantity,
    //         'shipping_fees' => $product->product_quantity * $product->shipping_fees,
    //         'currency_profit' => ($product->product_quantity * $product->price * $shipment->customer_currency_price) -
    //                              ($product->product_quantity * $product->price * $shipment->currency_price),
    //         'total_profit' => ($product->product_quantity * $product->shipping_fees) +
    //                           (($product->product_quantity * $product->price * $shipment->customer_currency_price) -
    //                            ($product->product_quantity * $product->price * $shipment->currency_price)),
    //         'total_price' => $product->product_quantity * $product->price + $product->product_quantity * $product->shipping_fees,
    //     ];
    
    //     $newQuantity = $data['product_quantity'];
    //     $quantityDiff = $newQuantity - $originalValues['quantity'];
    //     $isAddition = $quantityDiff > 0;
    //     $adjustedQuantity = abs($quantityDiff);
    
    //     $adjustedValues = [
    //         'quantity' => $adjustedQuantity,
    //         'shipping_fees' => $adjustedQuantity * $product->shipping_fees,
    //         'currency_profit' => ($adjustedQuantity * $product->price * $shipment->customer_currency_price) -
    //                              ($adjustedQuantity * $product->price * $shipment->currency_price),
    //         'total_profit' => ($adjustedQuantity * $product->shipping_fees) +
    //                           (($adjustedQuantity * $product->price * $shipment->customer_currency_price) -
    //                            ($adjustedQuantity * $product->price * $shipment->currency_price)),
    //         'total_price' => $adjustedQuantity * $product->price + $adjustedQuantity * $product->shipping_fees,
    //     ];
    
    //     DB::transaction(function () use ($order, $shipment, $product, $data, $originalValues, $adjustedValues) {
    //         $this->updateEntity($order, $originalValues, $adjustedValues);
    //         $this->updateEntity($shipment, $originalValues, $adjustedValues);
    //         $product->update($data);
    //     });
    
    //     return $product;
    // }
    
    public function updateProduct($id, $data)
    {
        $product = Product::find($id);
    
        if (!$product) {
            throw new CustomException('Product Not Found', 404);
        }
    
        $order = Order::find($product->order_id);
    
        if (!$order) {
            return ['error' => 'Order not found'];
        }
    
        $shipment = Shipment::find($order->shipment_id);
    
        if (!$shipment) {
            return ['error' => 'Shipment not found'];
        }
        // Calculate the quantity difference
        $original_quantity = $product->product_quantity; //2
        $new_quantity = $data['product_quantity']; // 1
        $quantity_diff = $new_quantity - $original_quantity;
        
        // Determine if it's an addition or subtraction
        $is_addition = $quantity_diff > 0; // false
        
        // Calculate the absolute difference for adjustment
        $adjusted_quantity = abs($quantity_diff); // make (-1) = 1
        
        // Shared variables
        $currency_price = $shipment->curreny_price;
        $customer_currency_price = $shipment->customer_currency_price;
        
        $adjusted_shipping_fees = $adjusted_quantity * $product->shipping_fees;
        $adjusted_price = $adjusted_quantity * $product->price;
    
        $adjusted_currency_profit = ($adjusted_quantity * $product->price * $customer_currency_price) - 
                                    ($adjusted_quantity * $product->price * $currency_price);
        
        // original attributes
        $original_shipping_fees = $product->shipping_fees; 
        $original_currency_profit = ($original_quantity * $product->price * $customer_currency_price) - 
                                    ($original_quantity * $product->price * $currency_price);
        $original_shipping_fees_with_quantity = $original_quantity * $original_shipping_fees;
        $original_price = $original_quantity * $product->price;


        //////////////
        $customer_currency_price = $shipment['customer_currency_price'];
        $currency_price = $shipment['currency_price'];

        $price_with_currency = $data['price'] * $customer_currency_price;
        $price_with_quantity = $data['price'] * $data['product_quantity'] * $customer_currency_price;
    
        $data['price_with_currency'] = $price_with_currency;
        $data['price_with_quantity'] = $price_with_quantity;
        //////////////

        $order->update([
            'product_count' => 
            // 3( 2-1 )              2                          1            === 2
            ( $order->product_count - $original_quantity ) + $adjusted_quantity ,
            'shipping_fees_total_profit' =>
            //    300 (200 - 100)                       200                         300                  === 400
                ( $order->shipping_fees_total_profit - $original_shipping_fees ) + $adjusted_shipping_fees, 
            'currency_profit' => 
            //  3000 ( 2000 - 1000)             2000                        3000                   = 4000
                ( $order->currency_profit - $original_currency_profit ) + $adjusted_currency_profit,
            'total_profit' =>
            //  3300 (2200 - 1100)       
                ( $order->total_profit - $original_shipping_fees_with_quantity - $original_currency_profit )
                + $adjusted_shipping_fees + $adjusted_currency_profit,
            'total_price' =>
                ( $order->total_price -$original_shipping_fees_with_quantity - $original_price ) 
                + $adjusted_shipping_fees + $adjusted_price ,
            'updated_at' => now(),
        ]);
    
        $shipment->update([
            'product_count' => 
            // 3( 2-1 )              2                          1            === 2
            ( $shipment->product_count - $original_quantity ) + $adjusted_quantity ,
            'shipping_fees_total_profit' =>
            //    300 (200 - 100)                       200                         300                  === 400
                ( $shipment->shipping_fees_total_profit - $original_shipping_fees ) + $adjusted_shipping_fees, 
            'currency_profit' => 
            //  3000 ( 2000 - 1000)             2000                        3000                   = 4000
                ( $shipment->currency_profit - $original_currency_profit ) + $adjusted_currency_profit,
            'total_profit' =>
            //  3300 (2200 - 1100)       
                ( $shipment->total_profit - $original_shipping_fees_with_quantity - $original_currency_profit )
                + $adjusted_shipping_fees + $adjusted_currency_profit,
            'total_price' =>
                ( $shipment->total_price -$original_shipping_fees_with_quantity - $original_price ) 
                + $adjusted_shipping_fees + $adjusted_price ,
            'updated_at' => now(),
        ]);
    
        // Update product
        $product->update($data);
    
        return $product;
    }
    
    public function delete($id)
    {
        $data = Product::find($id);
        if (!$data){
            throw new CustomException('Resource Not Found',404);
        }
        $order = Order::find($data->order_id);
        if (!$order) {
            return ['error' => 'order not found'];
        }
        
        $shipment = Shipment::find($order->shipment_id);
        if (!$shipment) {
            return ['error' => 'Shipment not found'];
        }
        
        $customer_currency_price = $shipment['customer_currency_price'];
        $currency_price = $shipment['currency_price'];

        $product_quantity = $data['product_quantity'];
        $product_shipping_fees = $product_quantity * $data['shipping_fees'];
        
        $product_price = $product_quantity * $data['price'] * $customer_currency_price;
        
        $product_customer_currency_price = $data['price'] * $product_quantity * $customer_currency_price;
        $product_currency_price = $data['price'] * $product_quantity * $currency_price;
        
        $product_currency_profit = $product_customer_currency_price - $product_currency_price;

        $order->update([
            'product_count' => $order->product_count - $product_quantity,
            'shipping_fees_total_profit' => $order->shipping_fees_total_profit -= $product_shipping_fees,
            'currency_profit' => $order->currency_profit -= $product_currency_profit,
            'total_profit' => $order->total_profit - ( $product_shipping_fees + $product_currency_profit ) ,
            'total_price' => $order->total_price - ( $product_shipping_fees + $product_price ),
            'updated_at' => now(),
        ]);
    

        $shipment->update([
            'product_count' => $shipment->product_count - $product_quantity,
            'shipping_fees_total_profit' => $shipment->shipping_fees_total_profit -= $product_shipping_fees,
            'currency_profit' => $shipment->currency_profit -= $product_currency_profit,
            'total_profit' => $shipment->total_profit - ( $product_shipping_fees + $product_currency_profit ),
            'total_price' => $shipment->total_price - ( $product_shipping_fees + $product_price ),
            'updated_at' => now(),
        ]);

        $data->delete();
        ImageService::delete_image($data->image);

        return ['success' => 'product deleted successfully'];
    }


    
}
