<?php
/**
 * The template used for displaying full width page content in page.php
 *
 * @package commercegurus
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'factory' ),
			'after'	 => '</div>',
		) );
		?>
    </div><!-- .entry-content -->
    <div class="container">
		<?php edit_post_link( esc_html__( 'Edit', 'factory' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
    </div>
</article><!-- #post-## -->
