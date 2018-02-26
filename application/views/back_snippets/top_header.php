<div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand">
            <img style="height:30px !important;" src="<?=base_url()?>frontend/assets/images/logo.png" alt="logo">
        </a>
        <button type="button" class="sidebar-toggle">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div><!-- /.navbar-header -->

    <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?=base_url()?>backend/assets/img/profile-sm.png" alt="avatar" class="img-circle">
            </a>
            <ul class="dropdown-menu dropdown-menu-profile">
                <li class="dropdown-header">Account Details</li>
                <li>
                    <div class="media">
                        <div class="media-left">
                            <img src="<?=base_url()?>backend/assets/img/profile-lg.png" alt="avatar" class="media-object img-circle">
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">Administrator</h5>
                            <p><?php echo isset($dataHeader)?$dataHeader['first_name'] . " ".$dataHeader['last_name'] :"My Account"?></p>
                            <a href="<?=base_url('auth/logout')?>" class="btn btn-primary btn-xs">Sign Out</a>
                        </div>
                    </div><!-- /.media -->
                </li>

                <!-- <li>
                    <a href="page-inbox.html">
                        <i class="fa fa-paper-plane-o"></i> Inbox
                    </a>
                </li>
                <li>
                    <a href="page-timeline.html">
                        <i class="fa fa-history"></i> Timeline
                    </a>
                </li>
                <li>
                    <a href="plugin-fullcalendar.html">
                        <i class="fa fa-calendar-check-o"></i> Calendar
                    </a>
                </li> -->
                <!-- <li class="divider"></li>
                <li>
                    <a href="page-login1.html">
                        <i class="fa fa-sign-out"></i> Sign Out
                    </a>
                </li> -->
            </ul>
        </li><!-- /.dropdown -->
    </ul><!-- /.navbar-nav -->
</div>