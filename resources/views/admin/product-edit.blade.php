@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.product.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $product->id }}" />
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name"
                        name="name" tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug"
                        name="slug" tabindex="0" value="{{ $product->slug }}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Choose category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </fieldset>
                    @error('category_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Choose Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? "selected" : "" }}>{{ $brand->name }}</option>
                                @endforeach
                              
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                </div>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description"
                        tabindex="0" aria-required="true" required="">{{ $product->description }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the
                        product name.</div>
                </fieldset>
                @error('description') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                class="effect8" alt="{{ $product->name }}">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="regular_price" tabindex="0" value="{{ $product->regular_price }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('regular_price') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{ $product->quantity }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('quantity') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </div>
                
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update Product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection



@push('scripts')

    <script>
        $(function(){
            $("#myFile").on("change", function(e){
                const photoInp = $("#myFile");
                const [file] = this.files;
                if(file){
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change", function(e){
            const photoInp = $("#gFile");
            const gPhotos = this.files;
            $.each(gPhotos, function(key, val){
                $("#galUpload").prepend('<div class="item gitems"><img src="' + URL.createObjectURL(val) + '"/></div>');
            });
            
            });


            $("input[name='name']").on("change", function(){
                $("input[name:'slug']").val(StringToSlug($(this).val()));
            });
        });

        function StringToSlug(Text){
            return Text.toLowerCase()
            .replace(/[^\w ]+/g,"")
            .replace(/ +/g,"-");
        }
    </script>

@endpush