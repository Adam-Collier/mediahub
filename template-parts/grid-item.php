<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediahub
 */
 $campaignID = get_the_ID();
 $thumbnailID = get_post_thumbnail_id($campaignID);
 $campaignAlt = get_post_meta($campaignID, '_wp_attachment_image_alt', true);
 $campaignSrcset = wp_get_attachment_image_srcset($thumbnailID, 'large');
?>

<article class="grid-item">
    <a href="<?php echo the_permalink() ?>">
        <header class="entry-header">
            <?php
            the_title( '<h2 class="grid-item-title heading">', '</h2>' );
            ?>
        </header><!-- .entry-header -->
        <div class="img-placeholder">
            <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=" 
                alt="<?php echo $campaignAlt; ?>" 
                srcset="<?php echo $campaignSrcset; ?>" 
                sizes="(max-width: 768px) 50vw, (max-width: 1440px) 23vw, 23vw"
            />
        </div>
    </a>
</article><!-- .grid-item ?> -->
