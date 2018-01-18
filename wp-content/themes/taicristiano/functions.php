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

if (!function_exists('taicristano_thumbnail')) {
  	function taicristano_thumbnail($size) {
	    // Chỉ hiển thumbnail với post không có mật khẩu
	    if (!is_single() &&  has_post_thumbnail()  && !post_password_required() || has_post_format( 'image' ) ) : ?>
	      	<figure class="post-thumbnail"><?php the_post_thumbnail( $size ); ?></figure><?php
	    endif;
  	}
}

if (!function_exists('taicristano_entry_header') ) {
  	function taicristano_entry_header() {
	    if ( is_single() ) : ?>
	      	<h1 class="entry-title">
	        	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	          	<?php the_title(); ?>
	        	</a>
	      	</h1>
	    <?php else : ?>
	      	<h2 class="entry-title">
	        	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	          	<?php the_title(); ?>
	        	</a>
	      	</h2><?php
	    endif;
  	}
}

if( ! function_exists( 'taicristano_entry_meta' ) ) {
  	function taicristano_entry_meta() {
	    if ( ! is_page() ) :
	      	echo '<div class="entry-meta">';
	        // Hiển thị tên tác giả, tên category và ngày tháng đăng bài
	        printf( __('<span class="author">Posted by %1$s</span>', 'taicristano'), get_the_author() );
	 
	        printf( __('<span class="date-published"> at %1$s</span>', 'taicristano'), get_the_date() );
	 
	        printf( __('<span class="category"> in %1$s</span>', 'taicristano'), get_the_category_list( ', ' ) );
	 
	        // Hiển thị số đếm lượt bình luận
	        if ( comments_open() ) :
	          	echo ' <span class="meta-reply">';
		            comments_popup_link(
		              __('Leave a comment', 'taicristano'),
		              __('One comment', 'taicristano'),
		              __('% comments', 'taicristano'),
		              __('Read all comments', 'taicristano')
		             );
	          	echo '</span>';
	        endif;
	      	echo '</div>';
	    endif;
	}
}

function taicristano_readmore() {
  return '...<a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'taicristano') . '</a>';
}
add_filter('excerpt_more', 'taicristano_readmore');

if (!function_exists('taicristano_entry_content')) {
  	function taicristano_entry_content() {
	    if (!is_single()) :
	    	the_content( sprintf(
				__( 'Continue reading %s', 'taicristano' ),
				get_the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
	      	// the_excerpt();
	    else :
	      	the_content();
	      	/*
	       	* Code hiển thị phân trang trong post type
	       	*/
	      	$link_pages = array(
		        'before' => __('<p>Page:', 'taicristano'),
		        'after' => '</p>',
		        'nextpagelink'     => __( 'Next page', 'taicristano' ),
		        'previouspagelink' => __( 'Previous page', 'taicristano' )
	      	);
	      	wp_link_pages( $link_pages );
	    endif;
  	}
}

if (!function_exists('thachpham_entry_tag')) {
  	function thachpham_entry_tag() {
	    if (has_tag()) :
	      	echo '<div class="entry-tag">';
	      	printf( __('Tagged in %1$s', 'thachpham'), get_the_tag_list('', ', '));
	      	echo '</div>';
	    endif;
  	}
}