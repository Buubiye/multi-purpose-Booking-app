<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       Ahmed-Buubiye
 * @since      1.0.0
 *
 * @package    Booking_Plugin
 * @subpackage Booking_Plugin/admin/partials
 */
 
 echo '<h1> Dashboard </h1>';
 
 // get all orders
 
 global $wpdb;
 $get_all_orders = $wpdb->get_results('SELECT * FROM wp_mpbp_orders');
 echo 'The Total Number of Orders are '. sizeof($get_all_orders) . ' Orders.';
 
 // get the average stars for all services 
 
 $get_all_ratings = $wpdb->get_results('SELECT sum(rating) AS totalsum FROM wp_mpbp_orders');
 foreach($get_all_ratings as $result){
	 $get_avarage_ratings = $result->totalsum / sizeof($get_all_orders);
	 echo '<br> The average rating number is '. $get_avarage_ratings;
 }
 
 // get the money earned 
 
 $get_amount = $wpdb->get_results('SELECT SUM(price) AS totalprice FROM wp_mpbp_orders');
 
 foreach($get_amount as $result){
	 echo '<br> The total money earned is '. $result->totalprice;
 }
 
 // get orders data by date
 $mpbp_date = date('d-m-Y', strtotime($search_ending_date. ' - 7 Days'));
 $get_data_by_date = array();
 $mpbp_store_dates = array();
 
 // Stores the wpdb query variable for data extraction
 $mpbp_query_data = array();
 
 // 
 $mpbp_this_day = date('d-m-Y');
 $mpbp_this_month = date('m-Y');
 /*
 * Variables for Monthly, daily and yearly formats
 *
 * $date_format // stores the date format which is extracted
 * $date_displayed // stores the date which will be used to match the labels
 * $search_date_format // stores the date format for the searched date
 * $search_starting_date // stores the starting date which searched
 * $search_ending_date // stores the ending date which is searched 
 */
 if($_POST['mpbp_date_range'] == 'Daily' || $_POST['mpbp_date_range'] == 'Select Filter' | !isset($_POST['mpbp_date_range'])){
	 $mpbp_query_data = array(
	   'date_format' => 'date, "%d"',
	   'date_displayed' => 'date, "%Y-%m-%d"',
	   'search_date_format' => 'tbl.date, "%d-%m-%Y"',
	   'search_ending_date' => date('d-m-Y'),
	   'search_starting_date' => date('d-m-Y', strtotime($mpbp_this_day. ' - 7 Days')),
	   'group_by' => "DAY"
	  );
 }else if($_POST['mpbp_date_range'] == 'Monthly'){
	 echo "<h1>here we are</h1>";
	 $mpbp_query_data = array(
	   'date_format' => 'date, "%m"',
	   'date_displayed' => 'date, "%Y-%m"',
	   'search_date_format' => 'tbl.date, "%m-%Y"',
	   'search_ending_date' => date('m-Y'),
	   'search_starting_date' => date('m-Y', strtotime($mpbp_this_month. ' - 7 Months')),
	   'group_by' => "MONTH"
	 );
 }
 print_r($mpbp_query_data);
  // stores the values for each date to be later displayed on the graphs
 $get_data = $wpdb->get_results('SELECT COUNT(DATE_FORMAT('. $mpbp_query_data["date_format"] .')) AS countOrders,
							DATE_FORMAT('. $mpbp_query_data["date_displayed"] .') AS getDate FROM wp_mpbp_orders tbl
							WHERE DATE_FORMAT('. $mpbp_query_data["search_date_format"] .') BETWEEN "'. $mpbp_query_data["search_starting_date"] .'" 
							AND "'. $mpbp_query_data["search_ending_date"] .'" GROUP BY '. $mpbp_query_data["group_by"] .'(date)');
  
  echo '<h1> hello </h1>';  
  print_r($get_data);	
  // convert $get_data stdclass object to array
  $get_data_converted = json_decode(json_encode($get_data), true);
  echo '<h1>';
  print_r($get_data_converted);
  echo '</h1>';
 
 //search array funcction
 function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['getDate'] === $id) {
           return $key;
       }
   }
   return null;
}
 for($i=0; $i<7; $i++){
	 
// increments the $mpbp_date date with a given number , 1 is minimum
if($_POST['mpbp_date_range'] == 'Daily' | $_POST['mpbp_date_range'] == 'Select Filter' | $_POST['mpbp_date_range'] == ''){
	$mpbp_date = date('Y-m-d', strtotime($mpbp_date. ' + 1 Days'));
}else if($_POST['mpbp_date_range'] == 'Monthly'){
	$mpbp_date = date('Y-m', strtotime($mpbp_date. ' - 1 Months'));
}


     // get the current date
	 // search for a matching nested array with the same getDate value
	 
	 
  $mpbp_get_index = searchForId($mpbp_date, $get_data_converted);
 if( $mpbp_get_index != 0){
	 $get_data_by_date[$i] = $get_data[$mpbp_get_index]->countOrders;
 }else{
	 $get_data_by_date[$i] = 0;	
 };
 
 
 // stores the labels 
 $custom_label = $mpbp_date;
 //$mpbp_date_custom = date('d-M', strtotime($custom_label. ' + 1 days'));
 // stores dates extracted to be later diplayed on the charts
	 $mpbp_store_dates[$i] = $custom_label;
}

// exmaple query ##### should be deleted later
/*$lklk = $wpdb->get_results('SELECT COUNT(DATE_FORMAT(date, "%d")) AS getCount, DATE_FORMAT(date, "%d-%b") AS getDate FROM wp_mpbp_orders tbl
							WHERE DATE_FORMAT(tbl.date, "%d-%m-%Y") BETWEEN "03-04-2021" AND "10-04-2021"
                            GROUP BY DAY(date)');
print_r($lklk);
echo '<br><br><br>';
echo JSON_encode($lklk);*/
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
<form method="POST">
    <select name="mpbp_date_range">
	   <option> <?php echo (isset($_POST['mpbp_date_range']))?  $_POST['mpbp_date_range'] : 'Select Filter'; ?> </option>
	   <option>Daily</option>
	   <option>Monthly</option>
	   <option>Yearly</option>
	</select>
	<button type="submit">Filter</button>
</form>
<div>
	<div class="mpbp_dashboard_column">
		<canvas id="barChart" width="400" height="400"></canvas>
	</div>
 </div>
<script>
var ctx = document.getElementById("barChart");
var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo JSON_encode($mpbp_store_dates); ?>,
        datasets: [{
			      backgroundColor: '#19a0ef',
            label: '# of orders',
            data: <?php echo JSON_encode($get_data_by_date); ?>
            }]
		}
});

function addData(chart, label, color, data) {
		chart.data.datasets.push({
	    label: label,
      backgroundColor: color,
      data: data
    });
    chart.update();
}

// inserting the new dataset after 3 seconds
setTimeout(function() {
	//addData(barChart, '# of Votes 2017', '#ff0000', [16, 14, 8]);
}, 3000);
</script>
