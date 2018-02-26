<div class="breadcrumb-wrapper">
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-home"></i>Home</a></li>
    <li class="active">Manage Taxes</li>
  </ol>
</div>
<!-- /.breadcrumb-wrapper -->
<div class="page-title-wrapper">
  <div class="panel-title">
      <div class="panel-tools">
        <h2 class="page-title">Manage Taxes</h2>
        <!-- <a style="margin-right: 10px;" href="<?=base_url('admin/import_products')?>" type="button" class="btn btn-success pull-right rippler">Add Tax</a>  -->
        <a style="margin-right: 10px;" onclick="clearTaxesData()" type="button" class="btn btn-success pull-right rippler">Clear Data</a>
        <a style="margin-right: 10px;" href="<?=base_url('admin/exportTaxesCSV')?>" type="button" class="btn btn-success pull-right rippler">Export All Records</a>
        <div class="tools-content"></div>
      </div><!-- /.panel-tools -->
    </div><!-- /.panel-title -->
</div>
<!-- <form action="http://ittires.dev.rebelutedigital.com/admin/manage_tax/addcsv" method="post" enctype="multipart/form-data" name="form1" id="form1">  -->
<?=form_open_multipart('admin/importTaxesCSV', array())?>
    <div class="form-group">
        <label for="product_csv" class="control-label col-md-3 col-sm-3 col-xs-12">Select CSV*</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <table>
                <tbody>
                  <tr>
                    <th>Upload tax rates using CSV</th>
                  </tr>
                  <tr>
                      <td>
                          <!-- <input type="file" class="form-control" name="userfile" id="userfile" align="center" required="" eq="">
                          <input type="file" name="import_taxes_file" id="browse_taxes" onchange="fileTaxesValidation()"> -->
                          <?=form_input(array('type' => 'file', 'class'=> "form-control", 'name' => "import_taxes_file", 'id' => "browse_taxes", 'onchange' => "fileTaxesValidation()"))?>
                          <p class="text-danger"> </p>
                      </td>
                      <td>
                          <div class="col-lg-offset-3 col-lg-9">
                              <!-- <button id="id_submit_tax" type="submit" name="submit" class="btn btn-info">Upload CSV File</button> -->
                              <?=form_submit(array('id' => "id_submit_tax", 'type' => "submit", 'name' => "submit", 'class' => "btn btn-info", 'value' => "Upload CSV File"))?>
                          </div>
                      </td>
                  </tr>
                </tbody>
            </table> 
        </div>
        <div class="clearfix"></div>
    </div>
<?=form_close()?>
<!-- /.page-titile-wrapper -->
<div class="row">
  <div class="col-sm-12">
      <table class="table table-striped table-bordered" id="table">
        <thead>
          <tr>
            <th>Sr no.</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Region Name</th>
            <th>State Rate</th>
            <th>Country Rate</th>
            <th>City Rate</th>
            <th>Special Rate</th>
            <th>Combined Rate</th>
            <!-- <th>Action</th> -->
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Sr no.</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Region Name</th>
            <th>State Rate</th>
            <th>Country Rate</th>
            <th>City Rate</th>
            <th>Special Rate</th>
            <th>Combined Rate</th>
            <!-- <th>Action</th> -->
          </tr>
        </tfoot>
        <tbody></tbody>
      </table>
  </div>
  <!-- /.col-sm-12 -->
</div>
<!-- /.row -->

<script src="<?php echo base_url('backend/assets/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('backend/assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<script type="text/javascript">
var table;

$(document).ready(function() {

    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };
    $.fn.dataTable.ext.errMode = 'throw';
    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    });

});

</script>