<?php
get_header(); 
?>

<?php
$mySearch =& new WP_Query("s=$s&showposts=-1");
$num = $mySearch->post_count;
?>
<div class="starred-bg">
    <div class="container content">
        <div class="row">
            <div class="col-lg-12">
                <h1>Search results for "<?php echo $s?>"</h1>
            </div>
        </div>
        <div class="row">
    <?php if($num > 0){?>
                   
    <ul class="news">
	<?php while ( have_posts() ) : the_post();
        $img =wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		?>
		<li class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <div>
                <a href="<?php echo get_permalink($post->ID)?>">
                    <?php if(!empty($img)){?>
                    <span class="news-img" style="background:url(<?php echo $img?>) no-repeat 50% 50%"></span>
                    <?php }?>
                    <span class="news-wrap">
                        <p><?php echo trim_string($post->post_title, 72)?></p>
                        <span class="date"><?php echo get_the_date()?></span>
                    </span>
                </a>		
            </div>
		</li>
    <?php endwhile;?>
    </ul>
    <?php }else{?>
    <div style="text-align:center;">
    <h3>Your search returned no results</h3>
    </div>
    <?php }?>
<?php
wp_reset_postdata();
?>
        </div>
    </div>
</div>
<?php
get_footer();
?>