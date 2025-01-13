@extends('backEnd.layouts.master')
@section('title','Boost Orders')

@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{request()->status}} Boosting Information</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!--<div class="row mb-3">-->
                <!--    <div class="col-sm-8"></div>-->
                <!--    <div class="col-sm-4">-->
                <!--        <form class="custom_form">-->
                <!--            <div class="form-group">-->
                <!--                <input type="text" value="{{request()->get('keyword')}}" name="keyword" placeholder="Search">-->
                <!--                <button class="btn  rounded-pill btn-info">Search</button>-->
                <!--            </div>-->
                <!--        </form>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="table-responsive ">
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Boosting Link</th>
                            <th>Dollar</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            @php
                            if($value->user_type == 'seller') {
                                $user = \App\Models\Seller::find($value->user_id);
                                $user_name = 'Seller';
                            } else {
                                $user = \App\Models\Customer::find($value->user_id);
                                $user_detect = $user->seller_type;
                                if ($user_detect == 1) {
                                    $user_name = 'Uddokta';
                                } elseif ($user_detect == 2) {
                                    $user_name = 'Reseller';
                                } else {
                                    $user_name = 'Unknown';
                                }
                            }
                            @endphp
                            <td>{{$user_name}}</td>
                            <td>{{$user->name}}</td>
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
                            <td>{{$value->dollar}}</td>
                            <td>{{$value->amount}}</td>
                            <td>@if($value->status=='active')<span class="badge bg-soft-success text-success">Active</span> @else <span class="badge bg-soft-danger text-danger">{{$value->status}}</span> @endif</td>
                            <td>
                                <div class="button-list">                                 

                                    <a href="{{route('boostorder.boost_details',['id'=>$value->id])}}" class="btn btn-xs btn-blue waves-effect waves-light"><i class="fe-eye"></i></a>                                  

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                <div class="custom-paginate">
                    {{$show_data->links('pagination::bootstrap-4')}}
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection


@section('script')
<!-- third party js -->
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
@endsection