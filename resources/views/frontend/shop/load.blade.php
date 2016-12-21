<li class="dropdown popup-cart">
    <a class="css-pointer dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-cart fsc pull-left"></i><span class="cart-number">{{ $shoppingCart->sum('quantity') }}</span><span class="caret"></span></a>
    <div class="cart-content dropdown-menu">
        <div class="cart-title">
            <h4>Sepetim</h4>
        </div>
        <div class="cart-items">
            @foreach($shoppingCart as $cart)
                <div class="cart-item clearfix">
                    <div class="cart-item-image">
                        <a href="./shop_single_full.html"><img src="img/cart-img1.jpg" alt="Breakfast with coffee"></a>
                    </div>
                    <div class="cart-item-desc">
                        <a href="./shop_single_full.html">{{ $cart->products->name }}</a>
                        <span class="cart-item-price">{{ $cart->discounted_price }} TL </span>
                        <span class="cart-item-quantity">x {{ $cart->quantity }}</span>
                        <i class="fa fa-times ci-close"></i>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-action clearfix">
            <span class="pull-left checkout-price"> {{ $shoppingCart->sum('total_discounted_price') }} TL </span>
            <a class="btn btn-default pull-right" href="./shop_cart.html">SEPETE GİT</a>
        </div>
    </div>
</li>