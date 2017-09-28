<?php
get_header();
?>
<!-- SCROLL block -->
<link href="<?php echo get_template_directory_uri(); ?>/css/flexcrollstyles.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/flexcroll.js"></script>
<!-- SCROLL block -->
<?php
        while ( have_posts() ) : the_post();
                $title = get_the_title();
                $content = get_the_content();
                $meta = get_post_meta($post->ID);
                $videocode = $meta['youtube_video_code'][0];
                $date = get_the_date();
                $tags = wp_get_post_tags($post->ID);
        endwhile;		
?>
<script>
(function($) {
            $(function() {
				if(!isMobile.iPhone()){   
					$('select').styler();
				}
            })
		})(jQuery); 
var initialVideoWidth;
var initialVideoHeight;
jQuery(document).ready(function(){
    initialVideoWidth = jQuery('.video-data').find('iframe').width(); 
    initialVideoHeight = jQuery('.video-data').find('iframe').height();
    resizeVideo();
	
	jQuery('.more-button').click(function(){
		if(jQuery(this).hasClass('expanded')){
			jQuery(this).removeClass('expanded');
			jQuery(this).text('Show More');
			jQuery(this).parent().find('.tab-text').css('height', 130+'px');
			jQuery(this).parent().find('.bg-bottom-fff').css('display', 'block');
		}else{
			jQuery(this).addClass('expanded');
			jQuery(this).text('Show Less');
			jQuery(this).parent().find('.tab-text').css('height', 'auto');
			jQuery(this).parent().find('.bg-bottom-fff').css('display', 'none');
		}
		return false;
	});
});
jQuery(window).resize(function(){
    resizeVideo();    
});
function resizeVideo(){
    screenWidth = jQuery(window).width();
    //if(screenWidth > mobileWidth){
        var videoWidth = Math.round(jQuery('.video-data').width()); 
    //}else{
        //var videoWidth = Math.round(jQuery('.scaping-syria-bg').width()) - 60;
    //}
    jQuery('.video-data').find('iframe').width(videoWidth);
        
    var videoHeight = Math.round(initialVideoHeight * videoWidth / initialVideoWidth);
    jQuery('.video-data').find('iframe').height(videoHeight);
}
</script>
<?php 
$aRelatedPosts = array();
if(!empty($tags)){	
	foreach($tags as $tag){
		$args = array(
                'showposts'=>8,
                'orderby' => 'ID',
                'order' => 'DESC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => $tag->slug
                    )
                )
		);
		$postslist = get_posts( $args ); 
		foreach($postslist as &$p){
			if($p->ID != $post->ID){
				$imgs = wp_get_attachment_image_src( get_post_thumbnail_id($p->ID), 'large' );
				$img = $imgs[0];
				$p->img = $img;
				$aRelatedPosts[$p->ID] = $p;
			}
		}            
	} 
}
?>
<div class="video<?php if(empty($meta['transcript'][0])){?> no-tabs<?php }?>">
    <div class="video-box">
        <div class="container">
		
			<div class="up-next"><span><?php if ( $aRelatedPosts ) {?>RELATED VIDEOS<?php }else{?>&nbsp;<?php }?></span></div>
			
			<div class="video-table">
			
				<div class="video-td td-1">	
				
					<div class="video-container">
						<div class="embed-responsive embed-responsive-16by9">
						<?php if(!empty($videocode)){?>
							<iframe width="100%" src="https://www.youtube.com/embed/<?php echo $videocode?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
						 <?php }?>     
						</div>                                
					</div>
					
					<div class="video-content">
						<header>
							<h1>
								<?php echo $title?>
							</h1>
						</header>
					</div>
					
					<div class="row">					
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="data-video"><?php echo $date?></div>
						</div>						
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="pull-right">	
								 <?php if ( is_active_sidebar( 'video' ) ) : ?>
									<?php dynamic_sidebar( 'video' ); ?>
								<?php endif ?>								
							</div>
						</div>					
					</div> 
					
				</div>
				<?php if ( $aRelatedPosts ) {?>
				<div id="mycustomscroll" class="video-td td-2 flexcroll">
					<div class="video-sidebar">
						<ul>
							<?php
							$n = 0; 
							foreach( $aRelatedPosts as $rp) {
								if($n < 16){?>
							<li>
								<div class="prew-video">
									<div class="prew-video-photo">
										<a href="<?php echo get_permalink($rp->ID)?>" title="<?php echo $rp->post_title?>"><img src="<?php echo $rp->img?>" alt="<?php echo $rp->post_title?>" /></a>
									</div>
									<div class="prew-video-content">
										<a href="<?php echo get_permalink($rp->ID)?>" title="<?php echo $rp->post_title?>">
												<?php echo $rp->post_title?>
										</a>
									</div>
								</div>
							</li>
							<?php $n++;} 
							}?>
						</ul>
					</div>
				</div>
				<?php }?>
			</div>			
            
        </div>
    </div>
</div>

<div class="clearfix"></div>
<?php
$content_length = strlen($content);
if($content_length < 900){
	$showContent = true;
}else{
	$showContent = false;
}
$showTranscript = false;
if(!empty($meta['transcript'][0])){
	$transcript_length = strlen($meta['transcript'][0]);
	if($transcript_length < 900){
		$showTranscript = true;
	}
}
?>
<div class="container">
	<div class="tab-container-1">
	<?php if(!empty($meta['transcript'][0])){?>	
		<ul class="nav-tabs" role="tablist"><!-- If the tab is not delete block <ul class="nav-tabs" role="tablist"> -->
			<li class="active" role="presentation"><a href="#readmore" aria-controls="readmore" role="tab" data-toggle="tab">READ MORE</a></li>
			<li role="presentation"><a href="#transcript" aria-controls="transcript" role="tab" data-toggle="tab">TRANSCRIPT</a></li>
		</ul>	
	<?php }?>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="readmore">
				<div class="tab-text" style="height:<?php if(!$showContent){?>130px<?php }else{?>auto<?php }?>;">
					<?php the_content()?>
					<div class="bg-bottom-fff" style="<?php if($showContent){?>display:none<?php }?>"></div>
				</div>
				<div class="clearfix"></div>
				<?php if(!$showContent){?>
				<a class="more-button" href="#" title="">Show More</a>
				<?php }?>
			</div>
			<?php if(!empty($meta['transcript'][0])){?>			
			<div role="tabpanel" class="tab-pane" id="transcript">
				<div class="tab-text" style="height:<?php if(!$showTranscript){?>130px<?php }else{?>auto<?php }?>;">
					<?php echo $meta['transcript'][0]?>					
					<div class="bg-bottom-fff" style="<?php if($showTranscript){?>display:none<?php }?>"></div>
				</div>
				<div class="clearfix"></div>
				<?php if(!$showTranscript){?>
				<a class="more-button" href="#" title="">Show More</a>
				<?php }?>
			</div>
			<?php }?>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<div class="starred-bg">
    <div class="container content">       
	<div class="mobile">
        <?php 
        if ( $aRelatedPosts ) {?>
         <div class="row">
            <div class="col-lg-12">
                <h1>Related Videos</h1>
            </div>
        </div>
    <div class="row">
    <ul class="news">
	<?php $n = 0; 
          foreach( $aRelatedPosts as $rp) {
              if($n < 8){?>
		<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div>
                <?php if(!empty($rp->img)){?>
                <span class="news-img" style="background:url(<?php echo $rp->img?>) no-repeat 50% 50%"></span>
                <?php }?>
                <span class="news-wrap">
                    <p><?php echo $rp->post_title?></p>
                    <span class="date"><?php echo get_the_time('F j, Y', $rp->ID)?></span>
                </span>  
                <span class="dropdown-box">
					<p class="title"><?php echo $rp->post_title?></p>
					<span class="date"><?php echo get_the_time('F j, Y', $rp->ID)?></span>
					<p class="text">
						<?php echo trim_string(strip_tags($rp->post_content), 90)?>
					</p>
					<a href="<?php echo get_permalink($rp->ID)?>" title="" style="display:none">Watch now</a>
				</span>
            </div>
		</li>
              <?php $n++;} }?>
    </ul>
    </div>
<?php }?>
</div>

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
                        $num = 8;
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
                     <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
									<p class="title"><?php echo $video['title']?></p>
									<span class="date"><?php echo $video['date']?></span>
									<p class="text">
										<?php echo trim_string(strip_tags($video['content']), 80)?>
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
				<a class="more-button" href="<?php echo site_url('/');?>category/video/" title="">More videos</a>
			</div>
			<!-- // Stop More video -->            
        </div>
    </div>
</div>

<?php
get_footer();
?>