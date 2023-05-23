
<?php 
require_once('includes/load.php');


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
 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
 
$fileName = "Sales_report_" . date('Y-m-d') . ".xls"; 
 
 
$fields = array('Date',  'Product Title', 'Production Price($)','Selling Price($)', 'Total Qty', 'TOTAL($)'); 
 

  global $db;

  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";

$query = $db->query($sql); 

if($query->num_rows > 0){ 
    $Heading = array("\t Inventory Report - '{$start_date}' to '{$end_date}'");
    $excelData = implode("\t", $Heading ) . "\n\n";
    $excelData .= implode("\t", array_values($fields)) . "\n";

    while($row = $query->fetch_assoc()){ 
        $lineData = array( $row['date'], $row['name'], $row['buy_price'], $row['sale_price'], $row['total_sales'], $row['total_saleing_price']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
    $total_price = array("\n \t \t \tGrand Total",number_format(total_price($query)[0], 2));
    $excelData .= implode("\t \t $", array_values($total_price) ) . "\n";
    $profit = array("\t \t \tProfit",number_format(total_price($results)[1], 2));
    
    $excelData .= implode("\t \t $", array_values($profit) ) . "\n";
}else{ 
    $excelData .= 'No records found...'. "\n"; 

} 
 
 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
 
echo $excelData; 
 
exit;
?>