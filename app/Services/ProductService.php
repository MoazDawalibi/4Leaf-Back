<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use App\Services\Base\BaseService;

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
            $data = Product::with('orders')
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
            'shipping_fees_total_profit' => $order->shipping_fees_total_profit + $product_shipping_fees,
            'currency_profit' => $order->currency_profit + $product_currency_profit,
            'total_profit' => $order->total_profit + $product_shipping_fees + $product_currency_profit,
            'total_price' => $order->total_price + $product_shipping_fees + $product_price,
            'updated_at' => now(),
        ]);
    

        $shipment->update([
            'shipping_fees_total_profit' => $shipment->shipping_fees_total_profit + $product_shipping_fees,
            'currency_profit' => $shipment->currency_profit + $product_currency_profit,
            'total_profit' => $shipment->total_profit + $product_shipping_fees + $product_currency_profit,
            'total_price' => $shipment->total_price + $product_shipping_fees + $product_price,
            'updated_at' => now(),
        ]);
    
        return $product;
    }
    

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
        $original_quantity = $product->product_quantity;
        $new_quantity = $data['product_quantity'];
        $quantity_diff = $new_quantity - $original_quantity;
    
        // Determine if it's an addition or subtraction
        $is_addition = $quantity_diff > 0;
    
        // Calculate the absolute difference for adjustment
        $adjusted_quantity = abs($quantity_diff);
    
        // Shared variables
        $currency_price = $shipment->curreny_price;
        $customer_currency_price = $shipment->customer_currency_price;
    
        $adjusted_shipping_fees = $adjusted_quantity * $product->shipping_fees;
        $adjusted_price = $adjusted_quantity * $product->price;
    
        $adjusted_currency_profit = ($adjusted_quantity * $product->price * $customer_currency_price) - 
                                     ($adjusted_quantity * $product->price * $currency_price);
    
        // Update `order` and `shipment` based on whether it's an addition or subtraction
        $order->update([
            'product_count' => $is_addition 
                ? $order->product_count + $adjusted_quantity 
                : $order->product_count - $adjusted_quantity,
            'shipping_fees_total_profit' => $is_addition 
                ? $order->shipping_fees_total_profit + $adjusted_shipping_fees 
                : $order->shipping_fees_total_profit - $adjusted_shipping_fees,
            'currency_profit' => $is_addition 
                ? $order->currency_profit + $adjusted_currency_profit 
                : $order->currency_profit - $adjusted_currency_profit,
            'total_profit' => $is_addition 
                ? $order->total_profit + $adjusted_shipping_fees + $adjusted_currency_profit 
                : $order->total_profit - $adjusted_shipping_fees - $adjusted_currency_profit,
            'total_price' => $is_addition 
                ? $order->total_price + $adjusted_shipping_fees + $adjusted_price 
                : $order->total_price - $adjusted_shipping_fees - $adjusted_price,
            'updated_at' => now(),
        ]);
    
        $shipment->update([
            'shipping_fees_total_profit' => $is_addition 
                ? $shipment->shipping_fees_total_profit + $adjusted_shipping_fees 
                : $shipment->shipping_fees_total_profit - $adjusted_shipping_fees,
            'currency_profit' => $is_addition 
                ? $shipment->currency_profit + $adjusted_currency_profit 
                : $shipment->currency_profit - $adjusted_currency_profit,
            'total_profit' => $is_addition 
                ? $shipment->total_profit + $adjusted_shipping_fees + $adjusted_currency_profit 
                : $shipment->total_profit - $adjusted_shipping_fees - $adjusted_currency_profit,
            'total_price' => $is_addition 
                ? $shipment->total_price + $adjusted_shipping_fees + $adjusted_price 
                : $shipment->total_price - $adjusted_shipping_fees - $adjusted_price,
            'updated_at' => now(),
        ]);
    
        // Update product
        $product->update($data);
    
        return $product;
    }
    

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product){
            throw new CustomException('Resource Not Found',404);
        }
    
        $order = Order::find($product->order_id);
    
        if (!$order) {
            return ['error' => 'order not found'];
        }
    
        $order->update([
            'order_count'=>$order->order_count - $product->quantity,
            'updated_at' => now(), 
        ]);

        $deleted = Product::where("id", $id)->delete();
        return [];
    }
    
}
