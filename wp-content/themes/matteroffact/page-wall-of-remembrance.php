<?php
get_header(); 
?>

<div class="starred-bg"> 
<div class="container about gallery">
        <div class="row">
            <div class="col-lg-12">
<?php
        // Start the Loop.
        while ( have_posts() ) : the_post();
                $title = get_the_title();
                $meta = get_post_meta($post->ID);
                $img =wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                ?>
                
                <h1><?php the_title();?></h1>    
<?php if($img){?>
                <div class="page-img">
                    <img src="<?php echo $img?>" alt=""/>
                </div>
<?php }?>
                <div class="subheader">
				<?php echo $meta['subheader'][0]?>
				</div>

                <?php the_content();?>

                
<?php endwhile;?>
<script>
	jQuery(document).ready(function(){
		setTimeout(function(){
			jQuery('#npl_content').prepend('<div class="image-title"><?php echo $title?></div>');
		}, 1000);
		jQuery('.nextgen_pro_lightbox').each(function(){
			var img = jQuery(this);
			img.click(function(){
				setTimeout(function(){
					jQuery('#npl_content').prepend('<div class="image-title"><?php echo $title?></div>');
					jQuery('.image-title').css('left', '0');
				}, 1000);
				return false;
			});
		});
			
	});
</script>
        </div>
    </div>
</div>
</div>
<?php
get_footer();
?>