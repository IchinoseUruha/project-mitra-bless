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
        // Filters
        $filter_brands = $request->query('brands', '');
        $filter_categories = $request->query('categories', '');
        $min_price = $request->query('min', 1);
        $max_price = $request->query('max', 100000000);
        $order = $request->query('order', 'desc');

          // Query products dengan get()
        $products = Product::with(['brand', 'category'])
        ->when($filter_brands, function ($query, $filter_brands) {
            $query->whereIn('brand_id', explode(',', $filter_brands));
        })
        ->when($filter_categories, function ($query, $filter_categories) {
            $query->whereIn('kategori_id', explode(',', $filter_categories));
        })
        ->whereBetween('price', [$min_price, $max_price])
        ->orderBy('created_at', $order)
        ->get();  // Menggunakan get() bukan paginate()

        // Query categories and brands for filters
        $categories = Category::all();
        $brands = Brand::all();


        // Mapping products untuk menambahkan image_url
        $products = $products->map(function($product) {
            $imagePathJpg = public_path("uploads/products/{$product->id}.jpg");
            $imagePathPng = public_path("uploads/products/{$product->id}.png");
            if (file_exists($imagePathJpg)) {
                $product->image_url = url("uploads/products/{$product->id}.jpg");
            } elseif (file_exists($imagePathPng)) {
                $product->image_url = url("uploads/products/{$product->id}.png");
            } else {
                $product->image_url = url("images/no-image.jpg");
            }
            return $product;
        });

        return view('shop', compact('products', 'categories', 'brands', 'filter_brands', 'filter_categories', 'min_price', 'max_price', 'order'));
    }

    public function product_details($product_slug)
    {
            // Ambil produk berdasarkan slug
        $product = Product::with(['brand', 'category'])->where('slug', $product_slug)->firstOrFail();

        // Ambil produk terkait dari kategori yang sama
        $relatedProducts = Product::where('kategori_id', $product->kategori_id)
            ->where('id', '<>', $product->id) // Kecualikan produk saat ini
            ->take(8) // Batasi 8 produk terkait
            ->get();

        return view('details', compact('product', 'relatedProducts'));
    }
}
