<?php 
require_once('includes/load.php');
require('vendor/autoload.php');

  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $results      = find_sale_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('downloadreport.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('downloadreport.php', false);
  }

  if(mysqli_num_rows($results)>0)
  {
    $html='<style>.table{}</style><table class="table">';
    $html.='<tr><td>Date</td><td>Product Title</td><td>Production Price</td><td>Selling Price</td><td>Total Qty</td><td>TOTAL<td></tr>';
    while($row=mysqli_fetch_assoc($results))
    {
       $html.='<tr><td>'.$row['date'].'</td><td>'.$row['name'].'</td><td>'.$row['buy_price'].'</td><td>'.$row['sale_price'].'</td><td>'.$row['total_sales'].'</td><td>'.$row['total_saleing_price'].'<td></tr>';
    }
    $total_price=number_format(total_price($results)[0], 2);
        $profit= number_format(total_price($results)[1], 2);
    $html.='<tr><td></td><td></td><td></td><td></td><td>Total</td><td>'.$total_price.'<td></td></tr>'.'<tr><td></td><td></td><td></td><td></td><td>Profit</td><td>'.$profit.'<td></td></tr>';
    $html.='</table>';
  }
  else
  {
    $html="Data Not found";
  }

  $mpdf=new \Mpdf\Mpdf();
  $mpdf->writeHTML($html);
  $file="Sales_report_" . date('Y-m-d') .'.pdf';
  $mpdf->output($file,'D');

?>