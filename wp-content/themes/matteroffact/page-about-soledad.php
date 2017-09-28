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





<?php //get about the show page

$aboutPage = get_page_by_path('about');

$about_page_meta = get_post_meta($aboutPage->ID);

$about_page_logo = wp_get_attachment_url( $about_page_meta['logo'][0] );

?>



<?php //get Why You Should Watch

$watchPage = get_page_by_path('why-you-should-watch');

$watch_page_meta = get_post_meta($watchPage->ID);

$watch_page_img = wp_get_attachment_url( get_post_thumbnail_id($watchPage->ID) );

?>



<section class="about-section">

	<header class="header-section">

		<div class="hatch">	

			<div class="container">

				<h1><?php echo $title?></h1>

			</div>

		</div> 

	</header>

	

	<div class="about-variant-1">

		<div class="container">

			<div class="row">

				

				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

					<?php if(!empty($page_img)){?>

					<div class="photo-about-v1">

							<img src="<?php echo $page_img?>" alt="" />

					</div>

					<?php }?>

					

					<?php if(!empty($page_meta['subheader'][0])){?>

					<div class="sub-photo-v1">

							<?php echo $page_meta['subheader'][0]?>

					</div>

					<?php }?>

					

					<?php the_content()?>

					

					<div class="next-v1">

							<span>Next</span>

							<div class="clearfix"></div>

							<p><a href="<?php echo site_url('/team'); ?>" title="">MEET THE TEAM</a></p>

					</div>

						

				</div>

				

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>

				

				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

					<div class="sidebar-1">


						<div class="sm-left">
						
							<hgroup>ABOUT</hgroup>
							<?php if ( has_nav_menu( 'about' ) ){ ?>
							<div class="sidebar-1-menu">
								<?php
								wp_nav_menu( array(
									'theme_location' => 'about',
									'depth'          => 1,
									'link_before'    => '',
									'link_after'     => '',
								) );
								?>								
							</div>
							<?php }?>
							<?php if(!empty($watchPage->post_name)){?>
							<div class="sidebar-1-menu">
								<div class="logo-v1 watch_img">
							<?php if(!empty($watch_page_img)){?>
									<a href="<?php echo get_permalink($watchPage->ID)?>" title=""><img src="<?php echo $watch_page_img?>" alt="" /></a>
							<?php }?>
									<p><a href="<?php echo get_permalink($watchPage->ID)?>" title=""><?php echo (!empty($watch_page_meta['menu_title'][0]) ? $watch_page_meta['menu_title'][0] : $watchPage->post_title)?></a></p>
								</div>
							</div>
							<?php }?>
							<?php if(!empty($about_page_logo)){?>
							<div class="logo-v1">
								<?php if(!empty($about_page_meta['logo_link'][0])){?>
								<a href="<?php echo $about_page_meta['logo_link'][0]?>" title="" target="_blank"><img src="<?php echo $about_page_logo?>" alt="" /></a>
								<?php }else{?>
								<img src="<?php echo $about_page_logo?>" alt="" />
								<?php }?>
							</div>
							<?php }?>
						</div>
						
						<?php if(!empty($about_page_meta['twitter_widget_code'][0])){?>
						
						<div class="sm-right">
							<hgroup>FOLLOW US ON TWITTER</hgroup>
							<div class="twitter-block">
							<?php echo $about_page_meta['twitter_widget_code'][0]?>
							</div>
							<div class="more"><a href="<?php echo $about_page_meta['twitter_link'][0]?>" title="" target="_blank">More</a></div>
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