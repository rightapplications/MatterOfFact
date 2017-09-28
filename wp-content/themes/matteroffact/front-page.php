<?php
get_header(); 
?>
<?php //slides
$args = array(   
        'showposts'=>-1,
        'category_name' => 'home-page-slider',
		'meta_key' => 'position',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'        
    ); 
$query = new WP_Query( $args );
$aSlides = array();    
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
        $meta = get_post_meta($query->post->ID);         
        //$img =wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        $slide_image = isset($meta['slide_image'][0]) ? wp_get_attachment_url($meta['slide_image'][0]) : '';
        
        $imgs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
        $img = $imgs[0];
        
		//dump($post);
        $aSlide['img'] = !empty($slide_image) ? $slide_image : $img;
        $aSlide['img_mobile'] = $img;
        $aSlide['title'] = $post->post_title;
		$aSlide['description'] = $post->post_excerpt;
        $aSlide['content'] = trim_string(strip_tags($post->post_content), 100, false);
        $aSlide['primary_link_name'] = $meta['primary_link_name'][0];
        $aSlide['primary_link_url'] = $meta['primary_link_url'][0];
        $aSlide['secondary_link_name'] = $meta['secondary_link_name'][0];
        $aSlide['secondary_link_url'] = $meta['secondary_link_url'][0];
        $aSlide['image_focus_area'] = @$meta['image_focus_area'][0];
        $aSlides[] = $aSlide; 
	}
}
wp_reset_postdata();
?>
<script>
		(function($) {
            $(function() {
				if(!isMobile.iPhone()){   
					$('select').styler();
				}
            })
		})(jQuery); 
		jQuery(document).ready(function(){
			resizeCarousel();
		});
		jQuery(window).resize(function(){
			resizeCarousel();
		});
		function resizeCarousel(){
			var screenWidth = jQuery(window).width();
			if(screenWidth < 768){
				var videoHeight = Math.round(screenWidth*9/16);
				jQuery('.new-carousel-photo').height(videoHeight);
			}
		}
</script>
<?php if(!empty($aSlides)){?>
<div class="container-fluid new-carousel">
	<div class="row">
		<div class="container">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			
				<ol class="carousel-indicators">
				<?php foreach($aSlides as $num=>$slide){?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $num?>" <?php if($num == 0) echo 'class="active"'?>></li>
				<?php }?>
                </ol>
				
				<div class="carousel-inner">
				<?php foreach($aSlides as $num=>$slide){?>
					<!-- start repeat new-carousel -->
                    <div class="item<?php if($num == 0) echo ' active'?>">
                        <div class="new-carousel-block">
                            <div class="new-carousel-photo" style="background-image:url(<?php echo $slide['img']?>);"></div>
                            <div class="new-carousel-text">
                                 <div class="election"><?php echo $slide['content']?></div>
                                 <h2><?php echo $slide['title']?></h2>                                 
								 <div class="description">
								 <?php if(!empty($slide['description'])){?>
                                    <p>
                                        <?php echo $slide['description']?>
                                    </p>
									<?php }?>
                                 </div>								 
								 <?php if(!empty($slide['primary_link_name'])){?>
                                 <div class="watch-now">
									<a href="<?php echo $slide['primary_link_url']?>" title=""><?php echo $slide['primary_link_name']?></a>
								 </div>
								 <?php }?>
								 <?php if(!empty($slide['secondary_link_name'])){?>
                                    <div class="watch-now secondary-link"><br /><a href="<?php echo $slide['secondary_link_url']?>"><?php echo $slide['secondary_link_name']?> &raquo;</a></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- stop repeat new-carousel -->
				<?php }?>
				</div>
				
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/prew.png" alt="" /></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span><img src="<?php echo get_template_directory_uri(); ?>/images/next.png" alt="" /></span>
                </a>
			
			</div>
		</div>
	</div>
</div>
<?php }?>


<div class="starred-bg">

	<?php //latest full episodes
	$args = array(   
        'showposts'=>1,
        'category_name' => 'full-episodes',
        'orderby' => 'published',
        'order' => 'DESC'        
    );
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$lates_post_link = get_permalink($query->post->ID);
		}
	}
	wp_reset_postdata();
	?>
	

	<!-- start banner
	<div class="container">
        <div class="bannerhome-2">
            <div class="bannerhome-table">
                <div class="bannerhome-content">
                    <div class="bc-top">A "Matter of Fact" Live Special</div>
                    <p><span>State of</span> <span>Addiction</span></p>
                    <div class="ls-b2">
                        <span>September 13, 10 PM EST</span>
                        <a href="<?php echo site_url('/state-of-addiction/'); ?>" title="">Learn More</a>
                        <a href="<?php echo site_url('/wall-of-remembrance/'); ?>" title="">Wall of Remembrance</a>
                    </div>
                </div>
                <div class="bannerhome-photo" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/photo_b2.png);"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
	 stop banner -->
	
	<!-- start banner 
	<div class="container">
		<div class="banner-home">
			<div class="bannerhome-table">
				<div class="bannerhome-content">
					<div class="bc-top">WATCH THE LATEST FULL EPISODE OF</div>
					<p><span>MATTER OF FACT WITH</span> <span>SOLEDAD O’BRIEN</span></p>
					<div class="watch-now"><a href="<?php echo $lates_post_link?>" title="">WATCH FULL EPISODE</a></div>
				</div>
				<div class="bannerhome-photo" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bannerhome-photo-1.jpg);"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	 stop banner -->	
	 
	<!-- start banner 
	<div class="container">
		<div class="banner-home">
			<div class="bannerhome-table">
				<div class="bannerhome-content">
					<div class="bc-top">Join Soledad Wednesday April 12th at 7 PM ET</div>
					<p><span>Facebook Live Panel on sex trafficking in the U.S.</span></p>
					<div class="watch-now"><a href="http://matteroffact.tv/about/join-soledad-facebook-live-panel/" title="">MORE</a></div>
				</div>
				<div class="bannerhome-photo" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bannerhome-photo-1.jpg);"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	 stop banner -->	

    <div class="container content">
        <div class="row">
            <div class="col-lg-12">
                <h1>Latest</h1>
            </div>
        </div>
        <div class="row">
        
<?php //filter
$aFilter = get_video_filter_latest_single();?>
            <!-- || Start Latest tabs -->
			<div class="tabs-block desktop">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="tab-default" role="tablist">
    <?php foreach($aFilter as $k=>$cat){?>
        <li role="presentation" <?php if($k==0) echo 'class="active"'?>><a href="#<?php echo $cat['slug']?>" aria-controls="<?php echo $cat['slug']?>" role="tab" data-toggle="tab" id="switcher-<?php echo $cat['slug']?>"><?php echo $cat['name']?></a></li>
    <?php }?>
                        </ul>
					</div>
				</div>
			</div>
			<!-- // Stop Latest tabs -->
            
            <!-- || Start Latest tabs for mobile -->
			<div class="tabs-block mobile">
				<select class="mobileTabSwitcher">
                <?php foreach($aFilter as $k=>$cat){?>
					<option value="<?php echo $cat['slug']?>"><?php echo $cat['name']?></option>
                <?php }?>
				</select>
			</div>
			<!-- // Stop Latest tabs  for mobile -->
            
            <!-- || start tab-content -->
			<div class="tab-content">
            <?php //latest
               foreach($aFilter as $k=>$cat){
                    if($cat['slug'] != 'latest-show'){
                        $num = 6;
                    }else{
                        $num = -1;
                    }
                    $aVideos = get_filtered_video($cat['slug'], $num);
                ?>
                    
                <!-- || start tabpanel -->
				<div role="tabpanel" class="tab-pane <?php if($k==0) echo 'active'?>" id="<?php echo $cat['slug']?>">
                    <?php if ( $aVideos ) {?>
                    <ul class="news">                    
                        <?php foreach ($aVideos as $video) {?>
                        <li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<div>
                            <?php if(!empty($video['img'])){?>
								<span class="news-img" style="background:url(<?php echo $video['img']?>) no-repeat 50% 50%"></span>
                            <?php }?>
								<span class="news-wrap">
									<p><?php echo trim_string($video['title'], 72)?></p>
								<span class="date"><?php echo $video['date']?></span>
								</span>
								<!-- || Start dropdown-box -->
								<span class="dropdown-box">
									<p class="title"><?php echo trim_string($video['title'], 72)?></p>
									<span class="date"><?php echo $video['date']?></span>
									<p class="text">
										<?php echo trim_string(strip_tags($video['content']), 150)?>
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
				<!-- // stop tabpanel -->
            <?php }
            wp_reset_postdata();
            ?>
            </div>
            
            <!-- || Start More video -->
			<div class="clearfix"></div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="more-button" href="<?php echo site_url('/');?>category/video" title="">More videos</a>
			</div>
			<!-- // Stop More video -->            
            
<?php //}?>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h1>Recent Guests</h1>
                </div>
            </div>
            <?php /*
            <div class="tabs-block desktop">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="tab-default" role="tablist">
							<li role="presentation" class="active"><a href="#recent-appearances" aria-controls="recent-appearances" role="tab" data-toggle="tab" id="switcher-recent-appearances">Recent appearances</a></li>
							<li role="presentation"><a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab" id="switcher-upcoming">Upcoming</a></li>
						</ul>
					</div>
				</div>
			</div>
            
            <!-- || Start Latest tabs for mobile -->
			<div class="tabs-block mobile">
				<select class="mobileTabSwitcher">
					<option value="recent-appearances">Recent appearances</option>
					<option value="upcoming">Upcoming</option>
				</select>
			</div>
			<!-- // Stop Latest tabs  for mobile -->
            */?>
     <?php
        $aRecent = $aNext = array();
        $aGuests = get_guests(4, 'term_id', 'DESC', 1);
        if(!empty($aGuests)){
            $r=0;
            $n=0;
            foreach($aGuests as &$guest){
                
                    if (function_exists('z_taxonomy_image_url')){
                        $guest->img = z_taxonomy_image_url($guest->term_id, 'thumbnail');                        
                    }
                    /*$cat_meta = get_option("category_".$guest->cat_ID);
                    if($cat_meta['status'] == 'recent'){
                        if($r<4){
                            $aRecent[] = $guest;
                            $r++;
                        }
                    }
                    if($cat_meta['status'] == 'next'){
                        if($n<4){
                            $aNext[] = $guest;
                            $n++;
                        }
                    }*/
            }
        } //dump($aNext);
    ?>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="recent-appearances">
                    <div class="row">
                    <?php if(!empty($aGuests)){?>
                        <ul>
                        <?php foreach($aGuests as $g){ ?>
                            <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="guests-item">
                                
									<div class="guests-item-photo">
                                        <div class="guests-item-photo-table">
                                        <?php if(!empty($g->img)){?>
                                            <span><img src="<?php echo $g->img;?>" alt="" /></span>
                                        <?php }?>
                                        </div>
									</div>
                                
									<div class="guests-item-title">
										<?php echo $g->name?>
									</div>
									<div class="guests-item-text">
										<?php echo $g->description?>
									</div>
                                    <?php if($g->count){?>
									<a href="<?php echo site_url('/');?>category/<?php echo $g->slug?>" title="">Videos</a>
                                    <?php }?>
								</div>
							</li>
                        <?php }?>
                        </ul>
                    <?php }?>
                    </div>
                </div>
                <?php /*<div role="tabpanel" class="tab-pane" id="upcoming">
                    <div class="row">
                        <?php if(!empty($aNext)){?>
                        <ul>
                        <?php foreach($aNext as $guest){?>
                            <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<div class="guests-item">
                                    <div class="guests-item-photo">
                                        <div class="guests-item-photo-table">
                                        <?php if(!empty($guest->img)){?>
                                            <span><img src="<?php echo $guest->img;?>" alt="" /></span>
                                        <?php }?>
                                        </div>
                                    </div>
									<div class="guests-item-title">
										<?php echo $guest->name?>
									</div>
									<div class="guests-item-text">
										<?php echo $guest->description?>
									</div>
									<?php if($guest->count){?>
									<a href="<?php echo site_url('/');?>category/<?php echo $guest->slug?>" title="">Videos</a>
                                    <?php }?>
								</div>
							</li>
                        <?php }?>
                        </ul>
                    <?php }?>
                    </div>
                </div> */?>
            </div>
            <br />
            <!-- || Start More video -->
			<div class="clearfix"></div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<a class="more-button" href="<?php echo site_url('/');?>guests/" title="">More Guests</a>
			</div>
			<!-- // Stop More video -->   
                 
            <!-- || Start Spread the word -->
	<div class="container content spread-the-word">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1>Spread the word</h1>
				<p>SHARE MATTER OF FACT WITH SOLEDAD O'BRIEN ON FACEBOOK</p>
				<a class="click-here" href="https://www.facebook.com/sharer/sharer.php?u=http://matteroffact.tv" title="" target="_blank">SHARE NOW</a>
			</div>
		</div>
	</div>
	<!-- // Stop Spread the word -->

        </div>
    </div>  
    
    
</div>

<?php
get_footer(); 
?>