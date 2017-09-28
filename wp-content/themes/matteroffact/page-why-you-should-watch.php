<?php
get_header(); 
?>

<?php
        while ( have_posts() ) : the_post();
			$page_id = get_the_ID();
            $title = get_the_title();
			$page_img = wp_get_attachment_url( get_post_thumbnail_id($page_id) );
			$page_meta = get_post_meta($page_id);
        endwhile;
?>

<section class="about-section">

	<header class="header-section">
		<div class="hatch">	
			<div class="container">
				<h1><?php echo !empty($page_meta['menu_title'][0]) ? $page_meta['menu_title'][0] : $title?></h1>
			</div>
		</div> 
	</header>
	
	<div class="about-variant-1">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					
					<?php if(!empty($page_meta['video_code'][0])){?>
					<div class="photo-about-v1 video">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe width="100%" src="https://www.youtube.com/embed/<?php echo $page_meta['video_code'][0]?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>     
						</div>                                
					</div>					
					<?php }elseif(!empty($page_img)){?>
					<div class="photo-about-v1">
							<img src="<?php echo $page_img?>" alt="" />
					</div>
					<?php }?>
					
					<?php the_content()?>
					
					<div class="next-v1">
						<span>Next</span>
						<div class="clearfix"></div>
						<p><a href="<?php echo site_url('/about-soledad'); ?>" title="">ABOUT SOLEDAD</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<?php
get_footer();
?>