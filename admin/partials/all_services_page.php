<?php
  /*
  * This file displays the services in a list of 10 per laod
  *
  */
  
  function mpbp_display_services(){
  echo "<h1>This is Services List</h1>";
  /*
  * connect to database
  */
  global $wpdb;
  
  /*
  * define how many results you want per page
  */
  $mpbp_services_results_per_page = 5;
  
  /*
  * find out the number of results stored in database
  */
  $mpbp_all_services = $wpdb->get_results("SELECT id FROM wp_mpbpservices2");
  $mpbp_services_size = sizeof($mpbp_all_services);
  
  /* 
  *determine number of total pages available
  */
  $mpbp_services_number_of_pages = ceil($mpbp_services_size / $mpbp_services_results_per_page);
  
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
  $mpbp_this_page_first_result = ($mpbp_current_service_page - 1)*$mpbp_services_results_per_page;
  
  /*
  * retrieves selected results from databse and display the on page
  */
  $mpbp_services_query_this_page = $wpdb->get_results("SELECT * FROM wp_mpbpservices2 LIMIT ". $mpbp_this_page_first_result ."," . $mpbp_services_results_per_page);
 
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
  
  /*
  * extract the first image link for image display
  */
  /*echo $mpbp_services_query_this_page[$row]->pictures;
  $mpbp_s_first_image = preg_grep('/.(?<=\h)(.*?)(?=\,)/', $mpbp_services_query_this_page[$row]->pictures);
  print_r($mpbp_s_first_image);
  echo $mpbp_s_first_image[0];*/
  ?>
  <form id="mpbp_services_list_form" method="get">

    <p class="search-box">
        <label class="screen-reader-text" for="post-search-input">Raadi Bogag:</label>
        <input type="search" id="post-search-input" name="s" value="">
        <input type="submit" id="search-submit" class="button" value="Raadi Bogag">
    </p>

    <div class="tablenav top">
        <h2 class="screen-reader-text">Pages list navigation</h2>
        <div class="tablenav-pages"><span class="displaying-num"><?php echo $mpbp_services_size; ?> items</span>
                <a  class="prev-page <?php echo $mpbp_services_page_previous_limit;?>" href="<?php echo get_site_url(). '/wp-admin/admin.php?page=all_services&order='. $mpbp_previous_service_page;?>"><span class="screen-reader-text">Boggii hore</span><span aria-hidden="true">‹</span></a>
                <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $_GET['order'];?>" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of <span class="total-pages"><?php echo $mpbp_services_number_of_pages;?></span></span></span>
                <a class="next-page <?php echo $mpbp_services_page_next_limit;?>" href="<?php echo get_site_url(). '/wp-admin/admin.php?page=all_services&order='. $mpbp_next_service_page;?>"><span class="screen-reader-text">Bogga xiga</span><span aria-hidden="true">›</span></a>
        </div>
        <br class="clear">
    </div>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="mpbp_s_name" class="manage-column column-title column-primary sortable"><span>Name</span></th>
                <th scope="col" id="mpbp_s_pictures" class="manage-column column-author">Pictures</th>
                <th scope="col" id="mpbp_s_category" class="manage-column column-comments num sortable">Category<span></span></th>
                <th scope="col" id="mpbp_s_quantity" class="manage-column column-date sortable"><span>Quantity</span></th>
				<th scope="col" id="mpbp_s_status" class="manage-column column-date sortable"><span>Status</span></th>
            </tr>
        </thead>

        <tbody id="the-list">
		<?php      
		for($row=0; $row<5; $row++){
			?>
            <tr id="post-3" class="iedit author-self level-0 post-3 type-page status-draft hentry entry">
                <th scope="row" class="check-column"> <label class="screen-reader-text" for="cb-select-3">Select Privacy Policy</label>
                    <input id="cb-select-3" type="checkbox" name="post[]" value="3">
                </th>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                    <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                    <strong><a class="row-title" href="http://localhost:8080/wordpress/wp-admin/post.php?post=3&amp;action=edit" aria-label="“Privacy Policy” (Edit)"><?php echo $mpbp_services_query_this_page[$row]->name; ?></a> </strong>
					
                    <div class="row-actions"><span class="edit"><a href="<?php echo get_site_url(). '/wp-admin/admin.php?page=Services&action=edit&id='. $mpbp_services_query_this_page[$row]->id;?>" aria-label="Edit “Privacy Policy”">Tifaftir</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline" aria-label="Quick edit “Privacy Policy” inline">Quick&nbsp;Edit</a> | </span><span class="trash"><a href="http://localhost:8080/wordpress/wp-admin/post.php?post=3&amp;action=trash&amp;_wpnonce=8de0949d48" class="submitdelete" aria-label="Move “Privacy Policy” to the Bin">Trash</a> | </span><span class="view"><a href="http://localhost:8080/wordpress/?page_id=3&amp;preview=true" rel="bookmark" aria-label="Preview “Privacy Policy”">Horu’eeg</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td class="author column-author" data-colname="Qoraa"><a href="edit.php?post_type=page&amp;author=1"><img src="<?php preg_match('/(http(.*?)(?=\,))/', $mpbp_services_query_this_page[$row]->pictures, $mpbp_s_first_image); echo($mpbp_s_first_image[0]);?>" height="100" width="100"/></a></td>
                <td class="comments column-comments" data-colname="Faallooyin">
                    <div class="post-com-count-wrapper">
                        <span aria-hidden="true"><?php echo $mpbp_services_query_this_page[$row]->category; ?></span><span class="screen-reader-text">No Comments</span><span class="post-com-count post-com-count-pending post-com-count-no-pending"><span class="comment-count comment-count-no-pending" aria-hidden="true">0</span><span class="screen-reader-text">No Comments</span></span>
                    </div>
                </td>
                <td class="date mpbp-column-quanity" data-colname="quantity"><?php echo $mpbp_services_query_this_page[$row]->quantity; ?></td>
				<td class="date mpbp-column-status" data-colname="status"><?php echo $mpbp_services_query_this_page[$row]->status; ?></td>
            </tr>
			<?php
		} ?>
        </tbody>

        <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="mpbp_s_name" class="manage-column column-title column-primary sortable"><span>Name</span></th>
                <th scope="col" id="mpbp_s_pictures" class="manage-column column-author">Pictures</th>
                <th scope="col" id="mpbp_s_category" class="manage-column column-comments num sortable">Category<span></span></th>
                <th scope="col" id="mpbp_s_quantity" class="manage-column column-date sortable"><span>Quantity</span></th>
				<th scope="col" id="mpbp_s_status" class="manage-column column-date sortable"><span>Status</span></th>
            </tr>
        </tfoot>

    </table>

  <?php
  }
  
  
  mpbp_display_services();
?>