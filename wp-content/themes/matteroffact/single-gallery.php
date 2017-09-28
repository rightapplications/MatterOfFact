<?php
get_header(); 
?>

<?php //blog category
$gallery = get_category_by_slug( 'gallery' );
?>

<?php
        while ( have_posts() ) : the_post();
			$post_id = get_the_ID();
            $post_title = get_the_title();
			$post_content = get_the_content();
			$post_img = wp_get_attachment_url( get_post_thumbnail_id($post_id) );			
        endwhile;
?>

<section class="topic-section">

	<header class="header-section">
		<div class="hatch">	
			<div class="container">
				<h1><?php echo $post_title?></h1>
			</div>
		</div> 
	</header>
	
	<div class="about-variant-1 gallery-post"> 
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
					<?php if(!empty($post_img)){?>
					<div class="photo-about-v1">
							<img src="<?php echo $post_img?>" alt="<?php echo $post_title?>" />
					</div>
					<?php }?>
					
					<p><?php the_content()?></p>
					
						<div class="next-v1">
							<div class="clearfix">&nbsp;</div>
							<p><a title="" href="<?php echo site_url('/wall-of-remembrance/'); ?>">&lt; Wall of Remembrance</a></p>
						</div>
					
					<?php /*<div class="next-v1">		
						<?php previous_post_link('<span>Next</span><div class="clearfix"></div><p>%link</p>','%title',true)?>
					</div>*/?>
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"></div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
					<div class="sidebar-1">
						
						<div class="sm-right">
							<hgroup>#StateOfAddiction</hgroup>							
							<div class="sidebar-1-menu">
							<?php
							$args = array(   
									'showposts'=>-1,
									'category_name' => 'gallery',
									'orderby' => 'published',
									'order' => 'ASC'       
							);
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) {
							?>
								<ul>
								<?php  while ( $query->have_posts() ) {
									$query->the_post();  
									?>
									<li<?php if($query->post->ID === $post_id) echo ' class="active"'?>>
										<a href="<?php echo get_permalink($query->post->ID)?>" title=""><?php echo $query->post->post_title?></a>
									</li>
								<?php }?>									
								</ul>
							<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</section>

<?php
get_footer();
?>