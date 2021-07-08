<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mediahub
 */

get_header();
?>

	<main id="post" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			the_content();

			$chevronLeft = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>';

			$chevronRight = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>';
			
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-title">' . $chevronLeft . '%title</span>',
					'next_text' => '<span class="nav-title">%title' . $chevronRight. '</span>',
				)
			);
		endwhile; // End of the loop.
		?>
		<div class="copy-toast">Copied to clipboard!</div><!-- .copy-toast -->
	</main><!-- #main -->

<?php
get_footer();
