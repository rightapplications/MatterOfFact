    <footer class="footer">
   		<div class="container">
        <a name="subscribe" />
   			<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   					<a href="#" class="footer-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-footer.png" width="217" height="31" alt=""></a>
   				</div>   				
   					
                <?php if ( is_active_sidebar( 'footer' ) ) : ?>
                    <?php dynamic_sidebar( 'footer' ); ?>
                <?php endif ?>
   				
   			</div>
   			<div class="row">
   				<div class="col-lg-12">
   					<div class="copy">
                        <?php $cd = getdate()?>
   						<p>© <?php echo $cd['year']?> Hearst Television. All Rights Reserved.</p>
   					</div>
   				</div>
   			</div>
   		</div>
    </footer>
<?php wp_footer(); ?>
</body>
</html>