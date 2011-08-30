<?php
/**
 * The template for displaying Search Results pages.
 *
 */
?>
<?php get_header(); ?>
<section id="primary">
    <div id="content" role="main">
      <img width="712" height="150" src="<?php echo content_url(); ?>/uploads/2011/08/private_schechter_header.jpg" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <?php $cat = single_cat_title('', false); ?>
            <h1 class="page-title">Category: <?php echo $cat; ?></h1>
        </header>
        <?php while ( have_posts() ) : the_post(); ?>
        <?php if (in_category($cat)) :?>
            <div>
                <?php
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                $linkto = is_category('Grade Level') ? get_category_link(get_cat_ID(get_post_meta(get_the_ID(), 'category link', true))) : $thumb[0] ;?>
                <a href="<?php echo $linkto ?>" <?php echo is_category('Grade Level') ? '' : 'class="lightbox"'?>>
                <?php the_post_thumbnail('thumbnail'); ?>
                </a>
                <h2 class="entry-title">
                    <?php the_title(); ?>
                </h2>
                <ul>
                <li><span>Name:</span><?php the_title(); ?></li>
                <li><span>Description:</span><?php echo get_the_content(); ?></li>
                <li><span>Categories:</span><?php foreach((get_the_category()) as $category) { 
                    echo $category->cat_name . ','; } ?>
                </li>
                <li><span>Tags:</span><?php foreach((get_the_tags()) as $tags) { 
                    echo $tags->name . ','; } ?>
                </li>
                <li><span>Usage Rights:</span><?php echo get_post_meta(get_the_ID(), 'usage rights', true); ?></li>
                </ul>
            </div>
        <?php endif; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Nothing Found', 'schechtertheme' ); ?></h1>
            </header><!-- .entry-header -->
            <div class="entry-content">
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'schechtertheme' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-0 -->
    <?php endif; ?>
    </div><!-- #content -->
</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>