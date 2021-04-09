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
 $mpbp_date = '13-12-2020';
 $get_data_by_date = array();
 $mpbp_store_dates = array();
 for($i=0; $i<10; $i++){
// increments the $mpbp_date date with a given number , 1 is minimum
 $mpbp_date = date('d-m-Y', strtotime($mpbp_date. ' + 1 days'));
 // stores the values for each date to be later displayed on the graphs
 $get_data = $wpdb->get_results('SELECT COUNT(id) AS countOrders FROM wp_mpbp_orders WHERE date = "'. $mpbp_date . '"');
 foreach($get_data as $results){
	 $get_data_by_date[$i] = $results->countOrders;
 }
 // stores dates extracted to be later diplayed on the charts
 $mpbp_store_dates[$i] = $mpbp_date;
}

print_r($get_data_by_date);
echo '<br><br>';
print_r($mpbp_store_dates);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.2/chart.min.js"></script>
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
        labels: ["Dog", "Cat", "Pangolin"],
        datasets: [{
			      backgroundColor: '#00ff00',
            label: '# of Votes 2016',
            data: [12, 19, 3]
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
	addData(barChart, '# of Votes 2017', '#ff0000', [16, 14, 8]);
}, 3000);
</script>
