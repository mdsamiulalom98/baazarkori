@extends('frontEnd.seller.pages.master')
@section('title', 'Product Edit')
@section('css')

    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('seller.products.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Product Edit</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('seller.products.update') }}" method="POST" class=row
                            data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $edit_data->id }}" name="id">
                            <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $edit_data->name }}" id="name" required="" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Categories *</label>
                                <select
                                    class="select2 form-control @error('category_id') is-invalid @enderror"
                                    name="category_id" value="{{ old('category_id') }}" required>
                                    <optgroup>
                                        <option value="">Select..</option>

                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $edit_data->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach

                                    </optgroup>
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="subcategory_id" class="form-label">SubCategories (Optional)</label>
                                <select
                                    class="form-control select2 @error('subcategory_id') is-invalid @enderror"
                                    id="subcategory_id" name="subcategory_id" data-placeholder="Choose ...">
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach ($subcategory as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->subcategoryName }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="childcategory_id" class="form-label">Child Categories (Optional)</label>
                                <select
                                    class="form-control select2 @error('childcategory_id') is-invalid @enderror"
                                    id="childcategory_id" name="childcategory_id" data-placeholder="Choose ...">
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach ($childcategory as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->childcategoryName }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('childcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="brand_id" class="form-label">Brands</label>
                                <select class="form-control select2 @error('brand_id') is-invalid @enderror"
                                    value="{{ old('brand_id') }}" name="brand_id">
                                    <option value="">Select..</option>
                                    @foreach ($brands as $value)
                                        <option value="{{ $value->id }}"
                                            @if ($edit_data->brand_id == $value->id) selected @endif>{{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price *</label>
                                <input type="text" class="form-control @error('purchase_price') is-invalid @enderror"
                                    name="purchase_price" value="{{ $edit_data->purchase_price }}" id="purchase_price"
                                    required />
                                @error('purchase_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="old_price" class="form-label">Old Price *</label>
                                <input type="text" class="form-control @error('old_price') is-invalid @enderror"
                                    name="old_price" value="{{ $edit_data->old_price }}" id="old_price" />
                                @error('old_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="new_price" class="form-label">New Price *</label>
                                <input type="text" class="form-control @error('new_price') is-invalid @enderror"
                                    name="new_price" value="{{ $edit_data->new_price }}" id="new_price" required />
                                @error('new_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="whole_sell_price" class="form-label">Whole Sell Price *</label>
                                <input type="text"
                                    class="form-control @error('whole_sell_price') is-invalid @enderror"
                                    name="whole_sell_price" value="{{ $edit_data->whole_sell_price }}"
                                    id="whole_sell_price" required />
                                @error('whole_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="advance" class="form-label">Advance Payment *</label>
                                <input type="number" max="100" maxlength="3"
                                    class="form-control @error('advance') is-invalid @enderror" name="advance"
                                    value="{{ $edit_data->advance }}" id="advance" />
                                @error('advance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-3">
                            <div class="form-group mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                    name="stock" value="{{ $edit_data->stock }}" id="stock" />
                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        
                        <div class="col-sm-3">
                            <div class="form-group mb-3">
                                <label for="pro_unit" class="form-label">Product Unit (Optional)</label>
                                <input type="text" class="form-control @error('pro_unit') is-invalid @enderror"
                                    name="pro_unit" value="{{ $edit_data->pro_unit }}" id="pro_unit" />
                                @error('pro_unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--end-col-->

                        <div class="col-sm-3 mb-3">
                            <label for="image">Image (750x750px)*</label>
                            <div class="input-group control-group increment">
                                <input type="file" name="image[]"
                                    class="form-control @error('image') is-invalid @enderror" multiple />
                                <div class="input-group-btn">
                                    <button class="btn btn-success btn-increment" type="button"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="clone hide" style="display: none;">
                                <div class="control-group input-group">
                                    <input type="file" name="image[]" class="form-control" multiple />
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button"><i
                                                class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="product_img">
                                @foreach ($edit_data->images as $image)
                                    <img src="{{ asset($image->image) }}" class="edit-image border"
                                        alt="" />
                                    <a href="{{ route('products.image.destroy', ['id' => $image->id]) }}"
                                        class="btn btn-xs btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-close"></i></a>
                                @endforeach
                            </div>
                        </div>
                        <!-- col end -->
                        
                        <div class="col-sm-3">
                            <div class="form-group mb-3">
                                <label for="pro_video" class="form-label">Product Video (Optional)</label>
                                <input type="text" class="form-control @error('pro_video') is-invalid @enderror"
                                    name="pro_video" value="{{ $edit_data->pro_video }}" id="pro_video" />
                                @error('pro_video')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- end-col -->
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="warranty" class="form-label">Warranty Note (Optional)</label>
                                <select name="warranty" class="form-control select2">
                                    <option value="no warranty" {{$edit_data->warranty =='no warranty'? 'selected' : ''}}>No Warranty</option>
                                    <option value="7 days warranty" {{$edit_data->warranty =='7 days warranty'? 'selected'  : ''}}>7 Days Warranty</option>
                                    <option value="30 days warranty" {{$edit_data->warranty =='30 days warranty'? 'selected' : ''}}>30 Days Warranty</option>
                                    <option value="365 days warranty" {{$edit_data->warranty =='365 days warranty'? 'selected' : ''}}>365 Days Warranty</option>
                                    <option value="money back guaranty" {{$edit_data->warranty =='money back guaranty'? 'selected' : ''}}>Money Back Guaranty</option>
                                </select>
                            </div>
                        </div>
                        <!--end-col-->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="roles" class="form-label">Size (Optional)</label>
                                <select class="form-control select2" name="proSize[]" multiple="multiple">
                                    <option value="">Select</option>
                                    @foreach ($totalsizes as $totalsize)
                                        <option value="{{ $totalsize->id }}"
                                            @foreach ($selectsizes as $selectsize) @if ($totalsize->id == $selectsize->size_id)selected="selected"@endif @endforeach>
                                            {{ $totalsize->sizeName }}</option>
                                    @endforeach
                                </select>

                                @error('sizes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="color" class="form-label">Color (Optional)</label>
                                <select class="form-control select2" name="proColor[]" multiple="multiple">
                                    <option value="">Select..</option>
                                    @foreach ($totalcolors as $totalcolor)
                                        <option value="{{ $totalcolor->id }}"
                                            @foreach ($selectcolors as $selectcolor) @if ($totalcolor->id == $selectcolor->color_id) selected="selected" @endif @endforeach>
                                            {{ $totalcolor->colorName }} </option>
                                    @endforeach
                                </select>
                                @error('colors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--end-col-->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="specification" class="form-label">Specification (Optional)</label>
                                <textarea name="specification" rows="6"
                                    class="summernote form-control @error('specification') is-invalid @enderror">{{ $edit_data->specification }}</textarea>
                                @error('specification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="6"
                                    class="summernote form-control @error('description') is-invalid @enderror">{{ $edit_data->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="sort_description" class="form-label">Short Description</label>
                                <textarea name="sort_description" rows="6"
                                    class="summernote form-control @error('sort_description') is-invalid @enderror">{{ $edit_data->sort_description }}</textarea>
                                @error('sort_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                            <div>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-increment").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });
            $(".select2").select2();
        }); 
    </script>
    <script>
        // category to sub
    $("#category_id").on("change", function() {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{ url('ajax-product-subcategory') }}?category_id=" + ajaxId,
                success: function(res) {
                    if (res) {
                        $("#subcategory_id").empty();
                        $("#subcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function(key, value) {
                            $("#subcategory_id").append('<option value="' + key + '">' +
                                value + "</option>");
                        });
                    } else {
                        $("#subcategory_id").empty();
                    }
                },
            });
        } else {
            $("#subcategory_id").empty();
        }
    });

    // subcategory to childcategory
    $("#subcategory_id").on("change", function() {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{ url('ajax-product-childcategory') }}?subcategory_id=" + ajaxId,
                success: function(res) {
                    if (res) {
                        $("#childcategory_id").empty();
                        $("#childcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function(key, value) {
                            $("#childcategory_id").append('<option value="' + key + '">' +
                                value + "</option>");
                        });
                    } else {
                        $("#childcategory_id").empty();
                    }
                },
            });
        } else {
            $("#childcategory_id").empty();
        }
    });
    </script>
    <script>
        document.forms["editForm"].elements["category_id"].value = "{{ $edit_data->category_id }}";
        document.forms["editForm"].elements["subcategory_id"].value = "{{ $edit_data->subcategory_id }}";
        document.forms["editForm"].elements["childcategory_id"].value = "{{ $edit_data->childcategory_id }}";
    </script>

    @endpush
