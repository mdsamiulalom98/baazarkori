@extends('frontEnd.layouts.master')
@section('title','reseller Video')
@section('content')
<style>
.main-video {
    display: grid;
    grid-template-columns: 1fr 1fr;
    margin-top: 40px;
    text-align: center;
    flex-wrap: nowrap;
    justify-content: center;
}

.video-tag h4 {
    text-align: center;
    text-transform: capitalize;
    font-size: 18px;
    font-weight: 600;
    color: #ff6801;
    padding-right: 45px;
    padding-left: 12px;
}
.video-tag {
    padding: 15px 0px 7px 0px;
}

</style>
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
                    <h5 class="account-title">Reseller Video</h5>
                    
                     <div class="main-video">
                        @foreach($video as $key=>$value)
                        <div class="video-item">
                            <div class="video-tag">
                                <h4>{{$value->title}}</h4>
                            </div>
                           <div class="camp_vid">
                                <iframe style="height:250px; width: 380px;" src="https://www.youtube.com/embed/{{$value->video}}?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>          
                        </div>
                        @endforeach
                    </div>



                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush