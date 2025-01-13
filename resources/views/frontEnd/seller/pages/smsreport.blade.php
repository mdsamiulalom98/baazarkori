@extends('frontEnd.seller.pages.master')
@section('title','seller sms report')
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Seller Sms Report</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                <div class="customer-content">
                 <div class="wallet__header">
                     <div class="my__wallet">My Report</div>
                 </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th width="40%">Report</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                    @foreach($smsreport as $key=>$value)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td >{{$value->name}}</td>
                                        <td><img src="{{asset($value->image)}}" class="backend-image" alt="image"></td>
                                        <td>{{ Str::limit($value->report, 50, '...') }}</td>
                                    <tr>
                                    @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection
@push('script')
<script>
    $(".deposit__p").on("click", function () {
        $(".deposit__p.act").removeClass("act");
        $(this).addClass("act");
    });
</script>
@endpush