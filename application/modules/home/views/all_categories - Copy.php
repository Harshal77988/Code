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
              <?php if (isset($product_categories) && !empty($product_categories)) {?>
                  <?php
                      $sub_count = 1;
                      foreach ($product_categories as $productCat) {
                          // if($sub_count <= 6) {
                      ?>
                      <ul>
                          <li><a href="#"><strong><?=$productCat['name']; ?></strong></a></li>
                          <?php if (isset($productCat['sub_categories']) && !empty($productCat['sub_categories'])) {
                              $subattr_count = 1;
                              foreach ($productCat['sub_categories'] as $paData) {
                                  if($subattr_count <= 5) {
                                  // echo $paData['is_brand'];
                                  // if($paData['is_brand'] == 2) {
                                  ?>
                                  <li><a href="<?=base_url(); ?>home/categories/<?=$paData['id'] ?>" ><?=$paData['name'] ?></a> </li>
                                  <?php //}
                                  }
                                  $subattr_count++;
                              }

                              if(count($productCat['sub_categories']) > 5) { ?>
                              <!-- <a href="<?=base_url() . 'home/categories/' . $productCat['id']; ?>" >All <?=$productCat['name']; ?></a> -->
                              <a href="<?=base_url() . 'home/categories/' ?>" >All <?=$productCat['name']; ?></a>
                              <?php }
                          } ?>
                      <!-- <li><a href="javascript:;" class="link-current">Active</a></li> -->
                      </ul>
                  <?php
                      // }
                      $sub_count++;
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
