<?php
/**
 * The template used for displaying full width page content in page.php
 *
 * @package commercegurus
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php factorycommercegurus_get_page_title(); ?>
    <div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'factory' ),
			'after'	 => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
