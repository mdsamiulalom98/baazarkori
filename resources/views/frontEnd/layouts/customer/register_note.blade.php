@extends('frontEnd.layouts.master')
@section('title', 'Customer note')
@section('content')
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                    <div class="form-content">
                        <p class="auth-title"> Whole Seller Payment Note </p>

                        <form action="{{ route('customer.wholesell_store') }}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="">Select Duration</label>
                                <select name="package_id" class="form-control package" id="" required>
                                    <option value="">Select..</option>
                                    @foreach ($charges as $key => $value)
                                        <option value="{{ $value->id }}" data-charge="{{ $value->charge }}">
                                            {{ $value->title }} for {{ $value->charge }} Tk</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- end-col -->
                            <div class="col-sm-12">
                                <!-- start-nav-Tabs -->
                                <ul class="nav nav-pills mb-3 reg-payment-section" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">
                                            @if ($bkash_gateway)
                                                <div class="form-check p_bkash">
                                                    <input class="form-check-input" type="radio" name="payment_method"
                                                        checked id="inlineRadio2" value="bkash" required />
                                                    <label class="form-check-label pament-image" for="inlineRadio2">
                                                        <img src="{{ asset('public/frontEnd/images/bangla-bk.png') }}"
                                                            alt="" />
                                                    </label>
                                                </div>
                                            @endif
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">

                                            <div class="form-check p_shurjo">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="inlineRadio3" value="nagad" required />
                                                <label class="form-check-label pament-image" for="inlineRadio3">
                                                    <img src="{{ asset('public/frontEnd/images/nagad-logo.png') }}"
                                                        alt="" />
                                                </label>
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <div class="payment-rule">
                                            <h5>বিকাশ পেমেন্ট করতে নিচের নিয়মটি অনুসরণ করুন</h5>
                                            <ul>
                                                <li>
                                                    1. ডায়াল মেনু থেকে *247# ডায়াল করুন, অথবা বিকাশ অ্যাপে যান।
                                                </li>
                                                <li>
                                                    2. "ক্যাশ আউট" এ ক্লিক করুন।
                                                </li>
                                                <li>
                                                    3. প্রাপকের নম্বর হিসাবে এই নম্বরটি লিখুন: 01302029990
                                                </li>
                                                <li>
                                                    4. টাকা পরিমাণ লিখুন ।
                                                </li>
                                                <li>
                                                    5. রেফারেন্স হিসাবে 1234 দিন।
                                                </li>
                                                <li>
                                                    6. নিশ্চিত করতে আপনার পিন লিখুন।
                                                </li>
                                                <li>
                                                    7. নিচের বক্সে আপনার লেনদেন আইডি এবং যে নম্বর থেকে আপনি টাকা পাঠিয়েছেন
                                                    সেটি লিখুন।
                                                </li>
                                                <li>
                                                    8. "CONFIRM" বোতামে ক্লিক করুন৷
                                                </li>
                                                <li>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">
                                        <!-- popular product-start -->
                                        <div class="payment-rule">
                                            <h5>নগদ পেমেন্ট করতে নিচের নিয়মটি অনুসরণ করুন</h5>
                                            <ul>
                                                <li>
                                                    1. ডায়াল মেনু থেকে *167# ডায়াল করুন, অথবা নগদ অ্যাপে যান।
                                                </li>
                                                <li>
                                                    2. "ক্যাশ আউট" এ ক্লিক করুন।
                                                </li>
                                                <li>
                                                    3. প্রাপকের নম্বর হিসাবে এই নম্বরটি লিখুন: 01302029990
                                                </li>
                                                <li>
                                                    4. টাকা পরিমাণ লিখুন ।
                                                </li>
                                                <li>
                                                    5. রেফারেন্স হিসাবে 1234 দিন ।
                                                </li>
                                                <li>
                                                    6. নিশ্চিত করতে আপনার নগদ পিন লিখুন ।
                                                </li>
                                                <li>
                                                    7. নিচের বক্সে আপনার লেনদেন আইডি এবং যে নম্বর থেকে আপনি টাকা পাঠিয়েছেন
                                                    সেটি লিখুন।
                                                </li>
                                                <li>
                                                    8. "CONFIRM" বোতামে ক্লিক করুন৷
                                                </li>
                                                <li>

                                                </li>
                                            </ul>
                                        </div>
                                        <!-- popular product-end -->
                                    </div>
                                </div>
                                <!-- End-nav-Tabs -->
                            </div>
                            <!-- end-col -->
                            <input type="hidden" name="type" value="{{request()->type}}">
                            <div class="payment-rule">
                                <div class="form-group mb-3">
                                    <label for="sender_number">Sender Number</label>
                                    <input type="number" id="sender_number"
                                        class="form-control @error('sender_number') is-invalid @enderror"
                                        name="sender_number" value="{{ old('sender_number') }}" required>
                                    @error('sender_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- col-end -->
                                <div class="form-group mb-3">
                                    <label for="transaction">Transaction ID</label>
                                    <input type="text" id="transaction"
                                        class="form-control @error('transaction') is-invalid @enderror" name="transaction"
                                        value="{{ old('transaction') }}">
                                    @error('transaction')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- col-end -->
                                <div class="form-group mb-3">
                                    <button class="submit-btn">CONFIRM</button>
                                </div>
                                <!-- col-end -->
                        </form>


                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush
