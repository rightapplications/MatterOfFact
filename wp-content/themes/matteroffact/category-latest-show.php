<?php
get_header(); 
?>

<?php
if (is_category()) {
    $category = get_category(get_query_var('cat'));
    $cat_slug = $category->slug;
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
					<li<?php if($cat_slug == 'video') echo ' class="active"'?>><a href="<?php echo site_url('/');?>category/video/" title="">All videos<span class="circle-span"></span></a></li>
					
                    <?php
                    $aRecentDates = get_recent_dates(3);
                    if(!empty($aRecentDates)){?>
                    <li><p>Recent shows</p></li>                    
                    <?php foreach($aRecentDates as $date){?>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/date/<?php echo $date->meta_value?>/" title=""><?php echo $date->date?><span class="circle-span"></span></a></li>
                    <?php }?>
                    <?php }?>
                    
                    <li><p>Videos by Type</p></li>
                    <?php //filter
                    $aCategories = get_sub_categories('video');
                    $aCategories = array_reverse($aCategories);
                    $commentary = $aCategories[2];
                    $extended = $aCategories[1];
                    $aCategories[1] = $commentary;
                    $aCategories[2] = $extended;
                    if(!empty($aCategories)){
                        foreach($aCategories as $cat){?>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/video/<?php echo $cat['slug']?>/" title=""><?php echo $cat['name']?><span class="circle-span"></span></a></li>
                        <?php }
                    }?>
                    
					<li><p>Popular topics</p></li>
                    <?php 
                    $Tags = get_tags();
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

<?php //latest show
                $aVideos = get_filtered_video('latest-show');
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