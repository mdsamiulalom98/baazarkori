@extends('frontEnd.seller.pages.master')
@section('title', 'Seller Boost Index')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title text-capitalize">Your Boosting </h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Boost Link</th>
                            <th>Days</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($orders as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                @php
                                    $boost_links = json_decode($value->boost_link, true); // Decode JSON to array
                                @endphp

                                @if(is_array($boost_links) && !empty($boost_links))
                                    @foreach($boost_links as $link)
                                        {{ $link }}<br> <!-- Display each link on a new line -->
                                    @endforeach
                                @else
                                    No links available
                                @endif
                            </td>
                            <td>{{$value->day}}</td>
                            <td>{{$value->amount ?? ''}} Tk</td>
                            <td>{{$value->status ?? '0'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
    







@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
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
@endpush
