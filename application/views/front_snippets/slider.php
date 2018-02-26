<section class="header-outer3">
    <!-- header-slider -->
    <div class="header-slider3">
        <div id="home-slider" class="carousel slide carousel-fade" data-ride="carousel">
            <!-- .home-slider -->
            <div class="carousel-inner">

                <?php if(!empty($login_slider)){
                    $ls_count=1;
                    foreach($login_slider as $l_slider){?>
                    <div class="item <?php if($ls_count==1){ echo 'active'; }?>" style="background-image: url(<?= base_url() ?>backend/assets/img/<?=$l_slider['field_output_value']?>);  background-repeat: no-repeat; background-position: top;">
                        <div class="container">
                            <div class="home3-caption">
                                <div class="home3-caption-outer">
                                    <div class="header-text">
                                        <sup class="bg-red"><?=$l_slider['label1']?></sup>
                                        <h6><?=$l_slider['label2']?></h6>
                                        <h2><?=$l_slider['label3']?></h2>
                                        <p><?=$l_slider['label4']?></p>
                                        <a href="<?=$l_slider['link']?>">shop now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $ls_count++;} 
                }else{?>
                <div class="item active" style="background-image: url(<?= base_url() ?>frontend/assets/images/home3-header.jpg);  background-repeat: no-repeat; background-position: top;">
                    <div class="container">
                        <div class="home3-caption">
                            <div class="home3-caption-outer">
                                <div class="header-text">
                                    <sup class="bg-red">hot!</sup>
                                    <h6>Top selling </h6>
                                    <h2>Quantum Dot</h2>
                                    <p>The world’s most lifelike picture this is TV</p>
                                    <a href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url(<?= base_url() ?>frontend/assets/images/home3-header2.jpg);  background-repeat: no-repeat; background-position: top;">
                    <div class="container">
                        <div class="home3-caption">
                            <div class="home3-caption-outer">
                                <div class="header-text">
                                    <sup class="bg-red">hot!</sup>
                                    <h6>Top selling </h6>
                                    <h2>Quantum Dot</h2>
                                    <p>The world’s most lifelike picture this is TV</p>
                                    <a href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url(<?= base_url() ?>frontend/assets/images/home3-header3.jpg);  background-repeat: no-repeat; background-position: top;">
                    <div class="container">
                        <div class="home3-caption">
                            <div class="home3-caption-outer">
                                <div class="header-text">
                                    <sup class="bg-red">hot!</sup>
                                    <h6>Top selling </h6>
                                    <h2>Quantum Dot</h2>
                                    <p>The world’s most lifelike picture this is TV</p>
                                    <a href="#">shop now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>


            </div>
            <!-- indicators -->
            <ol class="carousel-indicators">
                <li data-target="#home-slider" data-slide-to="0" class="active"></li>
                <li data-target="#home-slider" data-slide-to="1"></li>
                <li data-target="#home-slider" data-slide-to="2"></li>
            </ol>
            <!-- /indicators -->
            <!-- /.home-slider -->
        </div>
    </div>
</section>