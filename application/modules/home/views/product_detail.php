<!--newsletter -->
<section class="grid-shop">
	<!-- .grid-shop -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if(isset($product_details) && !empty($product_details)) {?>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
					<?=(!empty($product_details[0]['name']) ? '<li class="breadcrumb-item active">'.trim(ucfirst($product_details[0]['name'])).'</a></li>' : '') ?>
				</ol>
				<?php foreach ($product_details as $value) {?>
				<div class="row">
					<!-- left side -->
					<div class="col-sm-5 col-md-5">
	                <div class="clearfix">
						<div class="ubislider-image-container" data-ubislider="#slider4" id="imageSlider4">
							
						</div>
		                <div id="slider4" class="ubislider">
		                    <a class="arrow prev"></a>
		                    <a class="arrow next"></a>
		                    <ul id="gal1" class="ubislider-inner">
		                    	<?php
									$image_url = json_decode($product_details[0]['image_url'], true);
									foreach ($image_url as $key => $img_thumb) {?>
		                    	<li>		                    	
		                    		<a>
		                    			<?php if(!empty($image_url[0])) {
                                        $headers = get_headers(base_url().'frontend/assets/images/products/'.$img_thumb);
                                            echo stripos($headers[0],"200 OK") ? '<img class="product-v-img" src="'.base_url().'frontend/assets/images/products/'.$img_thumb.'?>">' : '<img  class="product-v-img" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
                                        <?php } else {?>
                                        <img class="product-v-img" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                        <?php } ?> 
		                    		</a>
		                    	</li>
		                    	<?php } ?>
		                    	<?php if(!empty($value['product_video'])) {?>
		                    	<li class="append-new-video">
		                    		<?php
		                    			$get_url = explode("/", $value['product_video']);
		                    			$file_name = end($get_url);?>
		                    		<input type="hidden" name="video_url" id="video_url" value="<?=$value['product_video']?>">
		                    		<img class="product-v-img" src="http://i4.ytimg.com/vi/<?=$file_name?>/default.jpg" width="70" height="70">
		                    	</li>
		                    	<?php } ?>
		                    </ul>
		                </div>
		            </div>
					</div>
					<!-- left side -->
					<!-- right side -->
					<div class="col-sm-7 col-md-7">
						<!-- .pro-text -->
						<div class="pro-text product-detail">
							<!-- /.pro-img -->
							<span class="span1"><?=ucfirst(trim($value['brand']))?></span>
							<a class="rokan-product-heading">
								<h4><?=$value['product_name']?></h4>
							</a>
							<div class="star2">
								<ul>
									<?php for ($i = 0; $i < 5; $i++) { ?>
                                        <?php if ($i < $average_rating) { ?>
                                            <li class="yellow-color"><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php } else { ?>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <input hidden value="<?php echo isset($product_review) ? count($product_review) : '0'; ?>" id="rev_count">
									<li><a href="#"><?php echo isset($product_review) ? count($product_review) : '0'; ?> review(s)</a></li>
									<!-- <li><a href="#"> Add your review</a></li> -->
									<?=(isset($add_review_link) && !empty($add_review_link) ? $add_review_link : '')?>
								</ul>
							</div>
							<p><?php if(!empty($value['discounted_price'])) {?>
								<strong>$<?=$value['discounted_price']?></strong> <span class="line-through">$<?=$value["price"]?></span>
								<?php } else { ?>
								<strong>$<?=$value["price"]?></strong>
								<?php } ?></p>
							<p class="in-stock">Availability:   <span><?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>In Stock <?php } else {?> Out of Stock <?php }?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKU:   <span><?=$value['product_sku']?></span></p>
							<p><?=$value['short_description']?></p>
							<?php if(!empty($product_attributes)) {?>
							<div class="col-md-12">
								<ul class="ul-content" style="margin-top: 20px;list-style-type: disc;">
									<?php foreach ($product_attributes as $attr_list) {?>
									<li><?=$attr_list['attribute_value']?> : <?=$attr_list['sub_attribute_value']?></li>
									<?php } ?>
								</ul>
							</div>
							<?php } ?>
							<form>
								<?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
								<div class="numbers-row">
									<input type="text" name="french-hens" id="input-quantity" value="1" size="2">
								</div>
								<!-- <div class="numbers-row">
									QTY : <input type="number" name="french-hens" id="input-quantity" value="1" size="2">
								</div> -->
								<?php } ?>
								<input type="hidden" id="review_product_id" name="review_product_id" value="<?=$value['product_id'] ?>"/>
								<input type="hidden" id="item_id_<?=$value['product_id'] ?>" name="item_id" value="<?=$value['product_id'] ?>"/>
                                <input type="hidden" id="name_<?=$value['product_id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
                                <?php if (isset($value['discounted_price']) && !empty($value['discounted_price'])) { ?>
                                <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
                                <?php } else { ?>
                                <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['price'] ?>"/>
                                <?php } ?>
                                <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
								<?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                    <a onclick="addToCart(<?=$value['product_id'] ?>)" class="addtocart2">Add to cart</a>
                                    <input type="hidden" id="stock_<?php echo $value['product_id'] ?>" name="quantity" value="<?php echo $value['quantity'] ?>"/>
									<a onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)" alter="Wishlist" title="Add To Wishlist" class="hart"><span class="icon icon-Heart"></span></a>
                                <?php } else { ?>
                                    <!-- <button type="button" id="button-cart" disabled="" class="addtocart2">Add to Cart</button> -->
                                    <!-- <small class="text-danger">Out of stock.</small> -->
                                <?php } ?>
							</form>
							<div class="row">
								<div class="col-md-12">
									<hr class="border-new" style="margin-top: 25px;">
								</div>								
							</div>
							<div class="share no-margin-top">
									<p>Share:</p>
									<ul>
										<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>product_detail/<?=$value['product_id']?>&p[title]=<?=$value['product_name']?>&p[summary]=<?=$value['product_name']?> - <?=$value['description']?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li> <a href="http://twitter.com/share?text=<?=$value['product_name']?>&url=<?=base_url().$_SERVER['REQUEST_URI']?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li>
											<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=base_url()?>product_detail/<?=$value['product_id']?>&title=<?=$value['product_name']?>&source=<?=base_url()?>product_detail/<?=$value['product_id']?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
										</li>										
										<li>
											<a href="http://pinterest.com/pin/create/button/?url=<?=base_url()?>product_detail/<?=$value['product_id']?>&media=<?=base_url()?>product_detail/<?=$value['product_id']?>&description=<?=$value['product_name']?> - <?=$value['description']?>"  rel="nofollow" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
										</li>
									</ul>
								</div>
								<div class="tag">
									<p>Categories: <span><?=(!empty($product_details[0]['name']) ? $product_details[0]['name'] : '')?></span></p>
									<!-- <p>Tag: <span>outerwear.</span></p> -->
								</div>

						</div>
						<!-- /.pro-text -->
					</div>
				</div><br>
				<div class="row">
						<div class="tab-bg">
							<ul>
								<li class="active"><a data-toggle="tab" href="#home">DESCRIPTION</a></li>
								<li><a data-toggle="tab" href="#menu1">ADDITIONAL INFORMATION</a></li>
								<li><a data-toggle="tab" href="#menu2">REVIEWS (<?php echo isset($product_review) ? count($product_review) : '0'; ?>)</a></li>
							</ul>
						</div>
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<p><?=$value['description']?></p>
						</div>
						<div id="menu1" class="tab-pane fade">
							<p><?=(!empty($value['additional_information']) ? $value['additional_information'] : 'No additional information found for this product')?></p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<div class="row">
								<div class="col-sm-12">
									<hr/>
										<div class="review-block">
											<div class="row">
												<?php if (isset($product_review) && !empty($product_review)) {
													foreach ($product_review as $review) { ?>
												<div class="col-sm-3">
													<div class="review-block-name"><a href="#"><?=$review['first_name'].' '.$review['last_name'] ?></a></div>
													<div class="review-block-date"><?php echo date('d F Y  h:i A', strtotime($review['created_date'])) ?></div>
												</div>
												<div class="col-sm-9">
													<div class="star2 new-review-stars no-margin">
														<ul class="no-margin">
															<?php for ($i = 0; $i < 5; $i++) {
																if ($i < $review['review_total']) { ?>
																	<li class="yellow-color"><i class="fa fa-star" aria-hidden="true"></i></li>
																<?php } else { ?>
																	<li><i class="fa fa-star" aria-hidden="true"></i></li>
																<?php }
															} ?>																
														</ul>
													</div>
													<div class="review-block-title"><?php echo $review['review_title'] ?></div>
													<div class="review-block-description"><?php echo $review['discription'] ?></div>
												</div>
												<hr/>
												<?php }
												} else { ?>
												<div class="col-md-12">No review found for this product</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }
				} else { ?>

				<div class="col-md-12">No product found</div>

				<?php } ?>
			</div>
			
			<?php if(isset($related_product) && !empty($related_product)) {?>
			<div class="container">
				<!-- title -->
	            <div class="title rokan-product-heading">
	                <h2>Related Products</h2>
	            </div>
	            <!-- /title -->
	            <!-- electonics -->
	            <div class="electonics ">
	                <div class="row">
	                    <!-- tab-content -->
	                    <div class="grid-shop">
	                        <!-- tab-pane -->
	                        <div id="phones2" class="tab-pane fade in active">
	                            <div class="owl-demo-outer">
	                                <!-- #owl-demo -->
	                                <div id="owl-demo6" class="deals-wk2">
	                                    <div class="item">
	                                    <?php $size_of = 0;
	                                        foreach ($related_product as $value) {
	                                            $image_url = json_decode($value['image_url'], true);
	                                            if($size_of > 0 && $size_of%4 == 0) {?>
                                                </div>
                                                <div class="item">
                                                <?php } ?>
	                                        <div class="col-xs-12 col-sm-3 col-md-3">
	                                            <!-- .pro-text -->
	                                            <div class="pro-text text-center">
	                                                <!-- .pro-img -->
	                                                <div class="pro-img"> 
	                                                	<?php if(!empty($image_url[0])) {
                                                            $headers = get_headers(base_url().'frontend/assets/images/products/'.$image_url[0]);
                                                                echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>                                                   
                                                            <!-- <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"> -->
                                                            <?php } else {?>
                                                            <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                            <?php } ?>
	                                                    <!-- .hover-icon -->
	                                                    <div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a></div>
	                                                    <!-- /.hover-icon -->
	                                                </div>
	                                                <!-- /.pro-img -->
	                                                <div class="pro-text-outer"> 
	                                                    <span><?=$value['name']?></span>
	                                                    <a href="<?=base_url().'product_detail/'.$value['product_id']?>">
	                                                        <h4><?=$value['product_name']?></h4>
	                                                    </a>
	                                                    <input type="hidden" id="item_id_<?=$value['product_id'] ?>" name="item_id" value="<?=$value['product_id'] ?>"/>
	                                                    <input type="hidden" id="name_<?=$value['product_id'] ?>" name="name" value="<?=$value['product_name'] ?>"/>
	                                                    <?php if (isset($pData['discounted_price']) && !empty($pData['discounted_price'])) { ?>
	                                                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['discounted_price']?>"/>
	                                                    <?php } else { ?>
	                                                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="price" value="<?=$value['price'] ?>"/>
	                                                    <?php } ?>
	                                                    <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
	                                                    <p class="wk-price">
	                                                    <?php if(!empty($value['discounted_price'])) {?>
                                                        &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["price"]?></span>
                                                        <?php } else { ?>
                                                        &dollar;<?=$value['price']?>
                                                        <?php } ?></p> <a class="new_wishlist" onclick="addToWishList(<?=$value['product_id']?>, <?=$value['category_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a> <a onclick="addToCart(<?=$value['product_id'] ?>)" class="add-btn">Add to cart</a> <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search icon-heart-new"></span></a>
                                                    </div>
	                                            </div>
	                                            <!-- /.pro-text -->
	                                        </div>
	                                        <?php $size_of++;
	                                    } ?>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <!-- /tab-pane -->
	                    </div>
	                    <!-- /tab-content -->
	                </div>
	            </div>
	            <!-- /electonics -->
	        </div>
	        <?php } ?>
		</div>
	</div>
	<!-- /.grid-shop -->
</section>
<!-- newsletter