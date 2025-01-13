@extends('backEnd.layouts.master')
@section('title','Post Details')

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title text-capitalize"> Post Details</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
               <table class="table table-responsive">
                   <tbody>
                       <tr class="text-muted mb-2 font-13">
                                <td>Full Name </td>
                                <td class="ms-2">{{$show_data->customer->name}}</td>
                            </tr>

                            <tr class="text-muted mb-2 font-13">
                                <td>Mobile </td>
                                <td class="ms-2">{{$show_data->customer->phone}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package name </td>
                                <td class="ms-2">{{$package->title}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package Date</td>
                                <td class="ms-2">{{$package->days}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Package Amount</td>
                                <td class="ms-2">{{$package->charge}} Tk</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Payment Type </td> 
                                <td class="ms-2">{{$show_data->payment_method}}</td>
                            </tr>
                            <tr class="text-muted mb-2 font-13">
                                <td>Sender Number </td> 
                                <td class="ms-2">{{$show_data->sender_number}}</td>
                            </tr>

                            <tr class="text-muted mb-2 font-13">
                                <td>Transaction </td> 
                                <td class="ms-2">{{$show_data->transaction }}</td>
                            </tr>
                       <tr>
                           <td class="d-flex gap-1">
                            </td>
                       </tr>
                   </tbody>
               </table>
                
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <form action="{{route('wholesellercustomers.status_manage')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$show_data->id}}" name="hidden_id">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status *</label>
                             <select class="form-control"  name="status" required>
                                <option value="">Select..</option>
                                <option value="inactive" {{$show_data->status == 'inactive' ? 'selected' :''}}>Inactive</option>
                                <option value="active" {{$show_data->status == 'active' ? 'selected' :''}}>Active</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end col-->
   </div>
</div>
@endsection