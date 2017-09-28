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

<section class="about-section stateofadditction-section">

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

										

					<?php the_content()?>

					

					

				</div>

				

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>

				

				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

					<div class="sidebar-1">

						<div class="">
							
							<div class="desktop-map">

								<hgroup>Where to watch our special</hgroup>
	
								<div class="map-1-sidebar">
	
									<a href="#<?php //echo site_url('/map/'); ?>" title="" data-toggle="modal" data-target="#mapModal">View Map <span>›</span></a>
	
									<!-- start Modal -->
	
									<div id="mapModal" class="modal fade" role="dialog">
	
										<div class="close-m1" data-dismiss="modal"><img src="<?php echo get_template_directory_uri(); ?>/images/close_1.png" alt="" /></div>
	
										<div class="modal-dialog">
	
											<div class="modal-content">
	
											<div class="modal-header">
	
													<hgroup>Where To Watch</hgroup>
	
												</div>
	
												<div class="modal-body">
	
													<?php echo do_shortcode('[put_wpgm id=3]')?>
	
												</div>
	
											</div>
	
										</div>
	
									</div>
	
									<script>
	
									jQuery("#mapModal").on("shown.bs.modal", function () {
	
									   jQuery(map3).data('wpgmp_maps').resize_map();
	
									});
	
									</script>
	
									<!-- stop Modal -->
	
								</div>
							
							</div>

							<hgroup>National coverage</hgroup>

							<?php if(!empty($page_meta['coverage_description'][0])){?>

							<div class="national-coverage-sidebar">

                                <?php echo $page_meta['coverage_description'][0]?>

                            </div>

							<?php }?>

							<div class="table-1-sidebar">

								<table>

							<?php 

							$args = array(   

									'showposts'=>-1,

									'category_name' => 'state-of-addiction',

									'meta_key' => 'location',

									'orderby' => 'meta_value',

									'order' => 'ASC'    

								);

							$query = new WP_Query( $args );

							if ( $query->have_posts() ) {

								while ( $query->have_posts() ) {

									$query->the_post();  

									$meta = get_post_meta($query->post->ID); 

								?>

									<tr>

                                        <td><?php echo $meta['location'][0]?></td>

                                        <td><a href="<?php echo $meta['link_url'][0]?>" title="<?php echo $meta['link_title'][0]?>" target="_blank"><?php echo array_shift(explode('/', $query->post->post_title))?><span>›</span></a></td>

                                    </tr>

								<?php }

							}

							wp_reset_postdata();

							?>

								 

								</table>

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