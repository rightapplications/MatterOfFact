<?php
get_header(); 
?>

<?php
if ( is_tag() ) {
$term_id = get_query_var('tag_id');
$taxonomy = 'post_tag';
$args ='include=' . $term_id;
$terms = get_terms( $taxonomy, $args );
$tag_slug = $terms[0]->slug;
}
?>

<div class="starred-bg">

<div class="container content-videos">
    
    <div class="row">
            <div class="col-lg-12">
                <h1><?php echo single_cat_title( '', false ); ?></h1>        
        </div>
    </div>
    
    <!-- || Start table-v1 -->
    <div class="table-v1">
    
        <div class="td1-v1">
			<div class="td1-v1-div">
				<ul class="videos-selected">
					<li><a href="<?php echo site_url('/');?>category/video/" title="">All videos<span class="circle-span"></span></a></li>
					<li><a href="<?php echo site_url('/');?>category/video/season/3/" title="">Season 3<span class="circle-span"></span></a></li>
                    <li><a href="<?php echo site_url('/');?>category/video/season/2/" title="">Season 2<span class="circle-span"></span></a></li>			                    
                    <li><a href="<?php echo site_url('/');?>category/video/season/1/" title="">Season 1<span class="circle-span"></span></a></li>
                    
                    <?php //filter
                    $aCategories = get_sub_categories('video');
                    //$aCategories = array_reverse($aCategories);
                    //$commentary = $aCategories[2];
                    //$extended = $aCategories[1];
                    //$aCategories[1] = $commentary;
                    //$aCategories[2] = $extended;
                    if(!empty($aCategories)){
                        foreach($aCategories as $cat){?>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/<?php echo $cat['slug']?>/" title=""><?php echo $cat['name']?><span class="circle-span"></span></a></li>
                        <?php }
                    }?>
                    
                    <?php
                    $aRecentDates = get_recent_dates(3);
                    if(!empty($aRecentDates)){?>
                    <li><p>Recent shows</p></li>                    
                    <?php foreach($aRecentDates as $date){?>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/date/<?php echo $date->meta_value?>/" title=""><?php echo $date->date?><span class="circle-span"></span></a></li>
                    <?php }?>
                    <?php }?>
                    
					<li><p>Popular topics</p></li>
                    <?php 
                    $args = array(
                        'orderby'      => 'count',
                        'order'        => 'DESC'	
                    );
                    $Tags = get_tags($args);
                    foreach($Tags as $tag){
                        $tag_meta = get_option("tag_".$tag->term_id);
                        $tag_status = $tag_meta['status'];
                        if($tag_status == 'popular'){    
                            if($tag->count >0){
                            ?>
					<li<?php if($tag_slug == $tag->slug) echo ' class="active"'?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>tag/<?php echo $tag->slug?>/" title=""><?php echo $tag->name?><span class="circle-span"></span></a></li>
                    <?php } 
                        }
                    }?>
				</ul>
			</div>
		</div>
        
        <div class="td2-v1">
            <div class="td2-v1-div">
                <!-- || Start Videos  -->
                <div>
                    <ul class="news">
                    <?php 
                    $cat = get_category( get_query_var( 'cat' ) );
$category = $cat->slug;
echo do_shortcode('[ajax_load_more post_type="post" tag="'.$tag_slug.'" posts_per_page="9" scroll="false" transition="fade" button_label="LOAD MORE" container_type="ul" css_classes="news"]');
                    ?>
                    </ul>
                </div>
                <!-- // Stop Videos  -->
            </div>
        </div>
            
    </div>

 
    
    </div>
</div>

<?php
get_footer();
?>