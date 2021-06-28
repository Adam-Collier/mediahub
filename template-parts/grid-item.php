<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediahub
 */

?>

<article class="grid-item">
    <a href="<?php echo the_permalink() ?>">
        <header class="entry-header">
            <?php
            the_title( '<h2 class="grid-item-title heading">', '</h2>' );
            ?>
        </header><!-- .entry-header -->
        <div class="img-placeholder">
            <?php mediahub_post_thumbnail(); ?>
        </div>
    </a>
</article><!-- .grid-item ?> -->
