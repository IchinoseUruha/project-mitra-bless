<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        {
            // Filters
            $filter_brands = $request->query('brands', '');
            $filter_categories = $request->query('categories', '');
            $min_price = $request->query('min', 1);
            $max_price = $request->query('max', 100000000);
            $size = $request->query('size', 12);
            $order = $request->query('order', 'desc');
            
            // Query products
            $products = Product::with(['brand', 'category'])
                ->when($filter_brands, function ($query, $filter_brands) {
                    $query->whereIn('brand_id', explode(',', $filter_brands));
                })
                ->when($filter_categories, function ($query, $filter_categories) {
                    $query->whereIn('kategori_id', explode(',', $filter_categories));
                })
                ->whereBetween('price', [$min_price, $max_price])
                ->orderBy('created_at', $order)
                ->paginate($size);
    
            // Query categories and brands for filters
            $categories = Category::all();
            $brands = Brand::all();
    
            return view('shop', compact('products', 'categories', 'brands', 'filter_brands', 'filter_categories', 'min_price', 'max_price', 'size', 'order'));
        }
    
         // switch($order)
        // {
        //     case 1:
        //         $order_column = "created_at";
        //         $order_order = "DESC";
        //         break;
        //     case 2:
        //         $order_column = "created_at";
        //         $order_order = "ASC";
        //         break;
        //     case 3:
        //         $order_column = "sale_price";
        //         $order_order = "ASC";
        //         break;
        //     case 4:
        //         $order_column = "sale_price";
        //         $order_order = "DESC";
        //         break;
        //     case 5:
        //         $order_column = "name";
        //         $order_order = "ASC";
        //         break;
        //     case 6:
        //         $order_column = "name";
        //         $order_order = "DESC";
        //         break;
        //     default:
        //         $order_column = "id";
        //         $order_order = "DESC";
        // }
    }

    public function product_details($product_slug)
{
    $product = Product::where('slug', $product_slug)->first(); // Use product model
    $product = Product::with(['brand', 'category'])->where('slug', $product_slug)->firstOrFail();
    $relatedproduct = Product::where('slug', '<>', $product->slug)->take(8)->get(); // Use product model

    return view('details', compact('product', 'relatedproduct'));
}

}
