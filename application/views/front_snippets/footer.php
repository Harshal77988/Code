<div class="container">
    <div class="row">
        <?php if(!empty($footer_content)) {
            if(!empty($footer_content[0]['column_content_1'])) {?>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?=$footer_content[0]['column_content_1']?>
        </div>
        <?php } ?>
        <?php if(!empty($footer_content[0]['column_content_2']) || !empty($footer_content[0]['column_content_3'])) {?>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?=(!empty($footer_content[0]['column_content_2']) ? $footer_content[0]['column_content_2'] : '')?>
            <?=(!empty($footer_content[0]['column_content_3']) ? $footer_content[0]['column_content_3'] : '')?>
        </div>
        <?php } ?>
        <?php if(!empty($footer_content[0]['column_content_4'])) {?>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?=(!empty($footer_content[0]['column_content_4']) ? $footer_content[0]['column_content_4'] : '')?>
        </div>
        <?php } } ?>
        <!-- copayright -->
        <div class="copayright">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    Copyright <?=date('Y')?> © <a href="#">BuySellRent</a> all rights reserved. Designed by <a href="http://rebelute.com">Rebelute</a>
                </div>
                <div class="text-right col-xs-12 col-sm-6 col-md-6">
                    <img src="<?= base_url() ?>frontend/assets/images/payment-img.jpg" alt="payment-img" />
                </div>
            </div>
        </div>
        <!-- /copayright -->

    </div>
</div>