<?php
get_header(); 
?>
<script>
/*jQuery(window).load(function(){
    //alert(jQuery('.gm-style').children().first().children().eq(1).attr('style'));
    jQuery('.gm-style').children().first().children().eq(1).css('background-color', '#f8ca39');
    jQuery('.gm-style').children().first().children().eq(1).css('opacity',0.5);
});*/
</script>
<?php
        while ( have_posts() ) : the_post();
                $title = get_the_title();
        endwhile;
?>

<!-- || Start map -->
    <div class="map desktop">
        <div class="container-fluid">
            <div class="row">
				<?php echo do_shortcode('[put_wpgm id=2]')?>
            </div>
        </div>        
    </div>
	<!-- // Stop vmap -->

<div class="starred-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <h1 class="text-center"><?php echo $title;?></h1>
            </div>
        </div>
        <div class="show-times-block">
            <?php //the_content()?>
            <?php //stations
$args = array(   
        'showposts'=>-1,
        'category_name' => 'station',
		'meta_key' => 'location',
        'orderby' => 'meta_value',
        'order' => 'ASC'        
    ); 
$query = new WP_Query( $args );
if ( $query->have_posts() ) {?>

    <?php while ( $query->have_posts() ) {
        $query->the_post();
        $meta = get_post_meta($query->post->ID); ?>
        <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="text-1"><?php echo $meta['location'][0]?></div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="text-2"><?php echo $post->post_title?></div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="text-3"><?php echo $post->post_content?></div>
        </div>
        </div>
    <?php }?>
<?php }?>
        </div>
    </div>
</div>


<?php
get_footer();
?>