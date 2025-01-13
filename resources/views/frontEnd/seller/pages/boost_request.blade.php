@extends('frontEnd.seller.pages.master')
@section('title', 'Seller Boosting Request')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('seller.boost') }}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Boosting Request</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('seller.boost_store')}}" method="POST" data-parsley-validate="" class="row">
                        @csrf
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="type" class="form-label">Boost Type</label>
                                <select class="form-control select2 @error('type') is-invalid @enderror"
                                    id="product_type" name="type">
                                    <option value="1">Boost Profile</option>
                                    <option value="0">Boost Product</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="day" class="form-label">Days</label>
                                <input class="form-control @error('day') is-invalid @enderror" type="number" name="day" id="day" value="{{ old('day') }}" placeholder="Enter Type Days" required />
                                @error('day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Amount ( USD )</label>
                                <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Enter your amount " required />
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="col-sm-3">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Package *</label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id" value="{{ old('category_id') }}" id="category_id" required>
                                    <option value="">Select Our Any Package.......</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->boost_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->


                        <div class="col-sm-4">
                            <div id="boost_links_container">
                                <div class="form-group mb-3 boost-link-row">
                                    <label for="boost_link_0" class="form-label">Boost Link</label>
                                    <div class="d-flex">
                                        <input class="form-control @error('boost_link.0') is-invalid @enderror" type="text" name="boost_link[]" id="boost_link_0" value="{{ old('boost_link.0') }}" placeholder="Enter Boost link" required />
                                        <button type="button" class="btn btn-success ms-2 add-boost-link">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    @error('boost_link.0')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-4">
                          <div class="variable_product" style="display:none">
                            <div class="form-group">
                                <label for="profile_access" class="form-label">Profile Access (Id, User, Password) *</label>
                                <textarea type="text" class="summernote form-control @error('profile_access') is-invalid @enderror" 
                                       name="profile_access" value="{{ old('profile_access') }}" id="profile_access" /></textarea>
                                @error('profile_access')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                          </div>
                        </div>
                        <!--variable product end-->



                        <div class="col-sm-12">
                            <div class="form-group my-2 text-center">
                                 <button type="submit" class="btn btn-success"> Submit </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            flatpickr(".flatdate", {});
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productType = document.getElementById('product_type');
        const variableProductSection = document.querySelector('.variable_product');

        // Initial check
        toggleVariableProduct(productType.value);

        // On change event
        productType.addEventListener('change', function () {
            toggleVariableProduct(this.value);
        });

        function toggleVariableProduct(value) {
            if (value === '0') { // Variable Product
                variableProductSection.style.display = 'block';
            } else { // Normal Product
                variableProductSection.style.display = 'none';
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const boostLinksContainer = document.getElementById('boost_links_container');

        // Add new input field
        boostLinksContainer.addEventListener('click', function (e) {
            if (e.target.closest('.add-boost-link')) {
                const currentRow = e.target.closest('.boost-link-row');
                const newRow = currentRow.cloneNode(true);

                // Clear the value of the cloned input
                const newInput = newRow.querySelector('input');
                newInput.value = '';
                newInput.id = `boost_link_${Date.now()}`;

                // Change add button to remove button
                const addButton = newRow.querySelector('.add-boost-link');
                addButton.classList.remove('btn-success', 'add-boost-link');
                addButton.classList.add('btn-danger', 'remove-boost-link');
                addButton.innerHTML = '<i class="fa fa-trash"></i>';

                boostLinksContainer.appendChild(newRow);
            }

            // Remove input field
            if (e.target.closest('.remove-boost-link')) {
                const rowToDelete = e.target.closest('.boost-link-row');
                rowToDelete.remove();
            }
        });
    });
</script>


@endpush
