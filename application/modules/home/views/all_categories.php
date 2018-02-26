<style type="text/css">
   
    .all-category-list h5 {
        font-size: 16px;
        text-transform: uppercase;
        color: #B11E22;
        margin-bottom: 15px;
    }

    .all-category-list h5 a {
        border-bottom: 1px solid;
    }

    ul.category-accordion {
      list-style: none;
      padding: 0;
    }
    ul.category-accordion .inner {
      padding-left: 1em;
      overflow: hidden;
      /*display: none;*/
      margin-bottom: 10px;
    }

    ul.category-accordion .inner a {
      color: #868686;
    }

    ul.category-accordion .inner.show {
      /*display: block;*/
    }
    ul.category-accordion li {
        position: relative;
    }
    ul.category-accordion li a.toggle {
      width: 100%;
      display: block;
      /*background: rgba(0, 0, 0, 0.78);
      color: #fefefe;
      padding: .75em;*/
      /*padding-bottom: 10px;*/
      border-radius: 0.15em;
      transition: background .3s ease;
      text-decoration:none;
      margin: 5px;
    }
    ul.category-accordion li a.toggle:hover {
      /*background: rgba(0, 0, 0, 0.9);*/
    }

    ul.category-accordion .inner a {
        color: #868686;
        border-bottom: 1px solid #fff;
    }
    ul.category-accordion .inner a:hover {
        color: #B11E22;
        border-bottom: 1px solid #B11E22;
    }
    ul.category-accordion .inner li:after {
        content: "\f101";    
        position: absolute;
        left: -13px;
        top: 5px;
        font: normal normal normal 14px/1 FontAwesome;
    }

    ul.category-accordion .inner li:hover:after {
        color: #B11E22;
    }
  
</style>
<section class="shopping-cart">
    <!-- .shopping-cart -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
                    <li class="breadcrumb-item active">All Categories</li>
                </ol>
            </div>
            <div class="row">
            <div class="col-md-12 all-category-list">
              <?php if(!empty($product_categories_level) && !empty($this->uri->segment(3))) {?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <?php foreach ($product_categories_level as $value) {?>
                    <h5><i class="fa fa-caret-right" aria-hidden="true"></i> <a href="#"><?=$value['name']?></a></h5>
                    <?php foreach ($value['sub_categories'] as $sub_cat_list) {?>
                    <ul class="category-accordion">
                      <li>
                        <a class="toggle" href="<?=base_url().'home/product_list/'.$sub_cat_list['id']?>"><i class="fa fa-caret-right" aria-hidden="true"></i>  <?=$sub_cat_list['name']?></a>
                        <ul class="inner">
                            <?php foreach ($sub_cat_list['third_level'] as $third_level_list) {?>
                            <li><a href="<?=base_url().'home/product_list/'.$third_level_list['id']?>"><?=$third_level_list['name']?></a></li>
                            <?php } ?>
                        </ul>
                      </li>
                    </ul>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php } else { ?>
                <style type="text/css">.all-category-list ul {float: left;width: 25%;margin-bottom: 20px;}</style>
                <?php
                    foreach ($product_categories as $productCat) {?>
                      <ul>
                          <li><a href="#"><strong><?=$productCat['name']; ?></strong></a></li>
                          <?php if (isset($productCat['sub_categories']) && !empty($productCat['sub_categories'])) {
                              foreach ($productCat['sub_categories'] as $paData) {?>
                                  <li><a href="<?=base_url(); ?>home/categories/<?=$paData['id'] ?>" ><?=$paData['name'] ?></a> </li>
                              <?php }
                          } ?>
                      <!-- <li><a href="javascript:;" class="link-current">Active</a></li> -->
                      </ul>
                  <?php
                  } ?>
              <?php } ?>

                <!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                    <h5>
                        <a href="#">TV, Appliances, Electronics</a></h5>
                    <ul class="category-accordion">
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  Televisions</a>
                        <ul class="inner">
                          <li><a href="">Home Entertainment Systems</a></li>
                          <li><a href="">Headphones</li>
                          <li><a href="">Speakers</li>
                        </ul>
                      </li>
                      
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  MP3, Media Players & Accessories</a>
                        <ul class="inner">
                          <li><a href="">Audio & Video Accessories</a></li>
                          <li><a href="">Cameras</a></li>
                          <li><a href="">DSLR Cameras</a></li>
                        </ul>
                      </li>                    
                  </ul>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                    <h5>
                        <a href="#">TV, Appliances, Electronics</a></h5>
                    <ul class="category-accordion">
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  Televisions</a>
                        <ul class="inner">
                          <li><a href="">Home Entertainment Systems</a></li>
                          <li><a href="">Headphones</li>
                          <li><a href="">Speakers</li>
                        </ul>
                      </li>
                      
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  MP3, Media Players & Accessories</a>
                        <ul class="inner">
                          <li><a href="">Audio & Video Accessories</a></li>
                          <li><a href="">Cameras</a></li>
                          <li><a href="">DSLR Cameras</a></li>
                        </ul>
                      </li>                    
                  </ul>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"> 
                    <h5>
                        <a href="#">TV, Appliances, Electronics</a></h5>
                    <ul class="category-accordion">
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  Televisions</a>
                        <ul class="inner">
                          <li><a href="">Home Entertainment Systems</a></li>
                          <li><a href="">Headphones</li>
                          <li><a href="">Speakers</li>
                        </ul>
                      </li>
                      
                      <li>
                        <a class="toggle" href=""><i class="fa fa-caret-right" aria-hidden="true"></i>  MP3, Media Players & Accessories</a>
                        <ul class="inner">
                          <li><a href="">Audio & Video Accessories</a></li>
                          <li><a href="">Cameras</a></li>
                          <li><a href="">DSLR Cameras</a></li>
                        </ul>
                      </li>                    
                  </ul>
                </div> -->
            </div>
            </div>
        </div>
    </div>
    <!-- /.shopping-cart -->
</section>
