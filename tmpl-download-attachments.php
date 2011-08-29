<?php
/**
 * Template Name: Download Attachments Tmpl
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
                  <img width="712" height="150" src="<?php echo content_url(); ?>/uploads/2011/08/private_schechter_header.jpg" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
                <?php endif; ?>
                <header class="entry-header">					
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->
            <div>
            <?php
            $args = array(
               'post_type' => 'attachment',
               'numberposts' => -1,
               'post_status' => null,
               'post_parent' => $post->ID
              );
              $cmyklist='<ul>';
              $spotlist='<ul>';
              $tmplist='';
              $attachments = get_posts( $args );
                 if ( $attachments ) {
                    foreach ( $attachments as $attachment ) {
                      $tmplist = '';
                      $tmplist = $tmplist . '<li style="width: 550px;">';
                      $tmplist = $tmplist . '<div style="float: right; width: 350px;"><h3>' . apply_filters( 'the_title' , $attachment->post_title ) . '</h3><p>';
                      $tmplist = $tmplist . $attachment->post_content;
                      /*$tmplist = $tmplist . '<a href="' . get_bloginfo('stylesheet_directory') . '/inc/download.php?f=' . wp_get_attachment_url( $attachment->ID ) . '" style="display: block;">Download</a></p></div>';*/
                      $tmplist = $tmplist . '<a href="' . wp_get_attachment_url( $attachment->ID ) . '" class="forced-download" style="display: block;">Download</a></p></div>';
                      $tmplist = $tmplist . '<img src="' . get_bloginfo('stylesheet_directory') . '/images/schechter-logo.gif" style="width: 180px;" /></li>';
                        if ($attachment->post_excerpt == 'Cmyk'){;
                          $cmyklist = $cmyklist . $tmplist;
                        }elseif ($attachment->post_excerpt == 'Spot'){;
                          $spotlist = $spotlist . $tmplist;
                        }
                      }
                    echo $cmyklist . '</ul>';
                    echo $spotlist . '</ul>';
                 }
              ?>
            </div>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>