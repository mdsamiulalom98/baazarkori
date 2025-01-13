@extends('backEnd.layouts.master')
@section('title','Wallet Manage')
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
                <h4 class="page-title">Wallet Manage</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Transaction</th>
                            <th>Sender Number</th>
                            <th>Amount</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @foreach($data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->phone}}</td>
                            <td>0{{$value->transaction}}</td>
                            <td>0{{$value->sender_number}}</td>
                            <td>{{$value->amount}}</td>
                            <td>{{$value->wallets_type}}</td>
                           <td>
                             <span class="badge bg-soft-success text-success">{{$value->status}}</span>
                           </td>
                            <td>
                                <div class="button-list">
                                    @if($value->status != 'paid')
                                    <form method="post" action="{{route('wallet.status')}}" class="d-inline"> 
                                        @csrf
                                        <input type="hidden" value="{{$value->id}}" name="hidden_id">       
                                        <input type="hidden" value="paid" name="status">       
                                        <button type="button" class="btn btn-xs  btn-success waves-effect waves-light change-confirm">Paid Request</button>
                                    </form>
                                    @endif
                                  
                                    <form method="post" action="{{route('wallet.status')}}" class="d-inline"> 
                                        @csrf
                                        <input type="hidden" value="{{$value->id}}" name="hidden_id">       
                                        <input type="hidden" value="cancelled" name="status">       
                                        <button type="button" class="btn btn-xs  btn-secondary waves-effect waves-light change-confirm">Cancel Request</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 
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