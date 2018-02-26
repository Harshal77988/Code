<table class="table table-striped table-bordered" id="">
  <thead>
    <tr>
      <th>State</th>
      <th>Zipcode</th>
      <th>Region Name</th>
      <th>State Rate</th>
      <th>Country Rate</th>
      <th>City Rate</th>
      <th>Special Rate</th>
      <th>Combined Rate</th>
      <th>Action</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>State</th>
      <th>Zipcode</th>
      <th>Region Name</th>
      <th>State Rate</th>
      <th>Country Rate</th>
      <th>City Rate</th>
      <th>Special Rate</th>
      <th>Combined Rate</th>
      <th>Action</th>
    </tr>
  </tfoot>
  <tbody>
    <?php if (isset($all_tax_data) && !empty($all_tax_data)) {?>
    <?php foreach ($all_tax_data as $sid => $odata) { ?>
    <tr>
      <td>
        <?=$odata['state'] ?>
      </td>
      <td>
        <?=$odata['zip_code']?>
      </td>
      <td>
        <?=$odata['region_name'] ?>
      </td>
      <td>
        <?=$odata['state_rate'] ?>
      </td>
      <td>
        <?=$odata['country_rate']?>
      </td>
      <td>
        <?=$odata['city_rate'] ?>
      </td>
      <td>
        <?=$odata['special_rate'] ?>
      </td>
      <td>
        <?=$odata['combined_rate']?>
      </td>
      <td>
          <button type="button" class="btn btn-default btn-xs btn-success-outline rippler" data-toggle="modal" data-target=".id_tax_edit_<?php echo $odata['id']; ?>"><i class="fa fa-pencil"></i></button>
          <button class="btn btn-default btn-xs btn-danger-outline rippler" onclick="deleteTax(<?php echo $odata['id']; ?>)"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
    <?php }
} ?>
  </tbody>
</table>
<div class="pull-right">
    <?php echo $this->ajax_pagination_product->create_links(); ?>
</div>