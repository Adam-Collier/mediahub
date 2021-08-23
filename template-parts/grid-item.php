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

 $launchDate = new DateTime(get_lzb_meta( 'launching' ));
 $now = new DateTime();
 $launchText = $launchDate > $now ? "Launching" : "Launched";
?>

<article class="grid-item">
    <a href="<?php echo the_permalink() ?>">
        <header class="grid-item-header">
            <?php
            the_title( '<h2 class="grid-item-title heading">', '</h2>' );
            ?>
            <p class="grid-item-launching"><?php echo $launchText . date(' jS M \a\t g:ia', strtotime(get_lzb_meta( 'launching' ))) ?></p>
        </header><!-- .entry-header -->
            <p class="grid-item-status <?php echo strtolower(explode(' ', get_lzb_meta( 'status' ))[0])?>"><?php echo get_lzb_meta( 'status' ) ?></p>
        <div class="img-placeholder">
            <?php if (has_post_thumbnail()): ?>
                <img
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=" 
                    alt="<?php echo $campaignAlt; ?>" 
                    srcset="<?php echo $campaignSrcset; ?>" 
                    sizes="(max-width: 768px) 50vw, (max-width: 1440px) 23vw, 23vw"
                />
            <?php else: ?>
                <img src=<?php echo default_thumbnail(); ?> alt="default thumbnail" />
            <?php endif; ?>
        </div>
    </a>
</article><!-- .grid-item ?> -->
