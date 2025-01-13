@extends('backEnd.layouts.master')
@section('title','Seller Withdraw')
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
                <div class="page-title-right">
                    <a href="{{route('sellers.index',['status'=>'active'])}}" class="btn btn-primary rounded-pill">Back</a>
                </div>
                <h4 class="page-title">Seller Withdraw - {{$seller->name}}</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('sellers.withdraw.save')}}" method="POST" class="select_pay">
                    <input type="hidden" value="{{$seller->id}}" name="seller_id">
                @csrf
                <select name="withdraw_status"   required>
                  <option value="">Select..</option>
                  <option value="processing">Processing</option>
                  <option value="paid">Paid</option>
                </select>
                <button type="submit" class="btn btn-primary change-confirm" >Apply</button>

                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th><div class="form-check checkall text-primary">
                            <input type="checkbox" class="form-check-input">
                            <label class="form-check-label" for="checkall">All</label>
                        </div></th>
                            <th>SL</th>
                            <th>Invoice</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Commission</th>
                            <th>Qty</th>
                            <th>Image</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($data as $key=>$value)
                        <tr>
                            <td><div class="form-check">
                                <input type="checkbox" class="form-check-input" value="{{$value->id}}" id="customCheck{{$value->id}}" name="order_id[]">
                                <label class="form-check-label" for="customCheck{{$value->id}}">{{$value->name}}</label>
                            </div></td>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->order?$value->order->invoice_id:''}}</td>
                            <td>{{Str::limit($value->product_name,30)}}</td>
                            <td>{{$value->sale_price}} Tk</td>
                            <td>{{$value->seller_commision}} Tk</td>
                            <td>{{$value->qty}}</td>
                            <td><img src="{{asset($value->image?$value->image->image:'')}}" class="backend-image" alt=""></td>
                            <td>@if($value->order?$value->order->order_status=='pending':'')<span class="badge bg-soft-danger text-danger">{{$value->order?$value->order->order_status:''}}</span> @else <span class="badge bg-soft-success text-success">{{$value->order?$value->order->order_status:''}}</span> @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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
<script>
    jQuery(".checkall").click(function() {
    jQuery(':checkbox').each(function() {
      if(this.checked == true) {
        this.checked = false;                        
      } else {
        this.checked = true;                        
      }      
    });

  });
</script>
@endsection