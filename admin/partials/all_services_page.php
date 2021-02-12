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
  ?>
  <form id="posts-filter" method="get">

    <p class="search-box">
        <label class="screen-reader-text" for="post-search-input">Raadi Bogag:</label>
        <input type="search" id="post-search-input" name="s" value="">
        <input type="submit" id="search-submit" class="button" value="Raadi Bogag">
    </p>

    <input type="hidden" name="post_status" class="post_status_page" value="all">
    <input type="hidden" name="post_type" class="post_type_page" value="page">



    <input type="hidden" id="_wpnonce" name="_wpnonce" value="c24969ca34"><input type="hidden" name="_wp_http_referer" value="/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;paged=2&amp;action2=-1">
    <div class="tablenav top">

        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select name="action" id="bulk-action-selector-top">
                <option value="-1">Bulk Actions</option>
                <option value="edit" class="hide-if-no-js">Tifaftir</option>
                <option value="trash">Move to Bin</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Ku Amar">
        </div>
        <div class="alignleft actions">
            <label for="filter-by-date" class="screen-reader-text">Filter by date</label>
            <select name="m" id="filter-by-date">
                <option selected="selected" value="0">All dates</option>
                <option value="201909">Seteembar 2019</option>
                <option value="201907">Luulyo 2019</option>
                <option value="201904">Abriil 2019</option>
                <option value="201903">Maarso 2019</option>
                <option value="201902">Febraayo 2019</option>
            </select>
            <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter">
        </div>
        <h2 class="screen-reader-text">Pages list navigation</h2>
        <div class="tablenav-pages"><span class="displaying-num">23 items</span>
            <span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
                <a class="prev-page" href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;paged=1&amp;action2=-1"><span class="screen-reader-text">Boggii hore</span><span aria-hidden="true">‹</span></a>
                <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="2" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> of <span class="total-pages">2</span></span></span>
                <span class="tablenav-pages-navspan" aria-hidden="true">›</span>
                <span class="tablenav-pages-navspan" aria-hidden="true">»</span></span>
        </div>
        <br class="clear">
    </div>
    <h2 class="screen-reader-text">Pages list</h2>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="author" class="manage-column column-author">Qoraa</th>
                <th scope="col" id="comments" class="manage-column column-comments num sortable desc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Faallooyin"><span class="screen-reader-text">Faallooyin</span></span></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="date" class="manage-column column-date sortable asc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>
            </tr>
        </thead>

        <tbody id="the-list">
            <tr id="post-3" class="iedit author-self level-0 post-3 type-page status-draft hentry entry">
                <th scope="row" class="check-column"> <label class="screen-reader-text" for="cb-select-3">Select Privacy Policy</label>
                    <input id="cb-select-3" type="checkbox" name="post[]" value="3">
                    <div class="locked-indicator">
                        <span class="locked-indicator-icon" aria-hidden="true"></span>
                        <span class="screen-reader-text">“Privacy Policy” is locked</span>
                    </div>
                </th>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                    <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                    <strong><a class="row-title" href="http://localhost:8080/wordpress/wp-admin/post.php?post=3&amp;action=edit" aria-label="“Privacy Policy” (Edit)">Privacy Policy</a> — <span class="post-state">Qabyo, </span><span class="post-state">Privacy Policy Page</span></strong>

                    <div class="hidden" id="inline_3">
                        <div class="post_title">Privacy Policy</div>
                        <div class="post_name">privacy-policy</div>
                        <div class="post_author">1</div>
                        <div class="comment_status">closed</div>
                        <div class="ping_status">open</div>
                        <div class="_status">draft</div>
                        <div class="jj">26</div>
                        <div class="mm">02</div>
                        <div class="aa">2019</div>
                        <div class="hh">18</div>
                        <div class="mn">18</div>
                        <div class="ss">38</div>
                        <div class="post_password"></div>
                        <div class="post_parent">0</div>
                        <div class="page_template">default</div>
                        <div class="menu_order">0</div>
                    </div>
                    <div class="row-actions"><span class="edit"><a href="http://localhost:8080/wordpress/wp-admin/post.php?post=3&amp;action=edit" aria-label="Edit “Privacy Policy”">Tifaftir</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline" aria-label="Quick edit “Privacy Policy” inline">Quick&nbsp;Edit</a> | </span><span class="trash"><a href="http://localhost:8080/wordpress/wp-admin/post.php?post=3&amp;action=trash&amp;_wpnonce=8de0949d48" class="submitdelete" aria-label="Move “Privacy Policy” to the Bin">Trash</a> | </span><span class="view"><a href="http://localhost:8080/wordpress/?page_id=3&amp;preview=true" rel="bookmark" aria-label="Preview “Privacy Policy”">Horu’eeg</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                </td>
                <td class="author column-author" data-colname="Qoraa"><a href="edit.php?post_type=page&amp;author=1">Puntland</a></td>
                <td class="comments column-comments" data-colname="Faallooyin">
                    <div class="post-com-count-wrapper">
                        <span aria-hidden="true">—</span><span class="screen-reader-text">No Comments</span><span class="post-com-count post-com-count-pending post-com-count-no-pending"><span class="comment-count comment-count-no-pending" aria-hidden="true">0</span><span class="screen-reader-text">No Comments</span></span>
                    </div>
                </td>
                <td class="date column-date" data-colname="Date">Last Modified<br><abbr title="2019/02/26 6:18:38 g">2019/02/26</abbr></td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
                <th scope="col" class="manage-column column-title column-primary sortable desc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-author">Qoraa</th>
                <th scope="col" class="manage-column column-comments num sortable desc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Faallooyin"><span class="screen-reader-text">Faallooyin</span></span></span><span class="sorting-indicator"></span></a></th>
                <th scope="col" class="manage-column column-date sortable asc"><a href="http://localhost:8080/wordpress/wp-admin/edit.php?s&amp;post_status=all&amp;post_type=page&amp;action=-1&amp;m=0&amp;action2=-1&amp;orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>
            </tr>
        </tfoot>

    </table>

  <?php
  /*
  * retrieves selected results from databse and displays them on page
  */
  for($row = 0; $row<sizeof($mpbp_services_query_this_page); $row++){
	  echo $mpbp_services_query_this_page[$row]->id . ' : ' . $mpbp_services_query_this_page[$row]->name . '<br>';
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
  ($mpbp_current_service_page>=$mpbp_services_number_of_pages)? $mpbp_services_page_next_limit = "disabled" : '';
  ($mpbp_current_service_page<=1) ? $mpbp_services_page_previous_limit = "disabled" : ''; 
  echo '<br><a '. $mpbp_services_page_previous_limit .'href="http://localhost:8080/wordpress/wp-admin/admin.php?page=all_services&order='. $mpbp_previous_service_page .'"> Previous </a>';
  echo ' '. $mpbp_current_service_page .' of '. $mpbp_services_number_of_pages .' ';
  echo '<a '. $mpbp_services_page_next_limit  .'href="http://localhost:8080/wordpress/wp-admin/admin.php?page=all_services&order='. $mpbp_next_service_page .'"> Next</a><br>';
  
  }
  
  
  mpbp_display_services();
?>