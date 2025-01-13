@extends('frontEnd.seller.pages.master')
@section('title','Traning Video')
@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
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
    text-align: left;
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
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title text-capitalize">Traning Video</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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


            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection


@section('script')
<!-- third party js -->
script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
@endsection
