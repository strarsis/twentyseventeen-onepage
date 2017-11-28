<?php

function onepage_enqueue_styles() {

  // Parent theme style
  $parent_style = 'twentyseventeen-style-2';
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array( $parent_style ),
      wp_get_theme()->get('Version')
  );

  // Bootstrap Scrollspy
  wp_enqueue_script( 'bootstrap-scrollspy', get_stylesheet_directory_uri() . '/bootstrap-scrollspy.min.js', array('jquery') );

  // Location update for Scrollspy
  wp_enqueue_script( 'bootstrap-scrollspy-location', get_stylesheet_directory_uri() . '/bootstrap-scrollspy-location.min.js', array('bootstrap-scrollspy') );
}
add_action( 'wp_enqueue_scripts', 'onepage_enqueue_styles', 100 );


// override for inc/customizer.php

function twentyseventeen_customize_register_sluganchors( $wp_customize ) {
  $num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
  for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
    $panel_partial = $wp_customize->selective_refresh->get_partial( 'panel_' . $i);
    $panel_partial->render_callback = 'twentyseventeen_front_page_section_sluganchors';
  }
}

add_action( 'customize_register', 'twentyseventeen_customize_register_sluganchors' );


/*
 * A simple function to control the number of Twenty Seventeen Theme Front Page Sections
 * Source: wpcolt.com
 */
/* Uncomment + adjust the amount in case you need it:
function twentyseventeen_custom_front_sections( $num_sections )	{
  return 7; // Change this number to change the number of the sections.
}
add_filter( 'twentyseventeen_front_page_sections', 'twentyseventeen_custom_front_sections' );
*/

