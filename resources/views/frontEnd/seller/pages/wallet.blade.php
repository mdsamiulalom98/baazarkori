@extends('frontEnd.seller.pages.master')
@section('title','seller wallet')
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
                <h4 class="page-title">Seller Wallet</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
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
                <div class="customer-content">
                 <div class="wallet__header">
                    <div class="my__wallet">
                       <h5 class="account-title text-center">My Balance   BDT : <span>{{Auth::guard('seller')->user()->balance}}৳ </span></h5>
                     </div>
                 </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Charge Note</th>
                                    <th>Amount Type</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                    @foreach($wallet as $key=>$value)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td >{{$value->note}}</td>
                                        <td style="font-weight:600; color: {{ $value->amount_type == 'debit' ? 'red' : 'green' }}">{{$value->amount_type}}</td>
                                        <td style="font-weight:900; color: {{ $value->amount_type == 'debit' ? 'red' : 'green' }}">
                                            {{ $value->amount_type == 'debit' ? '-' : '+' }}{{ $value->amount }}
                                        </td>
                                        <td>{{$value->balance }}</td>
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