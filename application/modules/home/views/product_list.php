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
				<!-- <div class="weight">
					<div class="title">
						<h2>Categories</h2>
					</div>
					<div class="product-categories">
						<ul class="category_dropdown_toggle">
						<?php if (isset($prodcut_cat_detail) && !empty($prodcut_cat_detail)) {
							$sub_count = 1;
                            foreach ($prodcut_cat_detail as $productCat) {
                            ?>
                            <li class="dropdown"><strong><?=$productCat['name']; ?></strong>
                            	<ul class="sub_cat_dropdown" style="display: none;">
                            		<?php if (isset($productCat['sub_attibutes']) && !empty($productCat['sub_attibutes'])) {
		                                $subattr_count = 1;
		                                foreach ($productCat['sub_attibutes'] as $paData) {?>
		                                    <li><a href="<?=base_url(); ?>home/product_list/<?=$productCat['id'] . '/' . $paData['p_sub_category_id'] ?>" ><?=$paData['attrubute_value'] ?></a> </li>
		                                <?php }
		                            }?>
                            	</ul>
                            </li>
                            <?php } ?>
                        <?php } ?>
                        </ul>
					</div>
				</div> -->

				<div class="weight">
					<div class="title" style="float: none;">
						<h2>Categories</h2>
					</div>
					<div id="menu filter-outer">
						<div class="panel list-group">
							<?php if (isset($product_categories) && !empty($product_categories)) {
								$first_count = 1;
	                            foreach ($product_categories as $productCat) {?>
								<a class="list-group-item" data-toggle="collapse" data-target="#collapse_toggle<?=$first_count?>" data-parent="#menu"><strong><?=$productCat['name']; ?></strong> <i class="fa-angle-down pull-right"></i></a>
								<div class="accordion-body collapse" id="collapse_toggle<?=$first_count?>">
									<div class="accordion-inner">
										<div class="accordion" id="equipamento<?=$first_count?>">
											<!-- Equipamentos -->
											<div class="accordion-group tree2">
												<?php if (isset($productCat['sub_categories']) && !empty($productCat['sub_categories'])) {
													$second_count = 1;
													foreach ($productCat['sub_categories'] as $key => $second_level) {?>
												<div class="accordion-heading equipamento">
													<a class="accordion-toggle" href="javascript(0);"><?=$second_level['name']?></a><span><i data-parent="#equipamento<?=$first_count?>" data-target="#ponto<?=$first_count.$second_count?>" data-toggle="collapse" class="fa fa-angle-down pull-right" aria-hidden="true"></i></span>
												</div>
												<!-- Pontos -->
												<div class="accordion-body collapse" id="ponto<?=$first_count.$second_count?>">
													<div class="accordion-inner">
														<div class="accordion" id="servico1">
															<div class="accordion-group tree3">
																<?php if (isset($second_level['third_level']) && !empty($second_level['third_level'])) {
																	$third_count = 1;
																	foreach ($second_level['third_level'] as $key => $third_level) {?>
																<div class="accordion-heading ponto">
																	<a class="accordion-toggle" href="javascript(0);"><?=$third_level['name']?></a><span><i data-parent="#servico1-1-1" data-toggle="collapse" data-target="#servico<?=$first_count.$second_count.$third_count?>" class="fa fa-angle-down pull-right" aria-hidden="true"></i></span>
																</div>
																<!-- Serviços -->
																<div class="accordion-body collapse" id="servico<?=$first_count.$second_count.$third_count?>">
																	<?php if (isset($third_level['forth_level']) && !empty($third_level['forth_level'])) {
																	foreach ($third_level['forth_level'] as $key => $forth_level) {?>
																	<div class="accordion-inner">
																		<div class="final_category"><a href="<?=base_url(); ?>home/product_list/<?=$forth_level['id']?>"><i class="fa fa-angle-right"></i> <?=$forth_level['name']?></a></div>
																	</div>
																	<?php }
																	} ?>
																</div>
																<?php $third_count++; }
																} ?>
																<!-- /Serviços -->
															</div>
														</div>
													</div>
												</div>
												<?php $second_count++; }
												} ?>												
												<!-- /Pontos -->
											</div>
											<!-- /Equipamentos -->
										</div>
									</div>
								</div>

								<!--div id="collapse_toggle<?=$sub_count?>" class="sublinks collapse">
								<?php if (isset($productCat['sub_attibutes']) && !empty($productCat['sub_attibutes'])) {
		                                $subattr_count = 1;
		                                foreach ($productCat['sub_attibutes'] as $paData) {?>
									<a href="<?=base_url(); ?>home/product_list/<?=$productCat['id'] . '/' . $paData['p_sub_category_id'] ?>" class="list-group-item small"><i class="fa-angle-double-right"></i> <?=$paData['attrubute_value'] ?></a>
									<?php } ?>
								<?php } ?>
								</div-->
	                        <?php $first_count++; }
	                    	}?>
						</div>
					</div>
				</div>
				<!-- <li><a class="accordion-toggle" data-toggle="collapse" href="#area1">Laptop & Computer  <span><i class="fa fa-angle-down" aria-hidden="true"></i></span></a></li> -->
				<div class="weight">
					<div class="title">
						<h2>filter products</h2>
					</div>
					<div class="filter-outer">
						<!-- <a href="#">Reset all Filters</a> -->
						<!-- End of Bootstrap Pricing Slider by ZsharE -->
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
							<h3>By Brands</h3>
                            <ul>
								<?php if (!empty($brands)) {
									foreach ($brands as $brand_list) {?>
									<li><input type="checkbox" name="brand_filter" value="<?=$brand_list['brand_id']?>" id="brand_checkbox"> <?=$brand_list['brand_name']?></li>
								<?php 
									}
								} ?>
							</ul>
						</div>

						<!-- filter products by attributes -->
						<div class="brands">
							<h3>By Attributes</h3>
                            <ul>
								<?php if (!empty($product_attributes)) {
									foreach ($product_attributes as $value) {?>
									<li>
										<?php if (!empty($value['sub_attributes_values'])) {?>
										<a><b><?=ucfirst($value['attribute_value'])?></b></a>
										<ul>
											<?php foreach ($value['sub_attributes_values'] as $sub_value) {?>
											<li><input type="checkbox" name="attribute_filter" value="<?=$value['attribute_value'].'_'.$sub_value['sub_attribute_value']?>" id="attribute_checkbox"> <?=$sub_value['sub_attribute_value']?></li>
										<?php 
										} ?>		
										</ul>
										<?php } ?>	
									</li>
								<?php 
									}
								} ?>
							</ul>
						</div>

						<div class="brands">
							<h3>Availability</h3>
                            <ul>
								<li><input type="checkbox" name="stock_checkbox" value="in_stock" id="stock_checkbox"> In stock</li>
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
	                    <div class="col-xs-12 col-sm-6 col-md-3 product_link">
							<!-- .pro-text -->
							<div class="pro-text text-center">
								<!-- .pro-img -->
								<!-- <div class="pro-img" onclick="window.location.href='<?=base_url()?>product_detail/<?=$value['product_id']?>'">  -->
								<div class="pro-img"> 
									<?php if(!empty($image_url[0])) {?>
                                    <img class="img-responsive" src="<?=base_url() ?>frontend/assets/images/products/<?=$image_url[0]?>" alt="2">
                                    <?php if($value['on_sale'] == '1') {?>
                                    	<sup class="sale-tag">sale!</sup>
                                    <?php } ?>
                                    <?php } else {?>
                                    <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                    <?php } ?>
									<!-- .hover-icon -->
									<div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a> <!-- <a href="#"><span class="icon icon-Restart"></span></a> --> </div>
									<!-- /.hover-icon -->
								</div>
								<!-- /.pro-img -->
								<div class="pro-text-outer"> 
									<span><?=$value['category_name']?></span>
									<a href="<?=base_url()?>product_detail/<?=$value['product_id']?>">
										<h4><?=substr($value['product_name'], 0, 20)?></h4>
									</a>
									<input type="hidden" id="item_id_<?=$value['product_id'] ?>" name="item_id" value="<?=$value['product_id'] ?>"/>
                                    <input type="hidden" id="name_<?=$value['product_id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                                    <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                                    <?php } else { ?>
                                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                                    <?php } ?>
                                    <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
									<p class="wk-price"><?php if(!empty($value['discounted_price'])) {?>
                                        &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span>
                                        <?php } else { ?>
                                        &dollar;<?=$value['price']?>
                                        <?php } ?></p>
                                        <?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                        <!-- <a class="new_wishlist" onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a>  -->
                                        <a onclick="addToCart(<?=$value['product_id'] ?>)" class="add-btn">Add to cart</a>
                                        <!-- <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search icon-heart-new"></span></a> -->
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

				<div class="col-xs-12">
					<div class="grid-spr pag">
						<?php echo $this->ajax_pagination->create_links(); ?>
					</div>
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