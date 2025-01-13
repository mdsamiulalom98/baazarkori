@extends('frontEnd.seller.pages.master')
@section('title','Payment Withdraw')
@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<style>
    .my__wallet span {
        font-size: 27px;
        color: green;
    }
.button-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    padding-bottom: 30px;
}

.action-button {
    background-color: #ffd700;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    width: 150px;
    height: 63px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s;
}

.action-button:hover {
  transform: scale(1.05);
}


.action-button span {
  font-size: 1rem;
  color: #000;
  font-weight: bold;
}
</style>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title text-capitalize">Payment Withdraw </h4>
            </div>
            
            <div class="button-container">
                <a href="{{route('seller.withdraws')}}">
                    <div class="action-button">
                      <span><i class="fa-solid fa-print"></i> Withdraw</span>
                    </div>
                </a>
                <a href="{{route('seller.sellerwallet')}}">
                    <div class="action-button">
                      <span> <i class="fa-solid fa-list-ul"></i> Transaction</span>
                    </div>
                </a>
                <a href="{{route('seller.sellerwallet_add')}}">
                    <div class="action-button">
                      <span><i class="fa-solid fa-wallet"></i> Add Balance</span>
                    </div>
                </a>
              </div>
            <div class="my-dashboard">
                <button class="withdraw_rquest btn btn-success" data-bs-toggle="modal" data-bs-target="#withdraw">New Withdraw</button>
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
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($withdraws as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->created_at->format('d-d-Y H:m a')}}</td>
                            <td>{{$value->amount}}</td>
                            <td>@if($value->status=='pending')<span class="badge bg-soft-danger text-danger">{{$value->status}}</span> @else <span class="badge bg-soft-success text-success">{{$value->status}}</span> @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>

<!-- withdraw modal-start -->
<div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="withdraw" aria-hidden="true">
  <div class="modal-dialog custom_modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="withdrawLabel">New Withdraw</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('seller.sellerwithdraw_request')}}" method="POST" class="withdraw_form">
             @csrf
             <div class="from-group">
                <label for="amount">Amount <strong class="text-danger"> (Current Balance {{Auth::guard('seller')->user()->balance}} TK)</strong></label>
                 <input type="number" id="amount" name="amount" class="form-control border" placeholder="Enter Amount" required>
             </div>
             <div class="from-group">
                <label for="method">Payment Method</label>
                 <select name="method" id="method" class="form-control border" required>
                     <option value="">Select..</option>
                     <option value="bKash">bKash</option>
                     <option value="Nagad">Nagad</option>
                     <option value="Rocket">Rocket</option>
                     <option value="Bank">Bank</option>
                 </select>
             </div>
             <div class="from-group">
                <label for="amount">Receive Number</label>
                 <input type="number" id="amount" name="receive" class="form-control border" placeholder="Enter Receive Number" required>
             </div>
             <div class="from-group">
                <label for="note">Note</label>
                 <textarea  id="note" name="note" class="form-control border" placeholder="Write your payment receive information"></textarea>
             </div>
             <div class="from-group">
                <label for="password"> Your Password</label>
                 <input type="password" id="password" name="password" class="form-control border" placeholder="Enter Your Password" required>
             </div>
             <div class="form-group my-2">
                 <button type="submit" class="btn btn-success"> Submit Withdraw</button>
             </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- withdraw modal-end -->
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