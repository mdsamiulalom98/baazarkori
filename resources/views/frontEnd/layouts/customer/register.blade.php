@extends('frontEnd.layouts.master')
@section('title','Customer Register')
@section('content')
<style>
    .btn-grad {
    background-image: linear-gradient(to right, #FF8008 0%, #FFC837  51%, #FF8008  100%);
    margin: 10px;
    padding: 15px 45px;
    text-align: center;
    text-transform: uppercase;
    transition: 0.5s;
    background-size: 200% auto;
    color: white !important;
    /* box-shadow: 0 0 20px #eee; */
    border-radius: 10px;
    display: block;
}

.btn-grad:hover {
background-position: right center; /* change the direction of the change here */
color: #fff;
text-decoration: none;
}
.camp_vid{
    aspect-ratio: 16/9;
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
<section class="auth-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-content">
                    <p class="auth-title"> Customer Registration </p>
                    <form action="{{route('customer.store')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="refferal_id">Referral ID (Optional) </label>
                            <input type="text" id="refferal_id" class="form-control"  name="refferal_id" @if(Session::has('refferal_id')) readonly @endif value="{{ Session::get('refferal_id') ?? '' }}" placeholder="Refer ID">
                          
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter your name " required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="phone">Mobile Number</label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Mobile Number" maxlength="11" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- end-col -->
                            <div class="form-group mb-3">
                                <label for="seller_type">Account Type *</label>

                                <select id="seller_type"
                                    class="form-control form-select @error('seller_type') is-invalid @enderror" name="seller_type"
                                    required>
                                        <option value="">Select Account Type</option>
                                        <option value="0">Customer</option>
                                        <option value="1">Uddokta</option>
                                        <option value="2">Reseller</option>
                                    
                                </select>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="password"> Password </label>
                            <div class="input-group">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        
                        
                        <!-- form group -->
                        <div class="form-group mb-3" >
                          <div class="form-check">
                            <input class="form-check-input" name="agree" required type="checkbox" value="1" id="agree">
                            <label class="form-check-label" for="agree">
                              I am agree with terms & conditions
                            </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <button class="submit-btn btn-submit d-block" id="submit" disabled>Registration</button>
                        </div>
                        <!-- form group -->
                        
                         <div class="register-now no-account">
                        <p><i class="fa-solid fa-user"></i> If registered?</p>
                        <a href="{{route('customer.login')}}"><i data-feather="edit-3"></i> Login </a>
                    </div>
                        </div>
                     <!-- col-end -->
                     </form>
                </div>
            
            <div class="col-sm-7">
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

                <div class="video-item">
                        <li><a href="https://www.youtube.com/@Baazarkori" class="all-product btn-grad">View All Video</a></li>
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
<script>
$(document).ready(function() {
    $('#name').on('focus', function() {
        $(this).removeAttr('placeholder');
    });

    $('#name').on('blur', function() {
        if ($(this).val() === '') {
            $(this).attr('placeholder', 'Enter your name');
        }
    });

     $('#phone').on('focus', function() {
        $(this).removeAttr('placeholder');
    });

    $('#phone').on('blur', function() {
        if ($(this).val() === '') {
            $(this).attr('placeholder', 'Enter your phone');
        }
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.querySelector('#phone');

    phoneInput.addEventListener('input', function () {
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
            alert('Only 11 digit phone numbers are allowed.');
        }
    });
});
</script>
<script>
    $('#agree').on('click', function() {
      $('#submit').prop('disabled', !this.checked);
    });
  </script>
@endpush