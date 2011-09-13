<?php
/**
 * The template for displaying Category pages.
 *
 */
?>
<?php get_header(); ?>
<section id="primary">
    <div id="content" role="main">
      <img width="712" height="178" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <?php $cat = single_cat_title('', false); ?>
            <h1 class="page-title">Category: <?php echo $cat; ?></h1>
        </header>
        <div id="description"><?php echo category_description(); ?></div>
        <div id="library">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="photo entry-content">
                <?php
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                $linkto = $thumb[0]; ?>
                <a href="<?php echo $linkto ?>" class="lightbox">
                <?php the_post_thumbnail('thumbnail'); ?>
                </a>
                <h2 class="entry-title">
                    <?php the_title(); ?>
                </h2>
                <ul>
                <li><span>Name:</span><?php the_title(); ?></li>
                <li><span>Description:</span><?php echo get_the_content(); ?></li>
                <li><span>Categories:</span><?php foreach((get_the_category()) as $category) { 
                    echo $category->cat_name . ', '; } ?>
                </li>
                <li><span>Tags:</span><?php foreach((get_the_tags()) as $tags) { 
                    echo $tags->name . ', '; } ?>
                </li>
                <li><span>Usage Rights:</span><?php echo get_post_meta(get_the_ID(), 'usage rights', true); ?></li>
                <li><span><a href="<?php echo $fullimage[0]; ?>" class="forced-download">DOWNLOAD</a></span></li>
                </ul>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else : ?>
        <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Nothing Found', 'schechterthemeprivate' ); ?></h1>
            </header><!-- .entry-header -->
            <div class="entry-content">
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'schechterthemeprivate' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-0 -->
    <?php endif; ?>
    <?php wp_pagenavi(); ?>
    </div><!-- #content -->
</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>