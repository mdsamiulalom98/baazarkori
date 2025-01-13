<style>
.all-product {
    padding: 7px 23px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 17px;
}
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

</style>
<div class="customer-auth">
    <div class="customer-img">
        <img src="{{asset(Auth::guard('customer')->user()->image)}}" alt="">
    </div>
    <div class="reseller-edit">
        <li><a href="{{route('customer.profile_edit')}}" class="{{request()->is('customer/profile-edit')?'active':''}}"><i data-feather="edit"></i></a></li>
    </div>
    <div class="customer-name">
        <p><small>Hello</small></p>
        <p>{{Auth::guard('customer')->user()->name}}</p>
        <a href="{{route('customer.wallet')}}"><i data-feather="credit-card"></i> {{Auth::guard('customer')->user()->balance}}৳</a>
        <h6>
            @if(Auth::guard('customer')->user()->seller_type == 1)
                Uddokta
            @elseif(Auth::guard('customer')->user()->seller_type == 2)
                Reseller
            @else
                Customer
            @endif
        </h6>
    </div>
</div>
<div class="sidebar-menu">
    <ul> 
         @php
            $dueseller = \App\Models\Customerdeduct::where('status','pending')->where('customer_id',Auth::guard('customer')->user()->id)->get();

        @endphp
        
        <!-- <li>
            <a href="{{route('customer.wallet')}}" class="{{request()->is('customer/wallet')?'active':''}}" role="button" >
                <i class="fa-solid fa-envelope"></i>
                <span>Add Message </span>
            </a>
        </li> -->



        <li><a href="{{route('customer.dashboard')}}" class="{{request()->is('customer/dashboard')?'active':''}}"><i data-feather="airplay"></i> Dashboard</a></li>
        <li><a href="{{route('customer.account')}}" class="{{request()->is('customer/account')?'active':''}}"><i data-feather="user"></i> My Account</a></li>
        <li><a href="{{route('customer.orders')}}" class="{{request()->is('customer/orders')?'active':''}}"><i data-feather="shopping-cart"></i> My Order</a></li>
        <li class="wallet_i"><a href="{{route('customer.wallet_add')}}" class="{{request()->is('customer/wallet-add')?'active':''}}"><i data-feather="dollar-sign"></i> Add Wallet</a></li>
        
        <li class="wallet_i"><a href="{{route('customer.wallet')}}" class="{{request()->is('customer/wallet')?'active':''}}"><i data-feather="award"></i> My Wallet</a></li>

        <li class="dropdown notification-list topbar-dropdown">
            <a href="{{route('customer.expense')}}" class="{{request()->is('customer/expense')?'active':''}}" role="button" >
                <i class="fa-solid fa-envelope"></i>
                <span>Deduct Message </span>
            </a>
        </li>
        <!-- total earnning start -->
        <li><a href="{{route('customer.commissions')}}" class="{{request()->is('customer/commissions')?'active':''}}"><i data-feather="briefcase"></i> Total Earning</a></li>
        <!-- total earnning end -->
        <li><a href="{{route('customer.expense')}}" class="{{request()->is('customer/expense')?'active':''}}"><i data-feather="database"></i> Uddokta Expence</a></li>
        <!-- total earnning end -->

        @if(Auth::guard('customer')->user()->seller_type == 1)
            <li><a href="{{route('customer.videouddokata')}}" class="{{request()->is('customer/videouddokata')?'active':''}}"><i data-feather="battery-charging"></i> Uddokta Traning</a></li>
        @elseif(Auth::guard('customer')->user()->seller_type == 2)
            <li><a href="{{route('customer.videoreseller')}}" class="{{request()->is('customer/videoreseller')?'active':''}}"><i data-feather="battery-charging"></i> Reseller Traning</a></li>
        @endif
        <!-- -----withdorw-strat---- -->
        @if(Auth::guard('customer')->user()->seller_type != 0)
        <li>
            <a href="{{route('customer.withdraw')}}" class="{{request()->is('customer/withdraw')?'active':''}}">
                <i data-feather="credit-card"></i> My Withdraw</a>
        </li>
        @endif
        @if(Auth::guard('customer')->user()->seller_type != 0)
        <li>
            <a href="{{route('customer.boostc_request')}}" class="">
                <i data-feather="credit-card"></i> Boosting Request</a>
        </li>
        @endif
        <!-- -----withdorw-end---- -->
        <li><a href="{{route('customer.profile_edit')}}" class="{{request()->is('customer/profile-edit')?'active':''}}"><i data-feather="edit"></i> Profile Edit</a></li>
        <li><a href="{{route('customer.change_pass')}}" class="{{request()->is('customer/change-password')?'active':''}}"><i data-feather="lock"></i> Change Password</a></li>

        @if(Auth::guard('customer')->user()->seller_type == 0)
        <li><a href="{{route('customer.register_note',['type'=>1])}}" class="{{request()->is('customer/register_note')?'active':''}}"><i data-feather="user"></i> Uddokta Request</a></li>
        <li><a href="{{route('customer.register_note',['type'=>2])}}" class="{{request()->is('customer/register_note')?'active':''}}"><i data-feather="user-plus"></i> Reseller Request</a></li>
        @endif

        <!-- social midea start -->
        @foreach ($socialicons as $value)

        <li><a href="{{ $value->link }}" class="{{request()->is('')?'active':''}}"><i class="{{$value->icon}}"></i> {{$value->title}}</a></li>
        @endforeach
        <!-- social midea end -->

        <li><a href="{{ route('customer.logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i data-feather="log-out"></i> Logout</a></li>
            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        <li><a href="{{route('customer.register_note',['type'=>1])}}" class="all-product btn-grad">Update Plan</a></li>
        <div class="end-date">
            আপনার বিনামূল্যে পুনঃবিক্রয় <br>শেষ তারিখ <strong>: {{Auth::guard('customer')->user()->activation}}</strong> তাই প্রাথমিক আপডেট পরিকল্পনা একটি ক্লিক করুন এবং আপডেট করুন 
        </div>


    </ul>
</div>
<!-- ====== uddokta and reseller design start============ -->
<div class="main-uddokta-reseller">
    <div class="uddokadashboard">
      <a href="{{route('customer.dashboard')}}" class="uddokadashboard-item">
        <i data-feather="airplay"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{route('customer.orders')}}" class="uddokadashboard-item">
        <i data-feather="shopping-cart"></i>
        <span>My Order</span>
      </a>

      @if(Auth::guard('customer')->user()->seller_type != 0)
      <a href="{{route('customer.wallet')}}" class="uddokadashboard-item">
        <i data-feather="award"></i>
        <span>Wallet</span>
      </a>
      <a href="{{route('customer.commissions')}}" class="uddokadashboard-item">
        <i data-feather="briefcase"></i>
        <span>Earning</span>
      </a>
      <a href="{{route('customer.expense')}}" class="uddokadashboard-item">
        <i data-feather="database"></i>
        <span>Expence</span>
      </a>
      <a href="{{route('customer.boostc_request')}}" class="uddokadashboard-item">
        <i data-feather="credit-card"></i>
        <span>Bosting</span>
      </a>
      @endif
      <a href="{{route('customer.account')}}" class="uddokadashboard-item">
        <i data-feather="user"></i>
        <span>My Account</span>
      </a>
      @if(Auth::guard('customer')->user()->seller_type == 1)
      <a href="{{route('customer.videouddokata')}}" class="uddokadashboard-item">
        <i data-feather="battery-charging"></i>
        <span>Training</span>
      </a>
      @elseif(Auth::guard('customer')->user()->seller_type == 2)
      <a href="{{route('customer.videoreseller')}}" class="uddokadashboard-item">
        <i data-feather="battery-charging"></i>
        <span>Training</span>
      </a>
      @endif
    </div>
        <li class="mobile-log"><a href="{{ route('customer.logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><i data-feather="log-out"></i> Logout</a></li>
        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <li><a href="{{route('customer.register_note',['type'=>1])}}" class="all-product btn-grad">Update Plan</a></li>
        <div class="end-date">
            আপনার বিনামূল্যে পুনঃবিক্রয় <br>শেষ তারিখ <strong>: {{Auth::guard('customer')->user()->activation}}</strong> তাই প্রাথমিক আপডেট পরিকল্পনা একটি ক্লিক করুন এবং আপডেট করুন 
        </div>
</div>
<!-- ====== uddokta and reseller design end============ -->

