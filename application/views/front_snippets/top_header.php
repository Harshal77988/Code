<div class="container">
    <div class="col-md-6">
        <div class="top-header-left">
            <ul>
                <li>
                    <span>Hello <?=(!empty($first_name) ? $first_name : 'Customer')?></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="top-header-right">
            <ul>
                <?php if($this->ion_auth->logged_in()) {?>
                <li><a href="<?=base_url('my_account')?>">My Account</a></li>
                <li><a href="<?=base_url('my_orders')?>">My Orders</a></li>
                <li><a href="<?=base_url('auth/logout')?>">Logout</a></li>
                <?php } else { ?>
                <li><a href="<?=base_url('auth/')?>"><i class="icon-note icons" aria-hidden="true"></i> Login</a></li>
                <li><a href="<?=base_url('auth/register_user')?>"><i class="icon-note icons" aria-hidden="true"></i> Register</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>