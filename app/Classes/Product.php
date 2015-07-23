<?php namespace App\Classes;
use App\Classes\Image;
use App\Classes\Globals;
use App\Classes\Customer;
use App\Classes\Admin;
use DB;
use Config;
use Session;

class Product
{
    public static function get_cart_content()
    {
        $_cart = Session::get("cart");
        $data["total_price"] = 0;

        if($_cart)
        {
            $ctr = 0;
            foreach($_cart as $variation_id => $cart)
            {
                $product_info = Product::cart_product_info($variation_id);

                if($product_info)
                {
                    $discount = ($cart["discount"]/100);
                    $discount_rate = ($product_info->variation_price * $cart["quantity"]) * $discount;
                    $attribute = $product_info->variation_attribute;
                    $data["cart_item"][$ctr]["product_description"] = $product_info->product_name . ($attribute == "simple" ? "" : " ($attribute)");
                    $data["cart_item"][$ctr]["variation_id"] = $variation_id;
                    $data["cart_item"][$ctr]["product_id"] = $cart["product_id"];
                    $data["cart_item"][$ctr]["quantity"] = $cart["quantity"];
                    $data["cart_item"][$ctr]["product_name"] = $product_info->product_name;

                    $data["cart_item"][$ctr]["price"] = $product_info->price;
                    $data["cart_item"][$ctr]["raw_price"] = $product_info->raw_price;
                    
                    $data["cart_item"][$ctr]["total_no_discount"] = Product::currency_format($product_info->raw_price * $cart["quantity"]);     
                    $data["cart_item"][$ctr]["total"] = Product::currency_format(($product_info->raw_price * $cart["quantity"]) - $discount_rate);     
                    $data["cart_item"][$ctr]["raw_total"] = ($product_info->raw_price * $cart["quantity"]) - $discount_rate;     
                    $data["cart_item"][$ctr]["discount"] = $discount_rate;
                    $data["cart_item"][$ctr]["show_discount"] = Product::currency_format($discount_rate);
                    $data["cart_item"][$ctr]["discount_percentage"] = intval($cart["discount"]) . "%";

                    


                    if($product_info->variation_image == "default.jpg")
                    {
                         $data["cart_item"][$ctr]["image"] = Image::view($product_info->product_main_image, "60x60");   
                    }
                    else
                    {
                         $data["cart_item"][$ctr]["image"] = Image::view($product_info->variation_image, "60x60");
                    }
                   

                    $data["cart_item"][$ctr]["coupon_code"] = $cart["coupon_code"];
                    $data["total_price"] += ($product_info->raw_price * $cart["quantity"]) - $discount_rate;
                    $ctr++;
                }
            }
        }
        else
        {
            $data["cart_item"] = null;
        }
        $data["raw_total_price"] = $data["total_price"];

        $data["total_price"] = Product::currency_format($data["total_price"]);
        return $data;
    }
    public static function cart_product_info($variation_id)
    {
        $variation = DB::table("tbl_product_variation")     ->where("variation_id", $variation_id)
                                                            ->join("tbl_product", "tbl_product.product_id", "=", "tbl_product_variation.product_id")
                                                            ->first();
        if($variation)
        {
            $discount = Product::check_if_qualified_for_discount($variation_id);
            if($discount)
            {
                $variation->price = Product::currency_format($discount->price); 
                $variation->raw_price = $discount->price;
            }
            else
            {
                $variation->price = Product::currency_format($variation->variation_price); 
                $variation->raw_price = $variation->variation_price;
            }
        }
        else
        {
            $variation = null;
        }

        return $variation;
    }
    public static function product_list_additional_data($_product)
    {
        $return = null;

        foreach($_product as $key => $product)
        {
            $return[$key] = Product::product_additional_data($product);
        }

        return $return;
    }
    public static function product_additional_data($product)
    {
        $variation_info = Product::get_variation_info($product->product_id);
        $return = $product;
        $return->image = Image::view($product->product_main_image, "222x222");
        $return->preview = Image::view($product->product_main_image, "318x318");
        $return->single_image = Image::view($product->product_main_image, "435x435");
        $return->big_image = Image::view($product->product_main_image, "1000x1000");
        $return->attributes = Product::get_attributes($product->product_id);
        $return->variations = Product::get_variation($product->product_id);
        
        $discount = Product::check_if_qualified_for_discount($product->variation_id);
        if($discount)
        {
            $return->variation_price = $discount->price;
            $return->show_price = "<span class='discounted'>" . Product::currency_format($discount->real_price) . "</span> " . Product::currency_format($discount->price);
        }
        else
        {
            $return->variation_price = $return->variation_price;
            $return->show_price = Product::currency_format($product->variation_price);
        }


        $return->rating = Product::get_stars($product->product_rating,$product->product_id);
        // $return[$key]->no_format_price = $variation_info->variation_price;
        $return->category = Product::get_categories($product->product_id);

        return $return;
    }
    public static function check_if_qualified_for_discount($variation_id)
    {
        $check_discount = DB::table("rel_discount") ->where("variation_id", $variation_id)
                                                    ->where("tbl_discount.discount_start_date", "<", Globals::get_time())
                                                    ->where("tbl_discount.discount_end_date", ">", Globals::get_time())
                                                    ->join("tbl_discount", "tbl_discount.discount_id", "=", "rel_discount.discount_id")
                                                    ->first();
        return $check_discount;
    }
    public static function get_categories($product_id)
    {


        $_categories = DB::table('rel_product_type')
                            ->select('rel_product_type.*', 'tbl_product_type.product_type_name')
                            ->leftJoin('tbl_product_type','tbl_product_type.product_type_id', '=','rel_product_type.product_type_id' )
                            ->where('rel_product_type.product_id','=',$product_id)->get();

        $categories = null;
        if($_categories)
        {
            foreach ($_categories as $key => $category)
            {
                // $categories[$key] = $category;
                $categories[] = '<a href="/product?type='.$category->product_type_id.'">'.$category->product_type_name.'</a>';
            }

            $categories = implode(", ", $categories);

        }
        else
        {
              $categories = '<a href="/product">Uncategorized</a>';
        }

        return $categories;
        
    }
    public static function get_variation($product_id)
    {
        $_variation = DB::table("tbl_product_variation")->where("product_id", $product_id)->get();

        foreach($_variation as $key => $variation)
        {
            $return[$key] = $variation;
            $return[$key]->show_price = Product::currency_format($variation->variation_price); 
            $return[$key]->single_image = Image::view($variation->variation_image, "435x435"); 
            $return[$key]->big_image = Image::view($variation->variation_image, "1000x1000"); 
        }

        return json_encode($return);
    }
    public static function get_attributes($product_id)
    {
        $_attribute = DB::table("tbl_product_attribute")->where("product_id", $product_id)->get();

        if($_attribute)
        {
            foreach($_attribute as $key => $attribute)
            {
                $return[$key] = $attribute;
                $return[$key]->options = Product::get_options($attribute->attribute_id);
            }
        }
        else
        {
            $return = null;
        }

        return json_encode($return);
    }

    public static function get_options($attribute_id)
    {
        $_options = DB::table("tbl_product_attribute_option")->where("attribute_id", $attribute_id)->get();
        return $_options;
    }

    public static function get_stars($prod_rating,$product_id)
    {

        $stars = round($prod_rating);

        $votes = DB::table('tbl_product_rating')->where('product_id','=',$product_id)->count();

        $return = '';

        for($ctr = 1; $ctr <= 5; $ctr++)
        {
            if($ctr <= $stars)
            {
                $return .= '<div class="feature-star active-star"></div>';   
            }
            else
            {
                $return .= '<div class="feature-star nonactive"></div>';   
            }
            
        }
        
        $return .= '';

        return $return;
    }
        public static function get_stars_search($prod_rating,$product_id)
    {

        $stars = round($prod_rating);

        $votes = DB::table('tbl_product_rating')->where('product_id','=',$product_id)->count();

        $return = '';

        for($ctr = 1; $ctr <= 5; $ctr++)
        {
            if($ctr <= $stars)
            {
                $return .= '<div class="star"></div>';   
            }
            else
            {
                $return .= '<div class="nostar"></div>';   
            }
            
        }
        
        $return .= '';

        return $return;
    }
    public static function get_variation_info($product_id)
    {
        $variation_info = DB::table("tbl_product_variation")    ->select(DB::raw('*, SUM(variation_stock_qty) as total_stock, COUNT(variation_id) as variation_count')) 
                                                                ->where("product_id", $product_id)
                                                                ->groupBy("product_id")
                                                                ->first();



        return $variation_info;
    }
    public static function currency_format($price)
    {
        $currency = Config::get('app.currency');
        return "$currency " . number_format($price, 2);
    }
    public static function retrieve_orders($customer_id)
    {
        $_order = DB::table("tbl_order")->where("order_by", $customer_id)->orderBy("order_id", "desc")->get();
        $return = null;

        foreach($_order as $key => $order)
        {
            $return[$key] = $order;
            $return[$key]->amount = Product::currency_format($order->order_total);
            $return[$key]->order_date = Globals::show_time($order->order_date, "F d, Y");
            $return[$key]->arrival_date = Globals::show_time($order->order_date, "F d, Y");
        }
        return $return;
    }


    public static function get_product_images($prod_id)
    {   
        $main_image = null;
        $image = DB::table('tbl_product')->select('product_main_image')->where('product_id','=',$prod_id)->first();
        $_images = DB::table('tbl_product_images')->select('product_image')->where('product_id','=',$prod_id)->get();
        /*
        *   get the main image
        */
        foreach($image as $image)
        {
            $main_image = $image;
        }

        /*
        *   add the main image to the $_image_links[]
        */
        if($main_image=="default.jpg")
        {
            $_image_links[] = array(

            'filename'=>'default.jpg',
            'full'=>'resources/assets/img/1428733091.jpg',
            'thumb'=>'resources/assets/img/1428733091.jpg'
            );
        }
        else
        {
            $_image_links[] = array(

            'filename'=>$main_image,
            'full'=>Image::view($main_image,'460x334'),
            'thumb'=>Image::view($main_image,'100x100')
            );
        }


        /*
        *   if the product has other images, add to $_image_links[]
        */
        if($_images)
        {
            foreach ($_images as $_image)
            {
                $_image_links[] =  array(

                    'filename'=>$_image->product_image,
                    'full'=>Image::view($_image->product_image,'460x334'),
                    'thumb'=>Image::view($_image->product_image,'100x100'),

                    );  

            }
        }

        return $_image_links;
    }


    public static function get_user_product_rating($user_id, $prod_id)
    {
        $user_rating = DB::table('tbl_product_rating')  ->where('customer_id','=',$user_id)
                                                 ->where('product_id','=',$prod_id)
                                                 ->first();


        if($user_rating)
        {
            return $user_rating->product_rating;
        }
        else
        {
            return 0;
        }
        
    }
    public static function quantity_subtract($order_id)
    {

                 $data["inventory"] = DB::table('tbl_order_product')->select("tbl_product.product_name","tbl_product_variation.*","tbl_order_product.*")
                                                        ->leftJoin('tbl_product','tbl_product.product_id','=','tbl_order_product.product_id')
                                                        ->leftJoin('tbl_product_variation','tbl_order_product.variation_id','=','tbl_product_variation.variation_id')
                                                        // ->leftJoin('tbl_product','tbl_product_variation.product_id','=','tbl_product_variation.product_id')
                                                        ->where('order_id','=',$order_id)
                                                        ->groupBy('tbl_product_variation.variation_id')
                                                        ->get();

                                        foreach($data["inventory"] as $order)
                                        {
                                            $quantity = $order->variation_stock_qty - $order->quantity;

                                            DB:: table ('tbl_product_variation') -> where('variation_id','=',$order->variation_id)
                                                                                  -> update(['variation_stock_qty'=>$quantity]);
                                            $quantity_minus = '-'.$order->quantity;
                                            $insertlog['order_id'] = $order_id;
                                            $insertlog['variation_id'] = $order->variation_id;
                                            $insertlog['inventory_log'] = intval($quantity_minus);
                                            $insertlog['added_at'] = Globals::get_time();
                                            $customer = Customer::info();
                                            $insertlog['description'] = 'Ordered by customer_id#'.$customer->customer_id.', name: '.$customer->customer_name.', email: '.$customer->customer_email;

                                            DB::table('tbl_inventory_log')->insert($insertlog);
                        

                                        }

    }
     public static function quantity_add($order_id, $user = null )
    {

                 $data["inventory"] = DB::table('tbl_order_product')->select("tbl_product.product_name","tbl_product_variation.*","tbl_order_product.*")
                                                        ->leftJoin('tbl_product','tbl_product.product_id','=','tbl_order_product.product_id')
                                                        ->leftJoin('tbl_product_variation','tbl_order_product.variation_id','=','tbl_product_variation.variation_id')
                                                        // ->leftJoin('tbl_product','tbl_product_variation.product_id','=','tbl_product_variation.product_id')
                                                        ->where('order_id','=',$order_id)
                                                        ->groupBy('tbl_product_variation.variation_id')
                                                        ->get();

                                        foreach($data["inventory"] as $order)
                                        {
                                            $quantity = $order->variation_stock_qty + $order->quantity;

                                             DB:: table ('tbl_product_variation') -> where('variation_id','=',$order->variation_id)
                                                                                  -> update(['variation_stock_qty'=>$quantity]);
                                        
                                            if($user=="admin")
                                            {
                                                
                                                $admin = Admin::info();
                                                $insertlog['description'] = 'Cancelled by admin_id#'.$admin->admin_id.', name: '.$admin->admin_name;
                                            }
                                            else
                                            {
                                                $customer = Customer::info();
                                                $insertlog['description'] = 'Cancelled by customer_id#'.$customer->customer_id.', name: '.$customer->customer_name.', email: '.$customer->customer_email;
                                            }


                                            $quantity_plus = '+'.$order->quantity;
                                            $insertlog['order_id'] = $order_id;
                                            $insertlog['variation_id'] = $order->variation_id;
                                            $insertlog['inventory_log'] = intval($quantity_plus);
                                            $insertlog['added_at'] = Globals::get_time();


                                            DB::table('tbl_inventory_log')->insert($insertlog);




                                        }



    }


    public static function return_format_num($val)
    {
        return number_format($val, 2, '.',',');
    }

}