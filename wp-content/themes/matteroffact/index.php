<?php
get_header(); 
?>
<div class="starred-bg"> 
<div class="container about">
        <div class="row">
            <div class="col-lg-12">
<?php
        // Start the Loop.
        while ( have_posts() ) : the_post();
                $title = get_the_title();
                //$meta = get_post_meta($post->ID);
                $img =wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                ?>
                
                <h1><?php the_title();?></h1>    
<?php if($img){?>
                <div class="page-img">
                    <img src="<?php echo $img?>" alt=""/>
                </div>
<?php }?>
                
                <?php the_content();?>
                
<?php endwhile;?>
        </div>
    </div>
</div>
</div>
<?php
get_footer();
?>