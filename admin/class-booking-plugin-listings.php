<?php

/*
* variables needed to be added
* 1. Database table - $mpbp_db_table
* 2. number of rows to be displayed per page - $mpbp_services_results_per_page
* 3. page title - $mpbp_listing_title
* 4. header button name update/add_new - $mpbp_listing_button;
* 5. header button [add_new] url - $mpbp_listing_button_url;
* 6. page name - $mpbp_items
* 7. page name for get request e.g. $_GET['all_services'] - $mpbp_page_name;
* 8. short url when user click next or previous e.g. '/wp-admin/admin.php?page=all_services&order=' - $mpbp_listing_url;
* 9. Table header <th> name array - $mpbp_listing_th;
* 10. Table header <th> data array - $mpbp_listing_th_data;
* 10. Table data <td> array() - $mpbp_listing_td;
*/
class mpbp_data_listing{
  public $mpbp_db_table;
  public $mpbp_services_results_per_page;
  public $mpbp_listing_title;
  public $mpbp_listing_button;
  public $mpbp_listing_button_url;
  public $mpbp_items;
  public $mpbp_page_name;
  public $mpbp_listing_url;
  public $mpbp_listing_td;
  public $mpbp_listing_td_data;
  public $mpbp_search_columns;
  public $mpbp_user_data;
  /*
  *
  */
  public $mpbp_listing_th;
  public $mpbp_listing_th_data;
  
  public function mpbp_render_listing(){
  for($i = 1; $i < sizeof($this->mpbp_listing_th); $i++){
	  $this->mpbp_listing_th_data[$i] = '<th scope="col" id="mpbp_'. $this->mpbp_listing_th[$i] .'" class="manage-column column-'. $this->mpbp_listing_th[$i] .' sortable"><p>'. $this->mpbp_listing_th[$i] .'</p></span></th>';
  }
  /*
  * This file displays the services in a list of 10 per laod
  *
  */
  
  echo $this->mpbp_listing_title;
  /*
  * connect to database
  */
  global $wpdb;
  
  /*
  * define how many results you want per page
  */
  $this->mpbp_services_results_per_page = 5;
  
  /*
  * find out the number of results stored in database
  */
  $mpbp_all_services;
  if(empty($_GET['search'])){
	  $mpbp_all_services = $wpdb->get_results("SELECT id FROM ". $this->mpbp_db_table);
  }elseif(!empty($_GET['search'])){
	  $mpbp_all_services = $wpdb->get_results("SELECT * FROM ". $this->mpbp_db_table ." WHERE '". $_GET['search'] ."' IN (". implode(',', $this->mpbp_search_columns) .")");
  }
  $mpbp_services_size = sizeof($mpbp_all_services);
  
  /* 
  *determine number of total pages available
  */
  $mpbp_services_number_of_pages = ceil($mpbp_services_size / $this->mpbp_services_results_per_page);
  
  /*
  *determine which page number visitor is currently on
  */
  $mpbp_current_service_page;
  if(!isset($_GET['order'])){
	$mpbp_current_service_page = 1;
  }else{
	 $mpbp_current_service_page =  $_GET['order']; 
  }
  
  /*
  * determine the sql starting number for the results on the displaying page
  */
  $mpbp_this_page_first_result = ($mpbp_current_service_page - 1)*$this->mpbp_services_results_per_page;
  
  /*
  * retrieves selected results from databse and display the on page
  */
  $mpbp_services_query_this_page;
  if(empty($_GET['search'])){
	  $mpbp_services_query_this_page = $wpdb->get_results("SELECT * FROM ". $this->mpbp_db_table ." LIMIT ". $mpbp_this_page_first_result ."," . $this->mpbp_services_results_per_page);
  }elseif(!empty($_GET['search'])){
	 $mpbp_services_query_this_page = $wpdb->get_results("SELECT * FROM ". $this->mpbp_db_table ." WHERE '". $_GET['search'] ."' IN (". implode(',', $this->mpbp_search_columns) .")");
  }
  /*
  * retrieves selected results from databse and displays them on page
  */
  for($row = 0; $row<sizeof($mpbp_services_query_this_page); $row++){
	  //echo $mpbp_services_query_this_page[$row]->id . ' : ' . $mpbp_services_query_this_page[$row]->name . '<br>';
  }
  
  /*
  * display the links to the pages
  */
  $mpbp_next_service_page = $mpbp_current_service_page + 1;
  $mpbp_previous_service_page = $mpbp_current_service_page - 1;
  
  /*
  * limit how many times the user can click next
  * disable "next" link if the user is on the last page 
  * disbale "previous" link if the user is on the first page
  * echo prevous and next links
  */
  $mpbp_services_page_next_limit;
  $mpbp_services_page_previous_limit;
  ($mpbp_current_service_page>=$mpbp_services_number_of_pages)? $mpbp_services_page_next_limit = "mpbp_disabled" : '';
  ($mpbp_current_service_page<=1)? $mpbp_services_page_previous_limit = "mpbp_disabled" : '';
  ?>
  <a href="<?php echo get_site_url(). $mpbp_listing_button_url . 'action=add_new';?>" class="page-title-action">
  <?php echo $this->mpbp_listing_button; ?></a>
  <form id="mpbp_services_list_form" method="GET">

    <p class="">
        <label class="" for="">Raadi Bogag:</label>
        <input type="search" id="" name="search" value="">
        <input type="submit" id="" class="button" value="Raadi Bogag">
    </p>

    <div class="tablenav top">
        <h2 class="screen-reader-text">Pages list navigation</h2>
        <div class="tablenav-pages"><span class="displaying-num"><?php echo $mpbp_services_size . " " . $this->mpbp_items;?></span>
		        <input name="page" value="<?php echo $this->mpbp_page_name; ?>"/>
                <a  class="prev-page <?php echo $mpbp_services_page_previous_limit . '" href="'. get_site_url(). $this->mpbp_listing_url . $mpbp_previous_service_page;?>"><span class="screen-reader-text">Boggii hore</span><span aria-hidden="true">‹</span></a>
                <span class="paging-input"><label class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="order" value="<?php echo $mpbp_current_service_page;?>" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of 
				<span class="total-pages"><?php echo $mpbp_services_number_of_pages;?></span></span></span>
                <a class="next-page <?php echo $mpbp_services_page_next_limit;?>" href="<?php echo get_site_url(). $this->mpbp_listing_url . $mpbp_next_service_page;?>"><span class="screen-reader-text">Bogga xiga</span><span aria-hidden="true">›</span></a>
        </div>
        <br class="clear">
    </div>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <tr>
                <?php
				  echo implode($this->mpbp_listing_th_data);
				?>
            </tr>
        </thead>

        <tbody id="the-list">
		<?php      
		for($row=0; $row<$this->mpbp_services_results_per_page; $row++){
			if($mpbp_services_query_this_page[$row] != ''){
			?>
            <tr id="post-3" class="iedit author-self level-0 post-3 type-page status-draft hentry entry">
			<th scope="row" class="check-column"> <label class="screen-reader-text" for="cb-select-3">Select Privacy Policy</label>
                <input id="cb-select-3" type="checkbox" name="post[]" value="3">
            </th>
			 <?php
			 /*
			 * print out the <td> for the list
			 */
			 for($td_data = 0; $td_data<sizeof($this->mpbp_listing_td); $td_data++){
				   $td = $this->mpbp_listing_td[$td_data];
				   
				   if($td == $this->mpbp_listing_td[1]){
						$this->mpbp_listing_td_data[$td_data] =  '<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                <strong>
						<a class="row-title" href="<?php echo get_site_url() ?>/wp-admin/post.php?post=3&amp;action=edit" aria-label="“Privacy Policy” (Edit)">
						'. $mpbp_services_query_this_page[$row]->$td .'</a> 
					</strong>
					
                    <div class="row-actions"><span class="edit">
						<a href="'.  get_site_url(). $this->mpbp_listing_button_url ."action=edit&id=". $mpbp_services_query_this_page[$row]->id .'" 
						aria-label="Edit “Privacy Policy”">Tifaftir</a> | </span>
						<span class="trash"><a href="'. get_site_url() . $this->mpbp_listing_button_url .'action=delete&id='. 
					 $mpbp_services_query_this_page[$row]->id .'" class="submitdelete" aria-label="Move “Privacy Policy” to the Bin">Trash</a> | </span>
					<span class="view">
					<a href="http://localhost:8080/wordpress/?page_id=3&amp;preview=true" rel="bookmark" aria-label="Preview “Privacy Policy”">Horu’eeg</a>
					</span></div>
                </td>';
				}elseif($td == $this->mpbp_listing_td[0]){
					preg_match("/(http(.*?)(?=\,))/", $mpbp_services_query_this_page[$row]->$td, $mpbp_s_first_image);
				     $this->mpbp_listing_td_data[$td_data] =  '<td class="author column-author" data-colname="Qoraa"><a>
				     <img src="'. $mpbp_s_first_image[0] .'" height="50"/></a></td>';
				 }else{
					$this->mpbp_listing_td_data[$td_data] =  '
					  <td class="date mpbp-column-status" data-colname="status">'. $mpbp_services_query_this_page[$row]->$td .'</td>
					 ';
				 }
			    }
			    echo implode($this->mpbp_listing_td_data);
			  ?>
			</tr>
			<?php
			}
			} ?>
        </tbody>

        <tfoot>
            <tr>
                <?php
				  echo implode($this->mpbp_listing_th_data);
				?>
            </tr>
        </tfoot>

    </table>
</form>
  <?php
  }
}

?>