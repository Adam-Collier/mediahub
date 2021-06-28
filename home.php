<?php
 /*  
Template Name: Homepage
*/

get_header();
?>
	<main id="home" class="site-main">
		<?php
            // our loop for the page content
            if ( have_posts() ) :
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    // render out the page content
                    the_content();
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
		?>

	</main><!-- #main -->

<?php
get_footer();
