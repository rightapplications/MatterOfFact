<?php
get_header(); 
?>

<?php
if (is_category()) {
    $category = get_category(get_query_var('cat'));
    $cat_slug = $category->slug;
}

if(isset($wp->query_vars['date'])){
    $d = $wp->query_vars['date'];
}else{
    $d = false;
}

if(isset($wp->query_vars['season'])){
    $season = $wp->query_vars['season'];
}else{
    $season = false;
}

?>

<div class="starred-bg">

<div class="container content-videos">
    
    <div class="row">
            <div class="col-lg-12">
                <h1>
                <?php if(!$d){
                    if(!$season){
                        echo single_cat_title( '', false );
                    }else{
                        echo 'Season '.$season;
                    }
                }else{ 
                    echo 'Recent Shows';
                }?>
                </h1>        
        </div>
    </div>
    
    <!-- || Start table-v1 -->
    <div class="table-v1">
    
        <div class="td1-v1">
			<div class="td1-v1-div">
				<ul class="videos-selected">
					<li<?php if($cat_slug == 'video' and !$d and !$season) echo ' class="active"'?>><a href="<?php echo site_url('/');?>category/video/" title="">All videos<span class="circle-span"></span></a></li>
					<li<?php if($cat_slug == 'video' and !$d and $season === '3') echo ' class="active"'?>><a href="<?php echo site_url('/');?>category/video/season/3/" title="">Season 3<span class="circle-span"></span></a></li>
                    <li<?php if($cat_slug == 'video' and !$d and $season === '2') echo ' class="active"'?>><a href="<?php echo site_url('/');?>category/video/season/2/" title="">Season 2<span class="circle-span"></span></a></li>			                    
                    <li<?php if($cat_slug == 'video' and !$d and $season === '1') echo ' class="active"'?>><a href="<?php echo site_url('/');?>category/video/season/1/" title="">Season 1<span class="circle-span"></span></a></li>
                                       
                    <?php //filter
                    $aCategories = get_sub_categories('video');
                    //$aCategories = array_reverse($aCategories);
                    //$commentary = $aCategories[2];
                    //$extended = $aCategories[1];
                    //$aCategories[1] = $commentary;
                    //$aCategories[2] = $extended;
                    if(!empty($aCategories)){
                        foreach($aCategories as $cat){?>
					<li<?php if($cat_slug == $cat['slug']) echo ' class="active"'?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/<?php echo $cat['slug']?>/" title=""><?php echo $cat['name']?><span class="circle-span"></span></a></li>
                        <?php }
                    }?>
                    
                    <?php
                    $aRecentDates = get_recent_dates(3);
                    if(!empty($aRecentDates)){?>
                    <li><p>Recent shows</p></li>                    
                    <?php foreach($aRecentDates as $date){?>
                    <li<?php if($d == $date->meta_value) echo ' class="active"'?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/date/<?php echo $date->meta_value?>/" title=""><?php echo $date->date?><span class="circle-span"></span></a></li>
                    <?php }?>
                    <?php }?>
                    
                    
					<li><p>Popular topics</p></li>
                    <?php 
                    $args = array(
                        'orderby'      => 'count',
                        'order'        => 'DESC'	
                    );
                    $Tags = get_tags($args);
                    if(!empty($Tags)){
                        foreach($Tags as $tag){
                            $tag_meta = get_option("tag_".$tag->term_id);
                            $tag_status = $tag_meta['status'];
                            if($tag_status == 'popular'){    
                                if($tag->count >0){
                                ?>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>tag/<?php echo $tag->slug?>/" title=""><?php echo $tag->name?><span class="circle-span"></span></a></li>
                            <?php } 
                            }
                        }
                    }?>
				</ul>
			</div>
		</div>
        
        <div class="td2-v1">
            <div class="td2-v1-div">
                <!-- || Start Videos  -->
                <div>
                <?php 
if(!$d){
    if(!$season){
        $cat = get_category( get_query_var( 'cat' ) );
        $category = $cat->slug;
        echo do_shortcode('[ajax_load_more post_type="post" category="'.$cat_slug.'" posts_per_page="9" scroll="false" transition="fade" button_label="LOAD MORE" container_type="ul" css_classes="news"]');
    }else{
        if($season === '1'){
            echo do_shortcode('[ajax_load_more post_type="post" category="video" posts_per_page="9" meta_key="release_date" meta_value="'.SEASON_2_START.'" meta_compare="lessthan" meta_type="NUMERIC" scroll="false" transition="fade" button_label="LOAD MORE" container_type="ul" css_classes="news"]');
        }elseif($season === '2'){
            echo do_shortcode('[ajax_load_more post_type="post" category="video" posts_per_page="9" meta_key="release_date" meta_value="'.SEASON_3_START.'" meta_compare="lessthan" meta_type="NUMERIC" scroll="false" transition="fade" button_label="LOAD MORE" container_type="ul" css_classes="news"]');
        }else{
			echo do_shortcode('[ajax_load_more post_type="post" category="video" posts_per_page="9" meta_key="release_date" meta_value="'.SEASON_3_START.'" meta_compare=">=" meta_type="NUMERIC" scroll="false" transition="fade" button_label="LOAD MORE" container_type="ul" css_classes="news"]');
		}
    }
}else{
    $aVideos = get_videos_by_date($d);
    if(!empty($aVideos)){?>
                    <ul class="news">
                    <?php foreach($aVideos as $video){?>
                 
                 <li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div> 
                            
<?php if(!empty($video['img'])){?>
								<span class="news-img" style="background:url(<?php echo $video['img']?>) no-repeat 50% 50%"></span>
                            <?php }?>
								<span class="news-wrap">
									<p><?php echo $video['title']?></p>
								<span class="date"><?php echo $video['date']?></span>
                            </span>
								<!-- || Start dropdown-box -->
								<span class="dropdown-box">
									<p class="title"><?php $video['title']?></p>
									<span class="date"><?php echo $video['date']?></span>
									<p class="text">
										<?php echo trim_string($video['content'], 50)?>
									</p>
									<a href="<?php echo $video['link']?>" title="" style="display:none">Watch now</a>
                               </span>
								<!-- // Stop dropdown-box -->
                            </div>
                        </li>
                 
                    <?php }?>  
                    </ul>                    
               <?php }?>

<?php }?>       
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