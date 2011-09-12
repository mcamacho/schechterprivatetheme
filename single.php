<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
			<img width="712" height="178" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
                            <?php the_post(); ?>
                                <header class="entry-header">					
                                        <h1 class="entry-title"><?php the_title(); ?></h1>
                                </header><!-- .entry-header -->
                                <div class="entry-content">
                                    <?php the_post_thumbnail('thumbnail'); ?>
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
                                </div><!-- .entry-content -->
                                <nav id="nav-single">
                                    <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'schechterthemeprivate' ) ); ?></span>
                                    <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'schechterthemeprivate' ) ); ?></span>
				</nav><!-- #nav-single -->
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>