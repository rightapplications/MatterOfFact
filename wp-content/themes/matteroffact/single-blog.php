<?php
get_header(); 
?>

<?php //blog category
$blog = get_category_by_slug( 'blog' );
?>

<?php
        while ( have_posts() ) : the_post();
			$post_id = get_the_ID();
            $post_title = get_the_title();
			$post_content = get_the_content();
			$post_img = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
			$postCategories = get_the_category( $post->ID);
			foreach($postCategories as $cat){; 
				if($cat->slug != 'blog'){
					$catName = $cat->name;
					$catSlug = $cat->slug;
				}
			}
        endwhile;
?>

<section class="topic-section">

	<header class="header-section">
		<div class="hatch">	
			<div class="container">
				<div class="top-header-title"><a href="<?php echo site_url('/category/'.$blog->slug); ?>"><span class="white"><?php echo $blog->name?></span></a> / <a href="<?php echo site_url('/category/'.$catSlug); ?>"><?php echo $catName?></a></div>
				<h1><?php echo $post_title?></h1>
			</div>
		</div> 
	</header>
	
	<div class="about-variant-1"> 
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
					<?php if(!empty($post_img)){?>
					<div class="photo-about-v1">
							<img src="<?php echo $post_img?>" alt="<?php echo $post_title?>" />
					</div>
					<?php }?>
					<div class="data-topic">
						<?php the_date()?>
					</div>
					
					<p><?php echo $post_content?></p>
					
					<div class="next-v1">		
						<?php previous_post_link('<span>Next</span><div class="clearfix"></div><p>%link</p>','%title',true)?>
					</div>
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"></div>
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
					<div class="sidebar-1">
						<?php 
						$aTopics = get_sub_categories('blog'); //dump($aTopics);
						if(!empty($aTopics)){
						?>
						<div class="sm-left">
							<hgroup>Topics</hgroup>							
							<div class="sidebar-1-menu">
								<ul>
								<?php foreach($aTopics as $topic){?>
									<li<?php if($catSlug === $topic['slug']) echo ' class="active"'?>><a href="<?php echo site_url('/category/'.$topic['slug']); ?>" title=""><?php echo $topic['name']?></a></li>
								<?php }?>
								</ul>
							</div>						
						</div>
						<?php }?>
						
						<div class="sm-right">
							<hgroup>Latest</hgroup>							
							<div class="sidebar-1-menu">
							<?php
							$args = array(   
									'showposts'=>5,
									'category_name' => 'blog',
									'orderby' => 'published',
									'order' => 'DESC'       
							);
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) {
							?>
								<ul>
								<?php  while ( $query->have_posts() ) {
									$query->the_post();  
									?>
									<li>
										<span class="data-post"><?php echo get_the_time('F j, Y', $query->post->ID)?></span>
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