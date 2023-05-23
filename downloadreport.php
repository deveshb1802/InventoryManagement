<?php
$page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-8">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" name="myform" method="post" action="">
            <div class="form-group">
              <label class="form-label">Date Range</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="From">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="To">
                </div>
            </div>
            <div class="form-group">
            <div class="row">
              <div class="col-md-12"></div>
                <div class="col-md-6">
                  <button type="submit" name="submit" class="btn btn-success"  style="border: none;color: white;padding: 12px 30px;   cursor: pointer;font-size: 15px;width:100% ;" onclick="exportf();return true;"><i class="fa fa-download"></i>Download Excel File</button>
                </div>
                <div class="col-md-6">
                  <button type="submit" name="submit" class="btn btn-danger" style="border: none;color: white;padding: 12px 30px;   cursor: pointer;font-size: 15px;width:100% ;"onclick="download();return true;"><i class="fa fa-download" ></i> Download PDF File</button>
                </div>
            </div>

            </div>
          </form>
      </div>

    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
<script type="text/javascript">
  function exportf()
  {
    console.log("Export f");
   document.myform.action='export.php';
  }
  function download()
  {
    console.log("Download P");
     document.myform.action='downloadpdf.php';
  }
</script>