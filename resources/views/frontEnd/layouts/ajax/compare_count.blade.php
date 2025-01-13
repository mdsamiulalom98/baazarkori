<a href="{{ route('compare.product') }}" class="main-menu-link">
  <p class="margin-shopping">
    <i class="fa-solid fa-sliders"></i>
     @if(Cart::instance('compare')->content()->count() > 0)
     <span>{{Cart::instance('compare')->content()->count()}}</span>
     @endif
   </p>
</a>