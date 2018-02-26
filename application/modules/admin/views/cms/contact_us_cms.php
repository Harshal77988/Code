<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>"><i class="fa fa-home"></i>Home</a></li>
        <li class="active">Manage Contact Us CMS</li>
    </ol>
</div><br>
<!-- /.breadcrumb-wrapper -->
<!-- /.page-titile-wrapper -->
<?= form_open_multipart('admin/contact_cms', array('class' => "form-horizontal m-bottom-30 footer_cms_form", 'id' => "contact_cms")) ?>
<?= form_hidden(array('cms_id' => (!empty($post_info[0]['id']) ? $post_info[0]['id'] : ''))) ?>


<div class="container">
   

    <div class="row" style="margin-left: 5%">
            <div class="col-md-6 col-sm-6 col-xs-6">

                <?php
//            print_r($post_info);
                  $map = explode('-map-', $post_info[0]['map']);
                $mail = explode('-email-', $post_info[0]['email']);
                $phone = explode('-phone-', $post_info[0]['phone']);
                $times = explode('-settime-', $post_info[0]['time_hours']);
                ?>

                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="heading" class="control-label ">Heading</label>
                        <input type="text" class="form-control" required="required" id="heading" name="heading" value="<?= (!empty($post_info[0]['heading']) ? $post_info[0]['heading'] : '') ?>" >
                    </div>
                </div>


                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="content" class="control-label"> Content</label>
                        <textarea class=" form-control" required="required" id="content" name="content" ><?= (!empty($post_info[0]['content']) ? $post_info[0]['content'] : '') ?></textarea>
                    </div>
                </div>
                <!-- column 2 title and content end -->


                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="addr" class="control-label">Office Address</label>
                        <textarea class=" form-control" required="required" id="addr" name="addr" ><?= (!empty($post_info[0]['address']) ? $post_info[0]['address'] : '') ?></textarea>
                    </div>
                </div>
                <div class=" form-group col-md-12">
                     <div class="form-group ">
                                        <label for="lati" class="control-label">latitude : </label>
                                       
                                            <input type="text" id="map" name="lati" class="form-control" value="<?php echo (!empty($post_info[0]['map']) && (!empty($map)) ? $map[0] : '') ?>">
                                       
                     </div>

                                    <div class=" form-group">
                                        <label for="longi" class="control-label">Longitude : </label>
                                      
                                            <input type="text" id="map" name="longi" class="form-control" value="<?php echo (!empty($post_info[0]['map']) && (!empty($map)) ? $map[1] : '') ?> ">
                                        
                                    </div>


<!--                <div class="form-group col-md-12">
                    <div class="">
                        <label for="map" class="control-label">Map</label>
                        <textarea class="form-control" required="required" id="map" name="map"  > <?= (!empty($post_info[0]['map']) ? $post_info[0]['map'] : '') ?></textarea>
                    </div>
                </div>-->
                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label  for="mail1" class="control-label">Email Address</label>
                        <input type="email"   class=" form-control" required="required" id="mail1" name="mail1"  value="<?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[0] : '') ?>">

                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label  for="mail2" class="control-label">Support Email Address</label>

                        <input type="email"  class=" form-control" required="required" id="mail2" name="mail2" value="<?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[1] : '') ?>">

                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone Number</label>
                        <input type="text" class=" form-control" required="required" id="phone" name="phone" value="<?= (!empty($post_info[0]['phone']) && (!empty($phone)) ? $phone[0] : '') ?>">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <div class="form-group">
                        <label for="fax" class="control-label">Fax</label>
                        <input type="text" class=" form-control" required="required" id="fax" name="fax" value="<?= (!empty($post_info[0]['phone']) && (!empty($phone)) ? $phone[1] : '') ?>" >
                    </div>
                </div>
                <br>
   <h4>Time Hours</h4>
                <div class=" form-group col-md-12">
                 
                    <div class="form-group ">
                        <label for="text1" class="control-label"></label>
                        <input type="text" class=" form-control" required="required" id="text1" name="text1"  placeholder="(ex: Monday to Friday:) " value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[0] : '') ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class=" form-control start" required="required" id="startdate1" name="startdate1"  value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[1] : '') ?>">

                    </div>
                    <div class="form-group">
                        <input type="text" class=" form-control" required="required" id="text2" name="text2"  placeholder="(ex: Saturday:) " value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[2] : '') ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class=" form-control start" required="required" id="startdate2" name="startdate2" value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[3] : '') ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class=" form-control" required="required" id="text3" name="text3"  placeholder="(ex: Sunday: )"value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[4] : '') ?>" >
                    </div>  
                    <div class="form-group">
                        <input type="text" class=" form-control start" required="required"  id="startdate3" name="startdate3" value="<?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[5] : '') ?>">
                    </div>

                </div>


                <hr><br>
                <div class="form-group">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" name="contact_cms" id="contact_cms" value="Update">
                        <a href="<?= base_url() ?>admin/manage_cms"><button type="button" class="btn btn-danger rippler">Cancel</button></a>

                    </div>
                </div>
            </div>
        </div>
  </div>
<?= form_close() ?>
