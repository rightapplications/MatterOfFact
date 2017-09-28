<?php

get_header(); 

?>



<?php

        while ( have_posts() ) : the_post();

            $title = get_the_title();			

        endwhile;

?>



<?php //get about the show page

$aboutPage = get_page_by_path('about');

$about_page_meta = get_post_meta($aboutPage->ID);

$about_page_logo = wp_get_attachment_url( $about_page_meta['logo'][0] );

?>



<section class="team-section">



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

					

					<!-- start team-content -->

					<div class="team-content">

					

					<?php  $aLocations = get_sub_categories('team');

						if(!empty($aLocations)){

							foreach($aLocations as $location){?>

								<?php if($location['slug'] != 'main'){?>

						<div class="location-team">

							<?php echo $location['name']?>

						</div>

						        <?php }?>

								<?php 

								$args = array(   

									'showposts'=>-1,

									'category_name' => $location['slug']       

								);

								$query = new WP_Query( $args );

								if ( $query->have_posts() ) {

									while ( $query->have_posts() ) {

										$query->the_post();  

										$meta = get_post_meta($query->post->ID); 

										$img =wp_get_attachment_url( get_post_thumbnail_id($query->post->ID) );

										?>

						<!-- start team-block repeat -->

						<div class="team-block">

							<header><?php echo $query->post->post_title?></header>

							<div class="sub-team-header"><?php echo $meta['position'][0]?></div>

							<div class="description-team">

							<?php if(!empty($img)){?>

								<img src="<?php echo $img?>" alt="<?php echo $query->post->post_title?>" />

							<?php }?>

								<p>

									<?php echo $query->post->post_content?>

								</p>

							</div>

						</div>

						<!-- stop team-block repeat -->

										<?php

								    }

								}

								wp_reset_postdata();

							}

						}

					?>

					

					</div>

					<!-- stop team-content -->

					

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