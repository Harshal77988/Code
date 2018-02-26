<section class="grid-shop">
	<!-- .grid-shop -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
					<li class="breadcrumb-item active"><?=(!empty($category_title) ? $category_title : 'All Products')?></li>
				</ol>
			</div>
			<div class="col-sm-3 col-md-3" id="productlist">
				<?php if (isset($rent_product_categories) && !empty($rent_product_categories)) {?>
				<div class="weight">
					<div class="title" style="float: none;">
						<h2>Categories</h2>
					</div>
					<div id="menu" class="filter-outer">
						<ul>
						<?php if (isset($rent_product_categories[0]['sub_categories']) && !empty($rent_product_categories[0]['sub_categories'])) {?>
						<?php foreach ($rent_product_categories[0]['sub_categories'] as $key => $v_list) {?>
							<li><input type="checkbox" name="rent_category_filter" value="<?=$v_list['id']?>" id="category_checkbox"> <?=$v_list['name']?></li>
                    	<?php } ?>
                    	</ul>
					</div>
				</div>
				<?php } } ?>
				<div class="weight">
					<div class="title">
						<h2>filter products</h2>
					</div>
					<div class="filter-outer">
						<!-- filter products by price range -->
						<div class="brands">
							<h3>By Price</h3>
                            <ul>
                            	<li>
                            		<input maxlength="6" type="number" name="start_price" id="start_price" value="0" style="display: inline;width: 30%; height: 36px;" max="9999" min="0">
	                        		<input maxlength="6" type="number" name="end_price" id="end_price" value="0" style="margin: 0 0 0 1%;display: inline;width: 30%; height: 36px;" max="9999" min="0">
	                        		<input type="hidden" name="category_id" id="category_id" value="<?=$this->uri->segment(3)?>">
	                        		<input type="hidden" name="subcategory_id" id="subcategory_id" value="<?=$this->uri->segment(4)?>">
                            		<input class="btn new_wishlist filter_price" type="submit" name="filter_price" value="GO">
                            	</li>
                            </ul>
						</div>

						<!-- filter products by brands -->
						<div class="brands">
							<h3>Brands</h3>
                            <ul>
								<?php if (!empty($brands)) {
									foreach ($brands as $brand_list) {?>
									<li><input type="checkbox" name="rent_brand_filter" value="<?=$brand_list['brand_id']?>" id="rent_brand_checkbox"> <?=$brand_list['brand_name']?></li>
								<?php 
									}
								} ?>
							</ul>
						</div>

						<!-- filter products by attributes -->
						<div class="brands">
							<h3>Product Type</h3>
                            <ul>
                            	<li><input type="checkbox" name="rent_attribute_filter" value="0" id="brand_checkbox"> Furbished</li>
                            	<li><input type="checkbox" name="rent_attribute_filter" value="1" id="brand_checkbox"> New</li>
                            	<li><input type="checkbox" name="rent_attribute_filter" value="2" id="brand_checkbox"> Used</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-9 col-md-9 product_filter">
				<!-- <div class="col-md-12 grid-banner"> <img src="<?=base_url()?>frontend/assets/images/Grid-banner.png" alt="Grid-banner" /> </div>
				<div class="grid-spr">
					
				</div> -->
				<?php if(isset($product_details) && !empty($product_details)) {
                    foreach ($product_details as $value) {
                        $image_url = json_decode($value['image_url'], true);?>
	                    <div class="col-xs-12 col-sm-6 col-md-4 product_link">
							<!-- .pro-text -->
							<div class="pro-text text-center">
								<!-- .pro-img -->
								<!-- <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'">  -->
								<div class="pro-img"> 
									<?php if(!empty($image_url[0])) {?>
                                    <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/rent_products/<?=$image_url[0]?>" alt="2">                                    
                                    <?php } else {?>
                                    <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                    <?php } ?>
									<!-- .hover-icon -->
									<div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>rent_product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a> <!-- <a href="#"><span class="icon icon-Restart"></span></a> --> </div>
									<!-- /.hover-icon -->
								</div>
								<!-- /.pro-img -->
								<div class="pro-text-outer"> 
									<span><?=$product_category_name[0]['name']?></span>
									<a href="<?=base_url()?>home/rent_product_detail/<?=$value['product_id']?>/<?=$product_category_name[0]['id']?>">
										<h4><?=substr($value['product_name'], 0, 20)?></h4>
									</a>
									<?=form_input(array("type" => "hidden", "id" => "category_id_".$value['product_id'], "name" => "category_id", "value" => $product_category_name[0]['id']))?>
									<?=form_input(array("type" => "hidden", "id" => "item_id_".$value['product_id'], "name" => "item_id", "value" => $value['product_id']))?>
									<?=form_input(array("type" => "hidden", "id" => "name_".$value['product_id'], "name" => "name", "value" => $value['product_name']))?>
									<?=form_input(array("type" => "hidden", "id" => "price_".$value['product_id'], "name" => "rent", "value" => $value['rent']))?>
									<?=form_input(array("type" => "hidden", "id" => "img_url_".$value['product_id'], "name" => "img_url", "value" => $image_url[0]))?>
									<p class="wk-price1"><strong><?=(!empty($value["rent"]) ? '$'.$value["rent"] : '$0')?></strong><span>/<?php if($value['plan'] == '0') { echo 'week'; } elseif ($value['plan'] == '1') { echo 'month'; } elseif ($value['plan'] == '2') { echo "year"; } elseif ($value['plan'] == '3') { echo "Hour"; } elseif ($value['plan'] == '4') { echo "Day"; } ?></span></p>
                                        <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                        <a href="<?=base_url()?>home/rent_product_detail/<?=$value['product_id']?>/<?=$product_category_name[0]['id']?>" class="add-btn">View Detail</a>
                                    <?php } else {?>
                                        <a class="add-btn">Out of stock</a>
                                    <?php } ?>
                                </div>
							</div>
							<!-- /.pro-text -->
						</div>
                    <?php }
                    } else {?>
                    	<div class="col-sm-8 col-md-offset-2" style="margin-top: 20px">
                    		<center><img src="<?=base_url()?>frontend/assets/images/no-product-found.png" class="img-responsive"></center>
                    		<center>
								The category you have selected does not contain products. Perhaps you can select another category
								<!-- <a href="#" style="color: #B11E22;">Homepage</a>  -->
								and see if you can find what you are looking for.
							</center>
                    		<!-- <p>Product not found for this category</p> -->
                    	</div>
                    <?php }
				?>
			</div>
			<div class="col-xs-9 col-xs-offset-3">
				<div class="grid-spr pag">
					<!-- .pagetions -->
					<!-- <div class="col-xs-12 col-sm-6 col-md-6 text-left"> -->
						<?php echo $this->ajax_pagination->create_links(); ?>
						<!-- <ul class="pagination">
							<li class="active"><a href="#">1</a></li>
							<li><a href="<?=base_url()?>home/product_list/<?=$this->uri->segment(3)?>">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">»</a></li>
						</ul> -->
					<!-- </div> -->
					<!-- /.pagetions -->
					<!-- .Showing -->
					<!-- <div class="col-xs-12 col-sm-6 col-md-6 text-right">
						<strong>Showing 1-12 <span>of 30 relults</span></strong>
					</div> -->
					<!-- /.Showing -->
				</div>
			</div>
		</div>
	</div>
	<!-- /.grid-shop -->
</section>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
	    $(".dropdown").click(function () {
	        $(".sub_cat_dropdown").toggle();
	    });
	});
</script>