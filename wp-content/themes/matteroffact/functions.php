<?php
define('SEASON_2_START', '20160910');
define('SEASON_3_START', '20170901');

function custom_page_rewrite(){    
    
    add_rewrite_rule( 
        '^guests/all/?',
        'index.php?pagename=guests&display=all',
        'top'
    ); 
    
    add_rewrite_rule(
        '^category/video/date/([0-9]{8})/?',
        'index.php?category_name=video&date=$matches[1]',
        'top'
    );
    
    add_rewrite_rule(
        '^category/video/season/([1-3]{1})/?',
        'index.php?category_name=video&season=$matches[1]',
        'top'
    ); 

}
add_action( 'init', 'custom_page_rewrite' );

function query_vars($public_query_vars) {
    $public_query_vars[] = "display";
    $public_query_vars[] = "date";
    $public_query_vars[] = "season";
    return $public_query_vars;
}
add_filter('query_vars', 'query_vars');


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!is_admin()) {
        show_admin_bar(false);
    }
}

add_filter( 'the_content', 'wpautop' );

function mof_style() {
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap');    
    wp_register_style( 'main-style', get_template_directory_uri() . '/css/main.css?v=5.1');
    wp_enqueue_style( 'main-style');
    wp_register_style( 'bootstrap-select', get_template_directory_uri() . '/css/bootstrap-select.css');
    wp_enqueue_style( 'bootstrap-select');
}
add_action( 'wp_enqueue_scripts', 'mof_style' );

function mof_scripts() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, false );
    wp_enqueue_script( 'jquery' );
    wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, true );
    wp_enqueue_script( 'bootstrap');    
    wp_register_script( 'jquery-main', get_template_directory_uri() . '/js/jquery.main.js', array(), false, true );
    wp_enqueue_script( 'jquery-main'); 
    wp_register_script( 'jquery-formstyler', get_template_directory_uri() . '/js/jquery.formstyler.min.js', array(), false);
    wp_enqueue_script( 'jquery-formstyler'); 
    wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array(), false, true );
    wp_enqueue_script( 'main'); 
    wp_register_script( 'bootstrap-select', get_template_directory_uri() . '/js/bootstrap-select.min.js', array(), false, true );
    wp_enqueue_script( 'bootstrap-select'); 
}
add_action( 'wp_enqueue_scripts', 'mof_scripts' );

function mof_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Bar', 'matteroffact' ),
		'id'            => 'footer',
		'description'   => __( 'Add widgets here to appear in website footer.', 'matteroffact' ),
		'before_widget' => '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Header', 'matteroffact' ),
		'id'            => 'header',
		'description'   => __( 'Add widgets here to appear in website header.', 'matteroffact' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Video Left Side', 'matteroffact' ),
		'id'            => 'video',
		'description'   => __( 'Add widgets here to appear on video page.', 'matteroffact' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'mof_widgets_init' );

//Menu areas registration
register_nav_menus( array(
		'primary'   => __( 'Main Menu', 'matteroffact' ),
	) );
register_nav_menus( array(
		'secondary'   => __( 'Footer Menu', 'matteroffact' ),
	) );
register_nav_menus( array(
		'about'   => __( 'About Menu', 'matteroffact' ),
	) );

//Featured images on
add_theme_support( 'post-thumbnails' ); 

//search filter
function SearchFilter($query) {
    if ($query->is_search and !is_admin()) {
        $query->set('post_type', 'post');
        $query->set('category_name', 'video');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');


//add extra fields to category edit form hook
add_action ( 'edit_category_form_fields', 'extra_category_fields');
//add_action ( 'category_add_form_fields', 'extra_category_fields');
//add extra fields to category edit form callback function
function extra_category_fields( $tag ) {	//check for existing featured ID
	$t_id = @$tag->term_id;
	$cat_meta = get_option( "category_$t_id");
?>
<tr class="form-field">
<th scope="row" valign="top"><label for="extra1"><?php _e('Status'); ?></label></th>
<td>
<select name="Cat_meta[status]" id="Cat_meta[status]">
<option value="default" <?php echo $cat_meta['status'] == 'default'? 'selected' : ''; ?>>Default</option>
<option value="recent" <?php echo $cat_meta['status'] == 'recent'? 'selected' : ''; ?>>Recent</option>
<option value="next" <?php echo $cat_meta['status'] == 'next'? 'selected' : ''; ?>>Next</option>
</select>
<br />
            <span class="description"><?php _e('Status'); ?></span>
        </td>
</tr>
<?php
}

// save extra category extra fields hook
add_action ( 'edited_category', 'save_extra_category_fields');
   // save extra category extra fields callback function
function save_extra_category_fields( $term_id ) {
	if ( isset( $_POST['Cat_meta'] ) ) {
		$t_id = $term_id;
		$cat_meta = get_option( "category_$t_id");
		$cat_keys = array_keys($_POST['Cat_meta']);
			foreach ($cat_keys as $key){
			if (isset($_POST['Cat_meta'][$key])){
				$cat_meta[$key] = $_POST['Cat_meta'][$key];
			}
		}
		//save the option array
		update_option( "category_$t_id", $cat_meta );
	}
}


//add extra fields to category edit form hook
add_action ( 'edit_tag_form_fields', 'extra_tag_fields');
//add_action ( 'category_add_form_fields', 'extra_category_fields');
//add extra fields to category edit form callback function
function extra_tag_fields( $tag ) {	//check for existing featured ID
	$t_id = @$tag->term_id;
	$tag_meta = get_option( "tag_$t_id");
?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="extra1"><?php _e('Status'); ?></label></th>
    <td>
        <select name="Tag_meta[status]" id="Tag_meta[status]">
            <option value="default" <?php echo $tag_meta['status'] == 'default'? 'selected' : ''; ?>>Default</option>
            <option value="popular" <?php echo $tag_meta['status'] == 'popular'? 'selected' : ''; ?>>Popular</option>
        </select>
        <br />
        <span class="description"><?php _e('Status'); ?></span>
    </td>
</tr>
<?php
}

// save extra category extra fields hook
add_action ( 'edited_term', 'save_extra_tag_fields');
   // save extra category extra fields callback function
function save_extra_tag_fields( $term_id ) {
	if ( isset( $_POST['Tag_meta'] ) ) {
		$t_id = $term_id;
		$tag_meta = get_option( "tag_$t_id");
		$tag_keys = array_keys($_POST['Tag_meta']);
			foreach ($tag_keys as $key){
			if (isset($_POST['Tag_meta'][$key])){
				$tag_meta[$key] = $_POST['Tag_meta'][$key];
			}
		}
		//save the option array
		update_option( "tag_$t_id", $tag_meta );
	}
}

function mof_add_current_nav_class($classes, $item) {
    global $post;
    if(is_tag() or is_category()){ 
            if($item->post_name == 'video-clips-episodes'){
                $classes[] = 'current-menu-item';
            }
    }   
    return $classes;
}
add_action('nav_menu_css_class', 'mof_add_current_nav_class', 10, 2 );

//parent category template for subcategories
function new_subcategory_hierarchy() {  
    $category = get_queried_object();
 
    $parent_id = $category->category_parent;
 
    $templates = array();
     
    if ( $parent_id == 0 ) {
        // Use default values from get_category_template()
        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
        $templates[] = 'category.php';      
    } else {
        // Create replacement $templates array
        $parent = get_category( $parent_id );
 
        // Current first
        $templates[] = "category-{$category->slug}.php";
        $templates[] = "category-{$category->term_id}.php";
 
        // Parent second
        $templates[] = "category-{$parent->slug}.php";
        $templates[] = "category-{$parent->term_id}.php";
        $templates[] = 'category.php';  
    }
    return locate_template( $templates );
} 
add_filter( 'category_template', 'new_subcategory_hierarchy' );

//category single template
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);


function get_sub_categories($parent, $detail = false, $num=''){
    $idObj = get_category_by_slug($parent); 
    $id = $idObj->term_id;
    unset($idObj);
    $args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => $id,
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => $num,
        'taxonomy'                 => 'category',
        'pad_counts'               => false 
    );
    $categories = get_categories( $args );
    if($detail){
        $aCategories = $categories;
    }else{
        $aCategories = array();
        if(!empty($categories)){
            foreach($categories as $k=>$cat){
                $aCategories[$k]['cat_ID'] = $cat->cat_ID;
                $aCategories[$k]['name'] = $cat->name;
                $aCategories[$k]['slug'] = $cat->slug;
            }
            unset($categories);
        } 
    }
    return $aCategories;
}

function get_video_filter(){
    $aFilter = array(
        0=>array(
              'slug'=>'short-videos',
              'name'=>'Highlights'
        ),
        1=>array(
              'slug'=>'latest-show',
              'name'=>'Latest Show'
        ),
        2=>array(
              'slug'=>'extended-interviews',
              'name'=>'Extended Interviews'
        )        
    );
    return $aFilter;
}

function get_video_filter_latest(){
    $aFilter = array(
        0=>array(
              'slug'=>'short-videos',
              'name'=>'Latest Highlights'
        ),
        1=>array(
              'slug'=>'extended-interviews',
              'name'=>'Extended Interviews'
        ),
        2=>array(
              'slug'=>'packages',
              'name'=>'Packages'
        )     
    );
    return $aFilter;
}

function get_video_filter_latest_single(){
    $aFilter = array(
        0=>array(
              'slug'=>'short-videos',
              'name'=>'Highlights'
        ),
        1=>array(
              'slug'=>'packages',
              'name'=>'Packages'
        ),
		2=>array(
              'slug'=>'full-episodes',
              'name'=>'Full Episodes'
        )  
    );
    return $aFilter;
}

function get_filtered_video($filter, $num=-1){
    $aVideos = array();
    if($filter !== 'latest-show'){        
        $args = array(   
        'showposts'=>$num,
        'category_name' => $filter,
        'orderby' => 'published',
        'order' => 'DESC'        
        ); 
        
    }else{
        $curDate = getdate();
        $yy = $curDate['year'];
        if($curDate['mon'] < 10){
            $mm = '0'.$curDate['mon'];
        }else{
            $mm = $curDate['mon'];
        }
        if($curDate['mday'] < 10){
            $dd = '0'.$curDate['mday'];
        }else{
        $dd = $curDate['mday'];
        }
        $currentDate = intval($yy.$mm.$dd);
        global $wpdb;
        $latest_show_date = $wpdb->get_var( $wpdb->prepare( "SELECT DISTINCT MAX(meta_value) FROM ".$wpdb->postmeta."
                                                   LEFT JOIN ".$wpdb->posts." ON ".$wpdb->posts.".ID = ".$wpdb->postmeta.".post_id
                                                   WHERE ".$wpdb->postmeta.".meta_key = 'release_date' 
                                                   AND ".$wpdb->posts.".post_status = 'publish'
                                                   AND meta_value <= '".$currentDate."'
                                                   "));
        $args = array(   
            'showposts'=>$num,
            'category_name' => 'video',        
            'meta_query'	=> array(
                array(
                'key'	  	=> 'release_date',
                'value'	  	=> $latest_show_date,
                'compare' 	=> '=',
                )
            ),
            'meta_key' => 'release_date',
            'orderby' => 'published',
            'order' => 'DESC'       
        );
    }
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();  
                $imgs = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'large' );
                $img = $imgs[0];
                $aVideo = array();
                $aVideo['id'] = $query->post->ID;
                $aVideo['img'] = $img;
                $aVideo['title'] = $query->post->post_title;
                $aVideo['content'] = $query->post->post_content;
                $aVideo['date'] = get_the_date();
                $aVideo['link'] = get_permalink($query->post->ID);
                $aVideos[] = $aVideo;
            }
    }
    return $aVideos;
}

function get_videos_by_date($date, $num=-1){
    $aVideos = array();
    $args = array(   
            'showposts'=>$num,
            'category_name' => 'video',        
            'meta_query'	=> array(
                array(
                'key'	  	=> 'release_date',
                'value'	  	=> $date,
                'compare' 	=> '=',
                )
            ),
            'meta_key' => 'release_date',
            'orderby' => 'published',
            'order' => 'DESC'       
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();  
                $imgs = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'large' );
                $img = $imgs[0];
                $aVideo = array();
                $aVideo['id'] = $query->post->ID;
                $aVideo['img'] = $img;
                $aVideo['title'] = $query->post->post_title;
                $aVideo['content'] = $query->post->post_content;
                $aVideo['date'] = get_the_date();
                $aVideo['link'] = get_permalink($query->post->ID);
                $aVideos[] = $aVideo;
            }
    }
    return $aVideos;
}

function get_recent_dates($num){
    $curDate = getdate();
    $yy = $curDate['year'];
    if($curDate['mon'] < 10){
        $mm = '0'.$curDate['mon'];
    }else{
        $mm = $curDate['mon'];
    }
    if($curDate['mday'] < 10){
        $dd = '0'.$curDate['mday'];
    }else{
        $dd = $curDate['mday'];
    }
    $currentDate = intval($yy.$mm.$dd);
    global $wpdb;
    $latest_show_dates = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT meta_value FROM ".$wpdb->postmeta."
                                                   LEFT JOIN ".$wpdb->posts." ON ".$wpdb->posts.".ID = ".$wpdb->postmeta.".post_id
                                                   WHERE ".$wpdb->postmeta.".meta_key = 'release_date' 
                                                   AND ".$wpdb->posts.".post_status = 'publish'
                                                   AND meta_value <= '".$currentDate."'
                                                   ORDER BY meta_value DESC
                                                   LIMIT ".intval($num)."
                                                   "));
    if(!empty($latest_show_dates)){
        foreach($latest_show_dates as &$val){
            $date_ts = strtotime($val->meta_value);
            $val->timestamp = $date_ts;
            $val->date = strftime("%B %e, %Y", $date_ts);
        }
    }    
    return $latest_show_dates;                                               
}

function get_guests($num='', $ordby='', $order = '', $noempty=0){
    $idObj = get_category_by_slug('guests');
    $id = $idObj->term_id;
    unset($idObj);
    $args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => $id,
        'orderby'                  => $ordby ? $ordby :'name',
        'order'                    => $order ? $order : 'ASC',
        'hide_empty'               => intval($noempty),
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => $num,
        'taxonomy'                 => 'category',
        'pad_counts'               => false 
    );
    $categories = get_categories( $args );
    $aCategories = $categories;    
    return $aCategories;
}

function make_menu($name){
    $args = array(
        'order'                  => 'ASC',
        'orderby'                => 'menu_order',
        'post_type'              => 'nav_menu_item',
        'post_status'            => 'publish',
        'output'                 => ARRAY_A,
        'output_key'             => 'menu_order',
        'nopaging'               => true,
        'update_post_term_cache' => false );
    $aMenu = wp_get_nav_menu_items( $name, $args );
    $aOutputMenu = array();
    if(!empty($aMenu))foreach($aMenu as $item){
        if($item->menu_item_parent){
            if(isset($aOutputMenu[$item->menu_item_parent])){
                $aOutputMenu[$item->menu_item_parent]['submenu'][] = $item;
            }
        }else{
            $aOutputMenu[$item->ID]['main'] = $item;
        }
    }
    return $aOutputMenu;
}

function trim_string($mess, $length, $echo = true){
    if(strlen($mess) > $length){
        $mess = mb_substr($mess, 0, $length,'UTF-8') . '...';
    }
    if($echo){
        echo '<td>'.$mess.'</td>';
    }else{
        return $mess;
    }
}

function sort_array($array,$key,$type='ASC'){
    $sorted_array = array();
    if(@is_array($array) and count($array)>0){
        foreach($array as $k=>$row){
            @$key_values[$k] = $row[$key];
        }
        if($type == 'ASC' ){
            asort($key_values);
        }else{
            arsort($key_values);
        }
        foreach($key_values as $k=>$v){
            $sorted_array[] = $array[$k];
        }
        return $sorted_array;
    }else{
        return false;
    }
}

function dump($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    echo "<hr />";
}