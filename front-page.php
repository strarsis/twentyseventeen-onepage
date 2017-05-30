<?php
/**
 * Overrides default template-part for page slugs as IDs (for anchors)
 */


/* Function from inc/template-tags.php */
/**
 * Display a front page section (modified).
 * Replaced `id="' . $id . '"` with `id="' . $post->post_name . '"`.
 *
 * @param $partial WP_Customize_Partial Partial associated with a selective refresh request.
 * @param $id integer Front page section to display.
 */
function twentyseventeen_front_page_section_sluganchors( $partial = null, $id = 0 ) {
 	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
 		// Find out the id and set it up during a selective refresh.
 		global $twentyseventeencounter;
 		$id = str_replace( 'panel_', '', $partial->id );
 		$twentyseventeencounter = $id;
 	}

 	global $post; // Modify the global post object before setting up post data.
 	if ( get_theme_mod( 'panel_' . $id ) ) {
 		global $post;
 		$post = get_post( get_theme_mod( 'panel_' . $id ) );
 		setup_postdata( $post );
 		set_query_var( 'panel', $id );

 		get_template_part( 'template-parts/page/content', 'front-page-panels' );

 		wp_reset_postdata();
 	} elseif ( is_customize_preview() ) {
 		// The output placeholder anchor.
 		echo '<article class="panel-placeholder panel twentyseventeen-panel twentyseventeen-panel' . $id . ' panel' . $id . '" id="' . $post->post_name . '"><span class="twentyseventeen-panel-title">' . sprintf( __( 'Front Page Section %1$s Placeholder', 'twentyseventeen' ), $id ) . '</span></article>';
 	}
}


get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php // Show the selected frontpage content.
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/page/content', 'front-page' );
			endwhile;
		else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
			get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>

		<?php
		// Get each of our panels and show the post data.
		if ( 0 !== twentyseventeen_panel_count() || is_customize_preview() ) : // If we have pages to show.

			/**
			 * Filter number of front page sections in Twenty Seventeen.
			 *
			 * @since Twenty Seventeen 1.0
			 *
			 * @param $num_sections integer
			 */
			$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
			global $twentyseventeencounter;

			// Create a setting and control for each of the sections available in the theme.
			for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
				$twentyseventeencounter = $i;
				twentyseventeen_front_page_section_sluganchors( null, $i );
			}

	endif; // The if ( 0 !== twentyseventeen_panel_count() ) ends here. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
