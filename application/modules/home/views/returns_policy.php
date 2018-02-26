<section class="shopping-cart">
            <!-- .shopping-cart -->
            <div class="container terms">
				<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Returns Policy</li>
					</ol>
				</div>
				
                                   
                               
                <!-- Start Tabs -->
                <div class="container">
			    <div class="row">
			    


			        <div class="col-md-12">

			            <?php
                                     $policy= explode('-content-', $post_info[0]['content']);
                                  echo  (!empty($policy[1]) ? $policy[1] : '') 
                                     ?>
			        </div>

			    </div>
			</div>
                <!-- End Tabs -->
                                    
				</div>
               
            </div>
            <!-- /.shopping-cart -->
         </section>