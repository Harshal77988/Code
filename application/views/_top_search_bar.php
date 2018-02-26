<div class="container">
    <div class="col-sm-3">
        <div class="logo">
            <h6><a href="<?=base_url()?>"><img src="<?=base_url()?>frontend/assets/images/logo.png" alt="logo" /></a></h6>
        </div>
    </div>
    <div class="col-sm-6">
        <!-- Search box Start -->
        <form>
            <div class="well carousel-search hidden-phone">
                <div class="btn-group">
                    <a class="btn dropdown-toggle btn-select" data-toggle="dropdown" href="#">All Categories <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Electronics</a></li>
                        <li><a href="#">Appliance</a></li>
                        <li><a href="#">Automotive</a></li>
                        <li><a href="#">Baby Products</a></li>
                        <li><a href="#">Books</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Other</a></li>
                    </ul>
                </div>
                <div class="search">
                    <input type="text" placeholder="Search here" />
                </div>
                <div class="btn-group">
                    <button type="button" id="btnSearch" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
        <!-- Search box End -->
    </div>
    <div class="col-sm-3">
        <!-- cart-menu -->
        <div class="cart-menu">
            <ul>
                <li><a href="#"><i class="icon-heart icons" aria-hidden="true"></i></a><span class="subno">1</span><strong>Your Wishlist</strong></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="icon-basket-loaded icons" aria-hidden="true"></i></a><span class="subno">2</span><strong>Your Cart</strong>
                    <div class="dropdown-menu  cart-outer">
                        <div class="cart-content">
                            <div class="col-sm-4 col-md-4"><img src="<?= base_url() ?>frontend/assets/images/elec-img4.jpg" alt="13"></div>
                            <div class="col-sm-8 col-md-8">
                                <div class="pro-text">
                                    <a href="#">Apple Macbook Retina 23’’ </a>
                                    <div class="close">x</div>
                                    <strong>1 × $290.00</strong>
                                </div>
                            </div>
                        </div>
                        <div class="cart-content">
                            <div class="col-sm-4 col-md-4"><img src="<?= base_url() ?>frontend/assets/images/elec-img3.jpg" alt="13"></div>
                            <div class="col-sm-8 col-md-8">
                                <div class="pro-text">
                                    <a href="#">Apple Macbook Retina 23’’ </a>
                                    <div class="close">x</div>
                                    <strong>1 × $290.00</strong>
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <div class="col-md-6 text-left">
                                <span>Shipping :</span>
                                <strong>Total :</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong>$0.00</strong>
                                <strong>$160.00</strong>
                            </div>
                        </div>
                        <a href="shopping-cart.html" class="cart-btn">VIEW CART </a> <a href="checkout.html" class="cart-btn">CHECKOUT</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- cart-menu End -->
    </div>
</div>