<?php
/**
 * Template Name: Hero Footer
 */
?>

<?php get_header(); ?>
    <div id="primary">
        <div id="content" role="main">
            <?php the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('hero-footer'); ?>>
                <?php if ( has_post_thumbnail() ) :
                    the_post_thumbnail();
                else : ?>
                    <img width="712" height="178" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
                <?php endif; ?>
                <header class="entry-header">					
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->
            <div id="supplementary" class="footer-widgets" >
            <?php if ( is_active_sidebar( 'sidebar-home' ) && $post->menu_order == 0 ) : ?>
                <?php dynamic_sidebar( 'sidebar-home' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m1' ) && $post->menu_order == 1 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m1' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m2' ) && $post->menu_order == 2 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m2' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m3' ) && $post->menu_order == 3 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m3' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m31' ) && $post->menu_order == 6 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m31' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m32' ) && $post->menu_order == 7 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m32' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m4' ) && $post->menu_order == 4 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m4' ); ?>
            <?php elseif ( is_active_sidebar( 'sidebar-m5' ) && $post->menu_order == 5 ) : ?>
                <?php dynamic_sidebar( 'sidebar-m5' ); ?>
            <?php endif; ?>
            </div><!-- #supplementary -->
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>