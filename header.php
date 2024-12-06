<!DOCTYPE html> 
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?> <?php if ( !wp_title('', false, 'left') ) { ?> | <?php bloginfo('description'); ?> <?php } ?></title>

<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
      </script>
    <![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class('wp'); ?> >

    <ul class="assistive-text">
      <li><a href="#sub-menu">Skip to navigation</a></li>
      <li><a href="#main-content">Skip to front page content</a></li>
      <li><a href="#secondary-content">Skip to secondary content</a></li>
      <li><a href="#footer">Skip to footer</a></li>
    </ul>
  

<section class="header-wrap">
		<header class="site-header">
		
			<!-- Site title/Logo and tagline -->
			<hgroup class="logo-wrap">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'h4'; ?>
				<<?php echo $heading_tag; ?> class="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php bloginfo('template_url'); ?>/images/librivox-logo.png" alt="librivox-logo" width="180" height="37"><span class="assistive-text">Librivox</span></a></<?php echo $heading_tag; ?>>				
				<h3 class="tagline"><?php bloginfo( 'description' ); ?></h3>
			</hgroup>  
				
			<!-- Sub menu -->
			<nav class="sub-menu" id="sub-menu">
				<h1 class="assistive-text icon-fontawesome-webfont"><span>Menu</span></h1>
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu','container' => false,  'menu_class' => 'sub-menu-list' ) ); ?>					
			</nav><!-- end sub-menu -->   

 
			<!-- Search Form -->
		<div class="search-wrap">		
			 <form action="<?= LIBRIVOX_CATALOG_SEARCH;  ?>" role="search" id="searchform" method="get" class="searchform">
				 <label class="assistive-text" for="s">Search Librivox</label>
				 <input placeholder="Search by Author, Title or Reader" id="q" name="q" class="field" />
				 <input type="submit" value="<?php _e('Search'); ?>" id="searchsubmit"  class="submit" />
			</form>	
			<a href="<?= LIBRIVOX_CATALOG_SEARCH;  ?>/advanced_search" class="advanced-search"> Advanced search</a>	
		</div>	


		<script type="text/javascript">
			document.getElementById('searchsubmit').onclick=function(e)
			{
				e.preventDefault();
				var q = document.getElementById('q').value;
				window.location.href = "<?= LIBRIVOX_CATALOG_SEARCH;  ?>/?search_form=get_results&q=" + encodeURIComponent(q);
			}
			
		</script>



  	 </header> <!-- end #header-->
      
</section> <!-- end #header-wrap-->