<!-- newsletter -->
<section class="grid-shop blog">
	<!-- .grid-shop -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
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
							<?php if(count($cat_data) > 0) {
								foreach($cat_data as $key => $data) {?>
							<li><a href="<?php echo base_url(); ?>blog-category-details/<?php echo $data['category_id']; ?>"><?php echo $data['category_name'];?></a></li>
							<?php }} ?>
						</ul>
					</div>
				</div>

				<!-- <div class="weight">
					<div class="title">
						<h2>RECENT POST</h2>
					</div>
					<div class="recent-box">
						<ul>
							<li>
								<div class="e-product">
									<div class="pro-img"> <img src="<?=base_url();?>frontend/assets/images/rp-img1.jpg" alt="2"> </div>
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
									<div class="pro-img"> <img src="<?=base_url();?>frontend/assets/images/rp-img2.jpg" alt="2"> </div>
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
									<div class="pro-img"> <img src="<?=base_url();?>frontend/assets/images/rp-img3.jpg" alt="2"> </div>
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
									<div class="pro-img"> <img src="<?=base_url();?>frontend/assets/images/rp-img4.jpg" alt="2"> </div>
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
				</div> -->
				<div class="weight">
					<div class="title">
						<h2>ARCHIVES</h2>
					</div>
					<div class="archives-box">
						<ul>
							<?php if(!empty($blog_archieve_months)) {
							foreach ($blog_archieve_months as $key => $m_list) {?>
							<li><a onclick="getArchievePost(<?=$m_list['post_id']?>)"><?=$m_list['created_month']?></a></li>
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
							<li><a href="#">Electronic</a></li>
							<li><a href="#">Camera</a></li>
							<li><a href="#">Phone</a></li>
							<li><a href="#">Laptop</a></li>
							<li><a href="#">Home</a></li>
							<li><a href="#">Garden</a></li>
							<li><a href="#">Complex</a></li>
							<li><a href="#">Apple</a></li>
							<li><a href="#">Decor</a></li>
							<li><a href="#">Kid’s</a></li>
							<li><a href="#">Men’s</a></li>
							<li><a href="#">Gift</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="container">
           		<div class="col-sm-9 col-md-9 blog-deatails">
           			<?php if(!empty($blog)) {?>
           			<?=form_input(array('type' => 'hidden', 'name' => 'post_id', 'id' => 'post_id', 'value' => $blog[0]['post_id']))?>
					<h6><?php if(!empty($blog[0]['blog_image'])) {?><img src="<?=base_url()?>backend/uploads/blogs/870x545/<?=$blog[0]['blog_image']; ?>" alt="Grid-banner" /><?php } ?></h6>
					<p class="hank"><a href="javascript:void(0)"><?=$blog[0]['post_title']; ?></a></p>
					<p class="time"><span class="date"><?=date('D j M, Y ', strtotime($blog[0]['posted_on'])); ?></span> by <span><?=$blog[0]['first_name'].' '.$blog[0]['last_name'];?></span> 
					<!--in <span>Fashion for men’s</span>-->
					</p>
					<p><?=(!empty($blog[0]['post_content']) ? $blog[0]['post_content']:'');?></p>
					<!-- .comments-area -->
					<div class="comments-area">
						<div class="comment-respond comment-replay">
							<?php if(!empty($blog[0]['blog_comments'])) {
								foreach ($blog[0]['blog_comments'] as $k => $comment_list) {?>
							<div class="col-md-12 bdr3">
								<p class="time">by <span><?=$comment_list['commented_by']?></span> in <span class="date"><?=date("D d M Y H:i A", strtotime($comment_list['comment_on']));?></span></p>
								<p><?=$comment_list['comment']?></p>
							</div>
							<?php } }?>
						</div>
					</div>
					<!-- .comments form -->
					<div id="comments" class="comments-area">
						<div id="respond" class="comment-respond">
							<h2><span>Leave a comment</span></h2>
							<!--<p>Submit Comment</p>-->
							<form method="post" id="blogcommentform" class="comment-form">
								<p>Name <span>*</span></p>
								<p class="comment-form-author">
									<?=form_input(array('id' => 'blog_author', 'name' => 'blog_author', 'size' => '30', 'placeholder' => 'Enter the name'))?>
								</p>
								<p>Email <span>*</span></p>
								<p class="comment-form-email">
									<?=form_input(array('id' => 'blog_email', 'name' => 'blog_email', 'size' => '30', 'placeholder' => 'Enter the email'))?>
								</p>
								<p>Comments <span>*</span></p>
								<p class="comment-form-comment">
									<?=form_textarea(array('id' => 'blog_comment', 'name' => 'blog_comment', 'maxlength' => '160', 'cols' => '45', 'rows' => '8', 'placeholder' => 'Comment', 'aria-required' => 'true'))?>
								</p>
								<p class="form-submit loader_blog">
									<?=form_button(array('type' => 'submit', 'id' => 'blog_submit', 'class' => 'btn btn-secondary', 'content' => 'Post Comment', 'name' => 'blog_comment'))?>
								</p>
							</form>
							<div class="col-md-12" id="blog_message"></div>
						</div>
					</div>
					<?php } else { ?>
					<center>
						Sorry ! This blog may be removed or unpublished by Administrator.
					</center>
					<?php } ?>
				</div>
				<!-- /.blog -->
            </div>
		</div>
	</div>
	<!-- /.grid-shop -->
</section>
<!-- newsletter -->