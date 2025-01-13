<div class="menu-bag">
    <p class="margin-shopping wishlist-qty" >
        <a href="{{ route('customer.wishlist') }}">
            <i class="fa-regular fa-heart"></i>
            <span>{{ Cart::instance('wishlist')->count() }}</span>
        </a>
    </p>
</div>

