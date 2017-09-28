<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '', true, '' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- Web Fonts -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->   
    <link rel='stylesheet' id='main-style'  href='<?php echo get_stylesheet_uri(); ?>' type='text/css' media='all' />
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon" />
    <!--[if IE]><script src="<?php echo get_template_directory_uri(); ?>/js/excanvas.compiled.js" type="text/javascript"></script><![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
    <script>
      
        jQuery(document).ready(function(){
            jQuery('.mobileTabSwitcher').each(function(){
                jQuery(this).change(function(){
                    jQuery('#switcher-'+jQuery(this).val()).click();
                });
            });
        });
	</script>
    <script>
jQuery(document).ready(function(){
    jQuery('.news').on( 'click', '.dropdown-box', function(){
        var link = jQuery(this).find('a').attr('href');
        parent.location = link;
    });
});
</script>
	<script>
		(function($) {
		$(function() {             
             if(isMobile.iPhone()){   
                $('.jq-selectbox').css('overflow', 'hidden');
                $('.jq-selectbox').find('.dropdown').css('visibility','hidden');
             }
		})
		})(jQuery)
	</script>
</head>
<body <?php body_class(); ?>> 
<?php 
$aTopMenu = make_menu( 'Main Menu');
$category = get_category( get_query_var( 'cat' ) ); 
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
$season = get_query_var( 'season' );
/*
dump($post);
$tags = get_the_tags();
dump($category);
dump($tags);*/
?>
    <div class="header">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo site_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-top.png" width="280" height="41" alt=""></a>
            <nav class="nav" id="nav">
                <?php if ( is_active_sidebar( 'header' ) ) : ?>
                    <?php dynamic_sidebar( 'header' ); ?>
                <?php endif ?>
                <form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
                    <input type="text" name="s" value="<?php echo $s?>" placeholder="Search"/>
                    <button onclick="document.getElementById('searchform').submit();"><span class="glyphicon glyphicon-search"></span></button>
                </form>
                <?php if(!empty($aTopMenu)){?>
                <ul id="menu-main-menu" class="navbar-nav navbar-right">

                    <?php foreach($aTopMenu as $mnu){?>
					<li 
                        id="menu-item-<?php echo $mnu['main']->ID?>" 
                        class="<?php if(isset($mnu['submenu'])){?>dropdown <?php }?>
                        menu-item menu-item-type-taxonomy menu-item-object-category menu-item-<?php echo $mnu['main']->ID?> 
                        <?php if(($mnu['main']->object_id == $post->ID 
                                 or $mnu['main']->object_id == $category->cat_ID
                                 or $mnu['main']->object_id == $category->parent
                                 or ($mnu['main']->object == 'category' and  strpos($current_url, 'tag'))
                                 ) and $post->post_name != 'home') echo 'current-menu-item'?>">

						<a href="<?php echo $mnu['main']->url?>" <?php if(isset($mnu['submenu'])){?>class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"<?php }?>><?php echo $mnu['main']->title?></a>
						<?php if(isset($mnu['submenu'])){?>
                        <ul class="dropdown-menu">
                        <?php foreach($mnu['submenu'] as $submnu){?>
							<li<?php if(!empty($season) and $submnu->title == 'Season '.$season){?> class="active"<?php }?>><a href="<?php echo $submnu->url?>"><?php echo $submnu->title?></a></li>
                        <?php }?>
						</ul>
						<div class="clearfix"></div>
                        <?php }?>
					</li>
                    <?php }?>
				</ul> 
                <?php }?>
                <?php /*wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'navbar-nav navbar-right' ) );*/ ?>  

            </nav>
            <div class="menu-wrp">
                <a href="#" data-spy="affix" data-offset-top="20" data-offset-bottom="0" class="nav-opener" data-burger-menu-id="nav"><span class="lt"></span><span class="lc"></span><span class="lb"></span></a>
            </div>
        </div>               
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>