<?php

define( 'THEME_URL', get_stylesheet_directory() );
define( 'CORE', THEME_URL . '/core' );
define( 'LANG', THEME_URL . '/languages' );

require_once(CORE . '/init.php');
if (!isset($content_width)) {
   $content_width = 620;
}

if (! function_exists('taicristiano_theme_setup')) {
	function taicristiano_theme_setup() {
		load_theme_textdomain('taicristano', LANG);
		//add ress feed link
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_theme_support('title-tag');
		add_theme_support('post-formats',
		[
			'image',
			'video',
			'gallery',
			'quote',
			'link'
		]);
		$defaultBackground = array(
		   'default-color' => '#e8e8e8',
		);
		add_theme_support( 'custom-background', $defaultBackground );
		register_nav_menu ( 'primary-menu', __('Primary Menu', 'taicristano') );

		$sidebar = array(
			'name'         => __('Main Sidebar', 'taicristano'),
			'id'           => 'main-sidebar',
			'description'  => 'Main sidebar for Taicristano theme',
			'class'        => 'main-sidebar',
			'before_title' => '<h3 class="widgettitle">',
			'after_title'  => '</h3>'
		);
		register_sidebar( $sidebar );
	}
}
add_action('init', 'taicristiano_theme_setup');

if (!function_exists('taicristiano_logo')) {
	function taicristiano_logo() {?>
		<div class="logo">
			<div class="site-name">
				<?php if(is_home()) {
					printf(
	                	'<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
	            		get_bloginfo( 'url' ),
	            		get_bloginfo( 'description' ),
	            		get_bloginfo( 'sitename' )
	          		);
				} else {
					printf(
			            '<p><a href="%1$s" title="%2$s">%3$s</a></p>',
			            get_bloginfo( 'url' ),
			            get_bloginfo( 'description' ),
			            get_bloginfo( 'sitename' )
		            );
				} ?>
			</div>
			<div class="stie-description">
				<?php bloginfo( 'description' ); ?>
			</div>
		</div>
	<?php }
}


if(!function_exists('taicristano_menu')) {
	function taicristiano_menu($slug) {
		$menu = array(
			'theme_location'  => $slug,
			'container'       => 'nav',
			'container_class' => $slug,
	    );
	    wp_nav_menu($menu);
	}
}

if (!function_exists('taicristano_pagination')) {
	function taicristano_pagination() {
	    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	      	return '';
	    }
	?>
 
  	<nav class="pagination" role="navigation">
    	<?php if ( get_next_post_link() ) : ?>
      	<div class="prev"><?php next_posts_link( __('Older Posts', 'thachpham') ); ?></div>
    	<?php endif; ?>
 
    	<?php if ( get_previous_post_link() ) : ?>
      	<div class="next"><?php previous_posts_link( __('Newer Posts', 'thachpham') ); ?></div>
    	<?php endif; ?>
  		</nav><?php
  	}
}