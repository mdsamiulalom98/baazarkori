@extends('frontEnd.layouts.master') @section('title','Shopping Cart') @section('content')
<section class="breadcrumb-section">
 <div class="container">
  <div class="row">
   <div class="col-sm-12">
    <div class="custom-breadcrumb">
     <ul>
      <li><a href="{{route('home')}}">Home </a></li>
      <li>
       <a><i class="fa-solid fa-angles-right"></i> </a>
      </li>
      <li><a href="">Shopping Cart</a></li>
     </ul>
    </div>
   </div>
  </div>
 </div>
</section>
<!-- breadcrumb end -->
<section class="vcart-section">
  @include('frontEnd.layouts.ajax.cartpage')
 
</section>
@endsection
