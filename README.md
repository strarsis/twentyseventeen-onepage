
# Twenty Seventeen Theme One Page Child Theme

Child theme of Twenty Seventeen with adjustments for an one page / single page site.

## Features
- Page slugs as anchors! 🦄
- Updates anchor in URL (location) when scrolling! 🦄
- Menu link is highlighted when linked page is scrolled in. 🦄
- Fixed anchor offset (when admin bar on frontend is shown).
- Uses the [Bootstrap Scrollspy](https://github.com/twbs/bootstrap/blob/v3-dev/js/scrollspy.js) plugin.
- Live example with Docker container.

## Setup
1. Create a single, normal page for each section in WordPress.
2. In Customizer, set the 'Static Front Page' option to the page to be shown as first section.
3. In Customizer, in "Theme Options", define the sections.
4. If you need more than the default 4 sections, enable and adjust [this commented out code in functions.php](https://github.com/strarsis/twentyseventeen-onepage/blob/master/functions.php#L37-L44) (see https://github.com/strarsis/twentyseventeen-onepage/issues/2#issuecomment-347379212):
```php
/*
 * A simple function to control the number of Twenty Seventeen Theme Front Page Sections
 * Source: wpcolt.com
 */
function twentyseventeen_custom_front_sections( $num_sections )	{
  return 7; // Change this number to change the number of the sections.
}
add_filter( 'twentyseventeen_front_page_sections', 'twentyseventeen_custom_front_sections' );
````
5. In Menu settings, create a new menu and create new menu items of type 'Custom Link'.
The 'page-slug' is showing on every Page directly after the input field for the page title ('Permalink:'). The 'page slug' is the last part. E.g.: http://test.domain.com/page-1 → 'page-1' → URL='#page-1'

6. For smooth scrolling you can install the Wordpress-Plugin [jQuery Smooth Scroll](https://wordpress.org/plugins/jquery-smooth-scroll/).


## Live demo
See README in [live-demo/](live-demo/).

## TODO
Make top navigation always sticky (also sticky on mobile).

## Acknowledgements
Thanks to @nydeggerm for [README improvements](https://github.com/strarsis/twentyseventeen-onepage/issues/3).
