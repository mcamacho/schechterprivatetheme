<?php
/**
 * The template for displaying Search Results pages. Photo library search is different
 *
 */
get_header(); ?>
            <section id="primary">
                <div id="content" role="main">
                    <img width="712" height="178" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
                    <?php if ( have_posts() ) : ?>
                        <header class="page-header">
                            <h1 class="page-title">
                                <?php printf( __( 'Search Results for: %s', 'schechterthemeprivate' ), '<span>' . get_search_query() . '</span>' );?>
                            </h1>
			</header>
                        <?php if ( $_GET['post_type'] == 'post' ) { echo '<div id="library">';} ?>
                            <?php while ( have_posts() ) : the_post(); 
				if( get_post_type(get_the_ID()) == 'page' && $_GET['post_type'] == 'page' ): ?>
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'schechterthemeprivate' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h2>
				    <div class="entry-content search-page"><?php the_excerpt(); ?></div>
                                <?php elseif ( get_post_type(get_the_ID()) == 'post' && $_GET['post_type'] == 'post' ) : ?>
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
				<?php endif; endwhile; ?>
                        <?php if ( $_GET['post_type'] == 'post' ) { echo '</div>';} ?>
		    <?php else : ?>

                        <header class="entry-header">
                                <h1 class="entry-title"><?php _e( 'Nothing Found', 'schechterthemeprivate' ); ?></h1>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'schechterthemeprivate' ); ?></p>
                                <?php get_search_form(); ?>
                        </div><!-- .entry-content -->

		    <?php endif; ?>
                    <?php wp_pagenavi(); ?>
		    </div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>