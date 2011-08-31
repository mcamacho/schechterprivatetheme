<?php
/**
 * The template for displaying Search Results pages. Photo library search is different
 *
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
                        <img width="720" height="180" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php
						printf( __( 'Search Results for: %s', 'schechtertheme' ), '<span>' . get_search_query() . '</span>' );
					?></h1>
				</header>
				<div class="division"></div>
				<?php while ( have_posts() ) : the_post(); 
				if( get_post_type(get_the_ID()) == 'page'  ): ?>
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'schechtertheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
					<div class="entry-content"><?php the_excerpt(); ?></div>

				<?php endif; endwhile; ?>
				<div class="division"></div>
			<?php else : ?>

				<img width="720" height="180" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'schechtertheme' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'schechtertheme' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>