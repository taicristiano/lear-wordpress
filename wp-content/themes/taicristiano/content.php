<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-thumbnail">
	   <?php taicristano_thumbnail('thumbnail'); ?>
	</div>
    <header class="entry-header">
		<?php taicristano_entry_header(); ?>
		<?php taicristano_entry_meta(); ?>
    </header>
    <div class="entry-content">
		<?php taicristano_entry_content(); ?>
        <?php ( is_single() ? taicristano_entry_tag() : '' ); ?>
    </div>
</article>
