@extends('frontEnd.layouts.master')
@section('title','Customer Boosting Request')
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
<section class="customer-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="customer-sidebar">
                    @include('frontEnd.layouts.customer.sidebar')
                </div>
            </div>
            <div class="col-sm-9">
                <div class="customer-content">
            
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box row">
                            <div class="col-sm-text-end">
                                <a href="{{ route('customer.boostc') }}" class="btn btn-primary rounded-pill">History</a>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="page-title">Boosting Request</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('customer.boostc_store')}}" method="POST" data-parsley-validate="" class="row">
                                    @csrf
                                    <div class="admin-link">
                                        <div class="reseller-code mt-0 btn-grads">
                                            <span>Profile Access :</span><span id="resellercode">{{ $generalsetting->personal_pro }}</span>
                                            <button onclick="copyResellerCode()"> <i class="fas fa-copy"></i>
                                            </button></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="type" class="form-label">Boost Type</label>
                                            <select class="form-control select2 border @error('type') is-invalid @enderror"
                                                id="product_type" name="type">
                                                <option value="0">Boost Product</option>
                                                <option value="2">Boost Page</option>
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
                                            <input class="form-control border @error('day') is-invalid @enderror" type="number" name="day" id="day" value="{{ old('day') }}" placeholder="Enter Type Days" required />
                                            @error('day')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="amount" class="form-label">Amount (USD)</label>
                                            <input
                                                class="form-control border @error('amount') is-invalid @enderror"
                                                type="number"
                                                name="amount"
                                                id="amount"
                                                value="{{ old('amount') }}"
                                                placeholder="Enter your amount"
                                                required
                                            />
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="amount" class="form-label">Amount ( USD )</label>
                                            <input class="form-control border @error('amount') is-invalid @enderror" type="number" name="amount" id="amount" value="{{ old('amount') }}" placeholder="Enter your amount " required />
                                            @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> -->

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
                                                    <input class="form-control border @error('boost_link.0') is-invalid @enderror" type="text" name="boost_link[]" id="boost_link_0" value="{{ old('boost_link.0') }}" placeholder="Enter Boost link" required />
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
                                            <label for="profile_access" class="form-label">Your (Profile / Page) Link</label>
                                            <textarea type="text" class="summernote border form-control @error('profile_access') is-invalid @enderror" 
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

                                    <!-- Amount Display Section -->
                                    <div class="col-sm-4 mb-3">
                                        <label for="amount-display" class="form-label">BDT Amount:</label>
                                        <div id="amount-display" class="border p-2">0 TK</div>
                                    </div>



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
        </div>
    </div>
</section>











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
            if (value === '0' || value === '2'){ // Variable Product
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
        boostLinksContainer.addEventListener('click', function (e) {
            if (e.target.closest('.add-boost-link')) {
                const currentRow = e.target.closest('.boost-link-row');
                const newRow = currentRow.cloneNode(true);
                const newInput = newRow.querySelector('input');
                newInput.value = '';
                newInput.id = `boost_link_${Date.now()}`;
                const addButton = newRow.querySelector('.add-boost-link');
                addButton.classList.remove('btn-success', 'add-boost-link');
                addButton.classList.add('btn-danger', 'remove-boost-link');
                addButton.innerHTML = '<i class="fa fa-trash"></i>';
                boostLinksContainer.appendChild(newRow);
            }
            if (e.target.closest('.remove-boost-link')){
                const rowToDelete = e.target.closest('.boost-link-row');
                rowToDelete.remove();
            }
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const amountInput = document.getElementById("amount");
    const amountDisplay = document.getElementById("amount-display");
    const boostLinksContainer = document.getElementById('boost_links_container');
    const normaldollar = {{ $normal_dollar }}; 
    const casualdollar = {{ $casual_dollar }}; 

    function updateAmountDisplay() {
        const count = boostLinksContainer.querySelectorAll('input[name="boost_link[]"]').length;
        amountDisplay.textContent = (parseFloat(amountInput.value) || 0) * (count === 1 ? normaldollar : casualdollar);
    }

    amountInput.addEventListener("input", updateAmountDisplay);
    boostLinksContainer.addEventListener('click', updateAmountDisplay);

    updateAmountDisplay(); // Initial update
});
</script>








@endpush
