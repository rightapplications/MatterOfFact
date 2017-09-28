<?php
get_header(); 
?>

<?php //blog category
$blog = get_category_by_slug( 'blog' );
?>

<?php
$category = get_category(get_query_var('cat'));
$cat_slug = $category->slug;
?>

<?php //get about the show page
$aboutPage = get_page_by_path('about');
$about_page_meta = get_post_meta($aboutPage->ID);
$about_page_logo = wp_get_attachment_url( $about_page_meta['logo'][0] );
?>

<section class="blog-section">
	
	<header class="header-section">
		<div class="hatch">	
			<div class="container">
				<h1><?php echo $blog->name?></h1>
			</div>
		</div> 
	</header>
	
	<div class="about-variant-1"> 
		<div class="container">
			<div class="row">
			
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="blog-content">
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post();
								$postCategories = get_the_category( $post->ID);
								foreach($postCategories as $cat){; 
									if($cat->slug != 'blog'){
										$catName = $cat->name;
									}
								}
								$img =wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
								$link = get_permalink($post->ID)
							?>
							<div class="blog-block">
							<div class="sup-blog-header"><?php echo $catName?></div>
							<header><?php the_title()?></header>
							<?php if(!empty($img)){?>
							<div class="blog-pic">
								<img src="<?php echo $img?>" alt="<?php echo $post->post_title?>" />
							</div>
							<?php }?>
							<div class="description-blog">
								<p>
									<?php the_excerpt()?>
								</p>
							</div>
							<div class="more"><a href="<?php echo $link?>" title="">More</a></div>
						</div>
							<?php endwhile;?>
						<?php endif;?>
					</div>
					
					<?php if( get_next_posts_link() ) :?>
					<div class="older-post">
						<?php next_posts_link( 'Older posts' );?>
					</div>
					<?php endif; ?>
						
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
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
									<li<?php if($cat_slug === $topic['slug']) echo ' class="active"'?>><a href="<?php echo site_url('/category/'.$topic['slug']); ?>" title=""><?php echo $topic['name']?></a></li>
								<?php }?>
								</ul>
							</div>						
						</div>
						<?php }?>
					
						<?php if(!empty($about_page_meta['twitter_widget_code'][0])){?>
						<div class="sm-right">						
							<hgroup>FOLLOW US ON TWITTER</hgroup>							
							<div class="twitter-block">
								<?php echo $about_page_meta['twitter_widget_code'][0]?>
							</div>							
							<div class="more"><a href="<?php echo $page_meta['twitter_link'][0]?>" title="" target="_blank">More</a></div>						
						</div>
						<?php }?>
					
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
</section>

<?php
get_footer();
?>