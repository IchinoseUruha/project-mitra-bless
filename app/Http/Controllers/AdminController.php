<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;


class AdminController extends Controller
{
    public function index(){

        return view('admin.index');
    }

    public function brands(){

        $brands = Brand::orderBy('id', 'asc')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand(){

        return view('admin.brand-add');
    }

    public function brand_store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brand,slug'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Brand has been added succesfully!');


    }

    public function brand_edit($id){

        $brand = Brand::find($id);
        return view('admin.brand-edit', compact("brand"));
    }

    public function brand_update(Request $request){
            
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brand,slug,'.$request->id
        ]); 

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        $brand->save();

        return redirect()->route('admin.brands')->with('status', 'Brand has been updated succesfully!');
 

    }

    public function brand_delete($id){

        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand has been deleted successfully!');
    }

    public function categories(){

        $categories = Category::orderBy('id', "asc")->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category(){

        return view('admin.category-add');
    }

    public function category_store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:kategori,slug'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Category has been added succesfully!');
    }

    public function category_edit($id){

        $category = Category::find($id);
        return view('admin.category-edit', compact("category"));
    }

    public function category_update(Request $request){
            
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:kategori,slug,'.$request->id
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $category->save();

        return redirect()->route('admin.categories')->with('status', 'Category has been updated succesfully!');
 

    }

    public function category_delete($id){

        $category = Category::find($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully!');
    }


    public function products(){

        $products = Product::orderBy('created_at', 'asc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_product(){

        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();

        return view('admin.product-add', compact('categories', 'brands'));
    }


    public function product_store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "slug" => 'required|unique:produk,slug',
            "description" => 'required',
            "price" => 'required',
            "stock_status" => 'required',
            "quantity" => 'required',
            "image" => 'required|mimes:png,jpg,jpeg|max:2048',
            "kategori_id" => 'required',
            "brand_id" => 'required'
        ]);
    
        // Pastikan direktori ada
        $paths = [
            public_path('uploads/products'),
            public_path('uploads/products/thumbnails')
        ];
    
        foreach ($paths as $path) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }
    
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_status = $request->stock_status;
        $product->quantity = $request->quantity;
        $product->kategori_id = $request->kategori_id;
        $product->brand_id = $request->brand_id;
    
        $current_timestamp = Carbon::now()->timestamp;
    
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImage($image, $imageName);
            
            // Simpan path gambar ke database
            $product->image_path = 'uploads/products/' . $imageName;
            $product->gallery_path = 'uploads/products/thumbnails/' . $imageName;
        }
    
        $product->save();
        
        return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
    }
    public function product_edit($id){

        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('categories', 'brands', 'product'));
    }

    public function product_update(Request $request)
{
   try {
       // Debug request
       \Log::info('Update request:', $request->all());
       
       $request->validate([
           "name" => 'required',
           "slug" => 'required|unique:produk,slug,'.$request->id,
           "description" => 'required', 
           "price" => 'required',
           "stock_status" => 'required',
           "quantity" => 'required',
           "image" => 'mimes:png,jpg,jpeg|max:2048',
           "kategori_id" => 'required',
           "brand_id" => 'required'
       ]);

       $product = Product::findOrFail($request->id);
       $product->name = $request->name;
       $product->slug = Str::slug($request->name);
       $product->description = $request->description;
       $product->price = $request->price;
       $product->stock_status = $request->stock_status;
       $product->quantity = $request->quantity;
       $product->kategori_id = $request->kategori_id;
       $product->brand_id = $request->brand_id;
       
       if($request->hasFile('image')) {
           \Log::info('Processing image for product: ' . $product->id);
           
           // Cek direktori
           $destinationPath = public_path('uploads/products');
           $destinationPathThumbnail = public_path('uploads/products/thumbnails');
           
           if (!File::isDirectory($destinationPath)) {
               File::makeDirectory($destinationPath, 0755, true);
           }
           if (!File::isDirectory($destinationPathThumbnail)) {
               File::makeDirectory($destinationPathThumbnail, 0755, true);
           }

           // Debug path dan permissions
           \Log::info('Directory path: ' . $destinationPath);
           \Log::info('Directory exists: ' . File::exists($destinationPath));
           \Log::info('Directory writable: ' . is_writable($destinationPath));
           
           // Hapus gambar lama
           if($product->image_path) {
               File::delete(public_path($product->image_path));
               File::delete(public_path($product->gallery_path));
           }

           // Upload dan simpan gambar baru
           $image = $request->file('image');
           $imageName = Carbon::now()->timestamp . '.' . $image->extension();
           
           $this->GenerateProductThumbnailsImage($image, $imageName);
           
           // Update path di database
           $product->image_path = 'uploads/products/' . $imageName;
           $product->gallery_path = 'uploads/products/thumbnails/' . $imageName;
       }

       // Debug before save
       \Log::info('Product data before save:', $product->toArray());
       
       $saved = $product->save();
       \Log::info('Save result: ' . ($saved ? 'success' : 'failed'));

       return redirect()->route('admin.products')
           ->with('status', 'Product has been Updated Successfully');
           
   } catch (\Exception $e) {
       \Log::error('Error in product update: ' . $e->getMessage());
       \Log::error('Stack trace: ' . $e->getTraceAsString());
       return back()->with('error', 'Error updating product: ' . $e->getMessage());
   }
}
      public function product_delete($id)
    {
        $product = Product::find($id);
        if(File::exists(public_path('uploads/products').'/'.$product->image))
        {
            File::delete(public_path('uploads/products'.'/'.$product->image));
        }
        if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image))
        {
            File::delete(public_path('uploads/products/thumbnails'.'/'.$product->image));
        }

        foreach(explode(',', $product->images) as $ofile)
        {
            if(File::exists(public_path('uploads/products').'/' .$ofile))
                {
                    File::delete(public_path('uploads/products').'/' .$ofile);
                }
            if(File::exists(public_path('uploads/products/thumbnails').'/' .$ofile))
                {
                    File::delete(public_path('uploads/products/thumbnails').'/' .$ofile);
                }
        }

        
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been Deleted Successfully');
    }


    public function GenerateProductThumbnailsImage($image, $imageName){

        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());

        $img->cover(540,689,"top");
        $img->resize(540,689,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);

        $img->resize(104,104,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);
    }   

    public function showDaftarPemesanan(){
        // Menggunakan model Order seperti cara Product digunakan di showKasir
        $orders = OrderItem::orderBy('id','desc') 
        ->paginate(10);  // Menampilkan 10 item per halaman

    return view('admin.pemesanan', compact('orders'));
    }

    public function showDaftarCustomer() {
        $users = User::whereIn('utype', ['customer_b', 'customer_r'])->paginate(10);
        return view('admin.daftarCustomer', compact('users'));
    }

}
