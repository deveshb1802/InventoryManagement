</div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="libs/js/functions.js"></script>
  <?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
?>
<?php
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $products_sold   = find_higest_saleing_product('10');
?>
<?php include_once('layouts/header.php'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Name', 'Total Quantity'],
            <?php
            foreach ($products_sold as  $product_sold)
            {
              echo"['".(remove_junk(first_character($product_sold['name'])))."',".(int)$product_sold['totalQty']."],";
            }
            ?>
           
          
        ]);

        var options = {
          title: '',
          width:400,
          height:400,
          legend:'top',
          is3D:true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>