	<!-- newsletter -->
	<section class="grid-shop blog">
		<!-- .grid-shop -->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Blogs</li>
					</ol>
				</div>
				<div class="col-sm-3 col-md-3">
					<div class="weight">
						<div class="title">
							<h2>Categories</h2>
						</div>
						<div class="product-categories">
							<ul>
								<?php if(count($cat_data)>0){ 
								    foreach($cat_data as $key=> $data){
								 ?>
								<li>
								        <a href="<?php echo base_url(); ?>blog-category-details-main/<?php echo $data['category_id']; ?>"><?php echo $data['category_name']; ?>  
								            <!--<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>-->
								        </a>
								    </li>
								<?php }} ?>
							</ul>
						</div>
					</div>		
<!--					<div class="weight">
						<div class="title">
							<h2>RECENT POST</h2>
						</div>
						<div class="recent-box">
							<ul>
								<li>
									<div class="e-product">
										<div class="pro-img"> <img src="<?=base_url()?>frontend/assets/images/rp-img1.jpg" alt="2"> </div>
										<div class="pro-text-outer"> 											
											<a href="#">
												<h4> Curabitur lobortis </h4>
											</a>
											<span>March 20, 2017</span>
										</div>
									</div>
								</li>
								<li>
									<div class="e-product">
										<div class="pro-img"> <img src="<?=base_url()?>frontend/assets/images/rp-img2.jpg" alt="2"> </div>
										<div class="pro-text-outer"> 											
											<a href="#">
												<h4> Curabitur lobortis </h4>
											</a>
											<span>March 20, 2017</span>
										</div>
									</div>
								</li>
								<li>
									<div class="e-product">
										<div class="pro-img"> <img src="<?=base_url()?>frontend/assets/images/rp-img3.jpg" alt="2"> </div>
										<div class="pro-text-outer"> 											
											<a href="#">
												<h4> Curabitur lobortis </h4>
											</a>
											<span>March 20, 2017</span>
										</div>
									</div>
								</li>
								<li>
									<div class="e-product">
										<div class="pro-img"> <img src="<?=base_url()?>frontend/assets/images/rp-img4.jpg" alt="2"> </div>
										<div class="pro-text-outer"> 											
											<a href="#">
												<h4> Curabitur lobortis </h4>
											</a>
											<span>March 20, 2017</span>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>-->
					<div class="weight">
						<div class="title">
							<h2>ARCHIVES</h2>
						</div>
						<div class="archives-box">
							<ul>
							<?php if(!empty($blog_archieve_months)) {
								foreach ($blog_archieve_months as $key => $m_list) {?>
								<li><a onclick="getArchievePost(<?=$m_list['created_month']?>)"><?=$m_list['created_month']?></a></li>
								<?php } }?>
							</ul>
						</div>
					</div>
					<div class="weight">
						<div class="title">
							<h2>Blog tags</h2>
						</div>
						<div class="blog-tags-box">
							<ul>
								<?php if(!empty($blog_tags)) {
									foreach ($blog_tags as $key => $value) {?>
									<li><a href="<?=$value['tag']?>"><?=$value['tag']?></a></li>
								<?php }
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-9 col-md-9">
                                    <?php if(count($blog_posts_two) > 0){
                                        foreach($blog_posts_two as $key=> $data){
                                        ?>
                                    <div class="col-md-4"> 
						<!-- .blog-outer -->
						<div class="blog-outer">
						<div class="blog-img">
						<a href="<?php echo base_url(); ?>blog-details/<?php echo $data['post_id']; ?>" >	
                                                    <img src="<?=base_url()?>backend/uploads/blogs/395x250/<?php echo $data['blog_image'] ?>" alt="Grid-banner" /> 
                                                </a>	
                                                        <div class="blog-img-hover">
								<a href="<?php echo base_url(); ?>blog-details/<?php echo $data['post_id']; ?>"><i class="fa fa-link" aria-hidden="true"></i></a>
							</div>
						</div>						
						<!-- .blog-text -->				
						<div class="blog-text">
							<a href="<?php echo base_url(); ?>blog-details/<?php echo $data['post_id']; ?>"><h3><?php echo (strlen($data['post_title']) > 50)?substr($data['post_title'],0,50) .'...':$data['post_title'];?></h3></a>
							<p><span>
                                                                <?=date('D j M, Y ', strtotime($data['posted_on'])); ?>
                                                            <?php //echo date_format($data['posted_on'], "F j, Y, g:i a"); ?>
                                                            </span> by <span class="red"><?php echo $data['first_name'].' '.$data['last_name'];?></span>
                                                            <!--in <span class="red">Fashion for men’s</span>-->
                                                        </p>
							<p>
                                                             <?php echo substr($data['post_content'], 0, 300) .((strlen($data['post_content']) > 300) ? '...' : ''); ?>
                                                            
                                                        </p>
							<div class="btn-outer">
								<a href="<?php echo base_url(); ?>blog-details/<?php echo $data['post_id']; ?>" class="read-more">read more</a>
<!--								<ul>
									<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> 01</a></li>
									<li><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i> 01</a></li>									
								</ul>-->
							</div>
						</div>
						<!-- /.blog-text -->				
						</div>
						<!-- /.blog-outer -->						
					</div>
                                        <?php }}else{ ?>
                                        No blogs added yet.
                                    <?php } ?>
                                    
                                    
					
                                        <div style="clear:both"></div>
                                        <div class="row" style="margin-bottom:40px;">
					<div class="text-center pagination-det ">
                                            <ul class="pagination">
                                                <?php echo $create_links; ?>
                                            </ul>
                                        </div>
                                        </div>
					
<!--					<div class="col-xs-12">
						<div class="">
							 .pagetions 
							<div class="col-md-12 text-center">
								<ul class="pagination">
                                                                    <li class="active"><a href="#"> <?php echo $create_links; ?></a></li>
                                                                   
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">&raquo;</a></li>
                                                                        
								</ul>
							</div>
							 /.pagetions 							
						</div>
					</div>-->

				</div>
			</div>
		</div>
		<!-- /.grid-shop -->
	</section>
	<!-- newsletter -->