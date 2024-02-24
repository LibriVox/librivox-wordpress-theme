<?php


if ( ! isset( $content_width ) )
	$content_width  = '565';

/***************************************************************
*
* Load the Theme Options Page that lets users control the social media icons at the top
* Load Custom Post Types
* Load Conditional Mobile scripts
*
***************************************************************/
require_once ( get_template_directory() . '/inc/theme-options.php' );
require_once ( get_template_directory() . '/inc/cpt.php' );
require_once ( get_template_directory() . '/inc/conditional-mobile.php' );


add_theme_support('automatic-feed-links');


/***************************************************************
*
* Librivox Catalog Feeds
*
***************************************************************/


define('LIBRIVOX_CATALOG_URL', 'https://librivox.org/'); //replace w/  get_bloginfo('url'); 
define('LIBRIVOX_CATALOG_SEARCH', 'https://librivox.org/search'); //replace w/  get_bloginfo('url');
define('LIBRIVOX_LATEST_RELEASES', 'https://librivox.org/api/latest_releases?format=json');
define('LIBRIVOX_STATISTICS', 'https://librivox.org/api/statistics?format=json');




/***************************************************************
*
* Add Menu Support
*
***************************************************************/


function librivox_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Top Menu' ),
            'secondary-menu' => __( 'Main Menu' )
        )
    );
}
add_action( 'init', 'librivox_menus' );

/***************************************************************
*
* Thumbnail support
*
***************************************************************/

add_theme_support( 'post-thumbnails' );  
set_post_thumbnail_size( 670, 370, true ); // 670 pixels wide by ??? pixels tall, hard crop mode
add_image_size( 'home-icons', 80, 80, true );

/***************************************************************
*
* Enqueue Scripts
*
***************************************************************/

function librivox_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );	
	wp_enqueue_script( 'small-meu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), 'v1', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'librivox_scripts' );

/***************************************************************
*
* Register widgetized area and update sidebar with default widgets
*
***************************************************************/
function librivox_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Sidebar', 'librivox' ),
		'id' => 'primary',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array (
		'name' => __( 'Footer', 'librivox' ),
		'id' => 'footer',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	

}
add_action( 'init', 'librivox_widgets_init' );


/***************************************************************
*
* Add Custom Login Graphic
*
***************************************************************/

function custom_login_logo() {
    echo '<style type="text/css">
        .login h1 a {
        	background-image:url('.get_bloginfo('template_directory').'/images/librivox-logo.png) !important;
        	background-size:180px 37px;
        	height:48px;
        }
    </style>';
}
add_action('login_head', 'custom_login_logo');

/***************************************************************
*
* Change login logo URL
*
***************************************************************/
function custom_loginlogo_url($url) {
    return get_bloginfo('url'); // changes the url link from wordpress.org to your blog or website's url
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );


/***************************************************************
*
* Styling for the custom post type icon
*
***************************************************************/

function wpt_portfolio_icons() {
    ?>
    <style type="text/css" media="screen">
     	.icon32.icon32-posts-homepage_content{
            background: url(<?php echo get_template_directory_uri(); ?>/images/icon_homepage_admin.png) !important;
        }

    </style>
    
<?php }
add_action( 'admin_head', 'wpt_portfolio_icons' );

 /* * *************************************************************
 *
 * Hide ACF menu item from the admin menu
 *
 * ************************************************************* */
 
function hide_admin_menu() {
	global $current_user;
	get_currentuserinfo();
 
	if($current_user->user_login != 'sonia') {
		echo '<style type="text/css">#toplevel_page_edit-post_type-acf{display:none;}</style>';
	}
}
 
add_action('admin_head', 'hide_admin_menu');  

// Librivox Catalog Feed items
function format_results($items)
{
	$html = '';
	foreach ($items as $key => $item) {
		$html .= format_item($item);
	}
	return $html;
}

// Lets try to re-use as much formatting code from catalog as possible such as
// create_full_title and format_authors.
require_once(ABSPATH . '../catalog/application/helpers/previewer_helper.php');
function base_url() { return LIBRIVOX_CATALOG_URL; }

// This function mimics title_blade.php from catalog (it would be nice if we could
// also re-use that code directly somehow so they stay consistent).
function format_item($item)
{
	$image = empty($item['coverart_thumbnail']) ? LIBRIVOX_CATALOG_URL . 'images/book-cover-default-65x65.gif' : $item['coverart_thumbnail'];
	$html = '<li class="catalog-result">';
	$html .= '<a href="' . $item['url_librivox'] . '" class="book-cover"><img src="'. $image .'" alt="book-cover-65x65" width="65" height="65" /></a>';
	$html .= '<div class="result-data">';
	$html .= '<h3><a href="' . $item['url_librivox'] .' ">' . create_full_title($item) . '</a></h3>';
	$html .= '<p class="book-author"> ' . format_authors($item['authors'], FMT_AUTH_YEARS|FMT_AUTH_HTML|FMT_AUTH_LINK, 2) . '</p>';
	$html .= '<p class="book-meta">' . 'Complete' . ' | ' . ucwords($item['project_type']) . ' | ' . $item['language'] . '</p>';
	$html .= '</div></li>';
	return $html;
}

add_action('phpmailer_init', 'smtp_mailer');
function smtp_mailer($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = SMTP_HOST;
    $phpmailer->SMTPAuth = SMTP_AUTH;
    $phpmailer->Port = SMTP_PORT;
    $phpmailer->Username = SMTP_USERNAME;
    $phpmailer->Password = SMTP_PASSWORD;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->From = SMTP_FROM_EMAIL;
    $phpmailer->FromName = SMTP_FROM_NAME;
}
