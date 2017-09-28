<?php
get_header(); 
?>

<?php
$all = @$wp->query_vars['display'] == 'all' ? true : false;
?>

<div class="starred-bg">
    <div class="container">
    
        <div class="row">
            <div class="col-lg-12">
                <?php while ( have_posts() ) : the_post();?>   
                
                <h1 class="text-center"><?php the_title();?></h1>               
                
                <?php endwhile;?>

            </div>
        </div>
        
        <?php /*
        <!-- || Start Guests list -->
		<div class="guests-list">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<ul>
							<li<?php if(!$all) echo ' class="active"'?>><a href="<?php echo site_url('/'); ?>guests/" title="">Recent appearances</a></li>
							<li<?php if($all) echo ' class="active"'?>><a href="<?php echo site_url('/'); ?>guests/all" title="">In Alphabetical order</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- || Start Guests list -->
        */?>
        
        <?php
        $aGuests = get_guests('', 'term_id', 'DESC');
        
        ?>
        <!-- || Start Guests -->
        <div class="row">
        <?php if(!empty($aGuests)){
			//split name
			$aGuestTemp = array();
			foreach($aGuests as $guest){
				$aGT = array();
				$aName = explode(' ', $guest->name);
				$firstName = array_shift($aName);
				$lastName = implode(' ', $aName);
				$aGT['firstname'] = $firstName;
				$aGT['lastname'] = $lastName;
				$aGT['name'] = $guest->name;
				if (function_exists('z_taxonomy_image_url')){
                    $aGT['img'] = z_taxonomy_image_url($guest->term_id, 'thumbnail');                    
                }else{
					$aGT['img'] = '';
				}				
				$aGT['description'] = $guest->description;
				$aGT['count'] = $guest->count;
				$aGT['slug'] = $guest->slug;
				$aGuestTemp[] = $aGT;
			}
			$aGuestTemp = sort_array($aGuestTemp,'lastname','ASC');
			unset($aGuests);
			?>
            <?php foreach($aGuestTemp as $guest){
                //$cat_meta = get_option("category_".$guest->cat_ID);
                //$status = $cat_meta['status']; 
                //if(!$all and $cat_meta['status'] != 'recent'){
                    //continue;
                //}
                ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">            
				<div class="guests-item">                
					<div class="guests-item-photo">
                        <div class="guests-item-photo-table">
                        <?php if(!empty($guest['img'])){?>
                            <span><img src="<?php echo $guest['img'];?>" alt="" /></span>
                        <?php }?>
                        </div>
					</div>                
					<div class="guests-item-title">
						<?php echo $guest['name']?>
					</div>
					<div class="guests-item-text">
						<?php echo $guest['description']?>
					</div>
					<?php if($guest['count']){?>
						<a href="<?php echo site_url('/');?>category/<?php echo $guest['slug']?>" title="">Videos</a>
                    <?php }?>
				</div>
			</div>
            <?php }?>
        <?php }
		unset($aGuestTemp);
		?>
            
        </div>
        <!-- // Stop news -->
    
    </div>
</div>

<?php
get_footer();
?>