<?php
get_header(); 
?>

<?php
        while ( have_posts() ) : the_post();
                $title = get_the_title();
        endwhile;
?>
<script>
jQuery(document).ready(function(){
    jQuery('.show-tick').change(function(){
        var valText = jQuery(this).val();
        if(valText === 'Other'){
            jQuery('#other').removeClass('hidden');
        }else{
            jQuery('#other').addClass('hidden');
            jQuery('#subject').val(valText);
        }
    });
    jQuery('#other').find('input').change(function(){
        jQuery('#subject').val(jQuery(this).val());
    });
});
</script>
<!-- start New 09.20.2016 -->
	<div class="starred-bg">	
		<div class="container contact-us">
			<div class="row">
				<div class="col-lg-12">
					<h1><?php echo $title;?></h1>
					<?php the_content()?>
				</div>
			</div>
		</div>
	</div>
	<!-- stop New 09.20.2016 -->

<?php
get_footer();
?>