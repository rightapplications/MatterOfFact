<?php
get_header(); 
?>

<div class="container about">
        <div class="row">
            <div class="col-lg-12">
        <?php
        // Start the Loop.
        while ( have_posts() ) : the_post();?>
                
                <h1><?php the_title();?></h1>                
                
                
        <?php endwhile;?>
        </div>
    </div>
</div>

<?php
get_footer();
?>