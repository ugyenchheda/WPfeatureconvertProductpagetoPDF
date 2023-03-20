<?php
/**
 * Template Name: Corn Run Template
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maya_Journeys
 */
ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
get_header();

while ( have_posts() ) :
  the_post();
?>

<div class="container">
<?php
//echo phpinfo();
    //  palmer_sync_product_data();
   palmer_update_media_data();
 ?>
</div>
<?php
		endwhile;
get_footer();
