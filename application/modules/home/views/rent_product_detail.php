<!--newsletter -->
<section class="grid-shop">
	<!-- .grid-shop -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if(isset($product_details) && !empty($product_details)) {?>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
					<?php if(!empty($product_category_name[0]['name'])) {?><li class="breadcrumb-item"><a href=""><?=$product_category_name[0]['name']?></a></li><?php } ?>
					<?=(!empty($product_details[0]['product_name']) ? '<li class="breadcrumb-item active">'.trim(ucfirst($product_details[0]['product_name'])).'</a></li>' : '') ?>
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
                                        $headers = get_headers(base_url().'frontend/assets/images/rent_products/'.$img_thumb);
                                            echo stripos($headers[0],"200 OK") ? '<img class="product-v-img" src="'.base_url().'frontend/assets/images/rent_products/'.$img_thumb.'?>">' : '<img  class="product-v-img" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>
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
							<p><strong><?=(!empty($value["rent"]) ? '$'.$value["rent"] : '$0')?></strong><span>/<?php if($value['plan'] == '0') { echo $per = 'week'; } elseif ($value['plan'] == '1') { echo $per = 'month'; } elseif ($value['plan'] == '2') { echo $per = "year"; } elseif ($value['plan'] == '3') { echo $per = "hour"; } elseif ($value['plan'] == '4') { echo $per = "day"; }?></span></p>
							<input type="hidden" name="date_condition" value="<?php if($value['plan'] == '0') { echo '7'; } elseif ($value['plan'] == '1') { echo '30'; } elseif ($value['plan'] == '2') { echo "365"; } elseif ($value['plan'] == '3') { echo "60"; } elseif ($value['plan'] == '1') { echo "1"; } elseif ($value['plan'] == '4') { echo "1"; }?>" id="date_condition">
							<p class="in-stock">Availability:   <span><?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>In Stock <?php } else {?> Out of Stock <?php }?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKU:   <span><?=$value['product_sku']?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Condition : <span><?php if ($value['product_type'] == '0') { ?> Furbished <?php } elseif($value['product_type'] == '1') {?> New <?php } else { ?> Used <?php } ?></span></p>
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
									<?=form_input(array("id" => "input-quantity", "name" => "french-hens", "value" => '1', 'size' => '2'))?>
								</div>
								<?php } ?>
								<?=form_input(array("type" => "hidden", "id" => "calculate_rent", "name" => "calculate_rent", "value" => $value['rent']))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_product_id", "name" => "rent_product_id", "value" => $value['product_id']))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_duration_".$value['product_id'], "name" => "rent_duration", "value" => ''))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_start_date_".$value['product_id'], "name" => "rent_start_date", "value" => ''))?>
								<?=form_input(array("type" => "hidden", "id" => "review_product_id", "name" => "review_product_id", "value" => $value['product_id']))?>
								<?=form_input(array("type" => "hidden", "id" => "category_id_".$value['product_id'], "name" => "category_id", "value" => $product_category_name[0]['id']))?>
								<?=form_input(array("type" => "hidden", "id" => "item_id_".$value['product_id'], "name" => "item_id_".$value['product_id'], "value" => $value['product_id']))?>
								<?=form_input(array("type" => "hidden", "id" => "name_".$value['product_id'], "name" => "name", "value" => $value['product_name']))?>
								<?=form_input(array("type" => "hidden", "id" => "price_".$value['product_id'], "name" => "rent", "value" => $value['rent']))?>
								<?=form_input(array("type" => "hidden", "id" => "img_url_".$value['product_id'], "name" => "img_url", "value" => $image_url[0]))?>
								<?=form_input(array("type" => "hidden", "id" => "check_rent_date", "name" => "check", "value" => '1'))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_duration_val", "name" => "rent_duration_val", "value" => ''))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_basic_".$value['product_id'], "name" => "rent_basic", "value" => $value['rent']))?>
								<?=form_input(array("type" => "hidden", "id" => "rent_duration_param", "name" => "rent_duration_param", "value" => ''))?>
								<?php if (isset($value['quantity']) && $value['quantity'] > 0) { ?>
                                    <a onclick="addToCart(<?=$value['product_id']?>)" class="addtocart2">Add to cart</a>
                                    <?=form_input(array("type" => "hidden", "id" => "stock_".$value['product_id'], "name" => "quantity", "value" => $value['quantity']))?>
									<a onclick="addToWishList(<?=$value['product_id']?>)" alter="Wishlist" title="Add To Wishlist" class="hart"><span class="icon icon-Heart"></span></a>

									<div class="rental-detail-table">
										<table class="pure-table pure-table-horizontal">
											<tbody>
				                                <tr>
													<td><span>Start Date</span></td>
													<td>
														<?=form_input(array("id" => "datetimepicker1", "class" => "form-control", 'placeholder' => 'Select the date'))?>
													</td>
												</tr>
												<tr>
													<td><span>Duration</span></td>
													<td>
														<?php if($value['plan'] == '4') {?>
														<?=form_input(array('name' => "duration", 'id' => "duration", 'placeholder' => "no of days", 'maxlength' => "3", 'onkeyup' => "getSelectedDuration(".$value['product_id'].")"))?>
														<?php } else {?>
														<select class="form-control" id="duration" onchange="getSelectedDuration(<?=$value['product_id']?>)">
															<option selected="">Select</option>
															<?php if($value['plan'] == '0') {
																for ($i = 1; $i <= 52; $i++) { ?>
																<option value="<?=$i?>"><?=$i?></option>
															<?php }
															} ?>

															<?php if($value['plan'] == '1') {
																for ($i = 1; $i <= 12; $i++) { ?>
																<option value="<?=$i?>"><?=$i?></option>
															<?php }
															} ?>

															<?php if($value['plan'] == '2') {
																for ($i = 1; $i <= 10; $i++) { ?>
																<option value="<?=$i?>"><?=$i?></option>
															<?php }
															} ?>
														</select>
														<?php } ?>
														<!-- <div>
															<span class="col-md-8">
																<input type="text" name="duration" placeholder="enter duration of rent"></span><span class="col-md-4">/<?=$per?></span>
														</div> -->
													</td>
												</tr>
												<!-- <tr>
													<td><span>End Date</span></td>
													<td>
														<?=form_input(array("id" => "datetimepicker2", "class" => "form-control"))?>
													</td>
												</tr> -->
											</tbody>
										</table>
									</div>
                                <?php } else { ?>
                                	<div class="rental-detail-table">
                                		<h5>Out of stock notification</h5>
	                                	<table class="pure-table pure-table-horizontal">
											<tbody>
				                                <tr>
													<td>
														<span>
															<?=form_input(array("type" => "email", "id" => "notify_me", "class" => "form-control", "placeholder" => "Enter the email id", "required" => "required"))?>
														</span>
													</td>
													<td>
														<?=form_input(array('type' => 'button', 'class' => 'btn btn-success', 'value' => 'Notify Me', 'id' => 'notify_me_btn'))?>
														<span class="notify_error" style="color:red"></span>
													</td>
												</tr>
												<!-- <tr><td><span class="notify_error"></span></td></tr> -->
											</tbody>
										</table>
										<div id="notification_message"></div>
									</div>
                                    <!-- <button type="button" id="button-cart" disabled="" class="addtocart2">Add to Cart</button> -->
                                    <!-- <small class="text-danger">Out of stock.</small> -->
                                <?php } ?>                                
							</form>
							<div class="share no-margin-top">
									<p>Share:</p>
									<ul>
										<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>rent_product_detail/<?=$value['product_id']?>&p[title]=<?=$value['product_name']?>&p[summary]=<?=$value['product_name']?> - <?=$value['description']?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li> <a href="http://twitter.com/share?text=<?=$value['product_name']?>&url=<?=base_url().$_SERVER['REQUEST_URI']?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li>
											<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=base_url()?>rent_product_detail/<?=$value['product_id']?>&title=<?=$value['product_name']?>&source=<?=base_url()?>rent_product_detail/<?=$value['product_id']?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
										</li>										
										<li>
											<a href="http://pinterest.com/pin/create/button/?url=<?=base_url()?>rent_product_detail/<?=$value['product_id']?>&media=<?=base_url()?>rent_product_detail/<?=$value['product_id']?>&description=<?=$value['product_name']?> - <?=$value['description']?>"  rel="nofollow" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
										</li>
									</ul>
								</div>
								<div class="tag">
									<p>Categories: 
										<?php foreach ($categories as $list) {?>
										<span><?=$list['name']?>,</span>
										<?php } ?>
										<span><?=(!empty($product_category_name[0]['name']) ? $product_category_name[0]['name'] : '')?></span>
									</p>
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
								<li><a data-toggle="tab" href="#menu3">DOCUMENTS</a></li>
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
							
							<div id="menu3" class="tab-pane fade">
								<div class="doclist">
									<!-- <h4>Lorem Ispum</h4> -->
									<p><?=$value['documents']?></p>
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
                                                            $headers = get_headers(base_url().'frontend/assets/images/rent_products/'.$image_url[0]);
                                                                echo stripos($headers[0],"200 OK") ? '<img class="img-responsive" src="'.base_url().'frontend/assets/images/rent_products/'.$image_url[0].'">' : '<img class="img-responsive" src="'.base_url().'frontend/assets/images/default_product.jpg">';?>                                                   
                                                            <!-- <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/products/<?=$image_url[0]?>"> -->
                                                            <?php } else {?>
                                                            <img class="img-responsive" src="<?=base_url()?>frontend/assets/images/default_product.jpg">
                                                            <?php } ?>
	                                                    <!-- .hover-icon -->
	                                                    <div class="hover-icon"> <a onclick="addToWishList(<?=$value['product_id']?>)"><span class="icon icon-Heart"></span></a> <a href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search"></span></a></div>
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
	                                                    <input type="hidden" id="price_<?=$value['product_id'] ?>" name="rent" value="<?=$value['rent'] ?>"/>
	                                                    <?php } ?>
	                                                    <input type="hidden" id="img_url_<?=$value['product_id'] ?>" name="img_url" value="<?=$image_url[0] ?>"/>
	                                                    <p class="wk-price">
	                                                    <?php if(!empty($value['discounted_price'])) {?>
                                                        &dollar;<?=$value['discounted_price']?> <span class="line-through">$<?=$value["rent"]?></span>
                                                        <?php } else { ?>
                                                        &dollar;<?=$value['rent']?>
                                                        <?php } ?></p> <a class="new_wishlist" onclick="addToWishList(<?=$value['product_id']?>)"><span class="icon icon-Heart icon-heart-new"></span></a> <a onclick="addToCart(<?=$value['product_id'] ?>)" class="add-btn">Add to cart</a> <a class="new_wishlist" href="<?=base_url()?>product_detail/<?=$value['product_id']?>"><span class="icon icon-Search icon-heart-new"></span></a>
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