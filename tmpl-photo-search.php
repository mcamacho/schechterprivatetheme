<?php
/**
 * Template Name: Photo Search
 * The template for photo search.
 */
?>

<?php get_header(); ?>

<div id="primary">
    <div id="content" role="main">
      <img width="720" height="180" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
        <header class="entry-header">					
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->
    <?php
    //display the search results when variables on $_get url appears	
    if ( count($_GET) ) : ?>
    <?php
        global $wpdb;
        $gradelevel = $_GET['grade_level'];
        $category = $_GET['category'];
        //first construct the query for gradelevel, category and keyword using wp_query
        $args = array(
        'post_type' => 'post',
        'numberposts' => -1,
        'cat' => $category,
        'paged' => get_query_var('paged'),
        'tax_query' => array(array('taxonomy'=>'gradelevel','field'=>'id','terms'=>$gradelevel))
        );
        //make the query
        $the_query = new WP_Query( $args );
        ?>
            <div id="library">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="photo entry-content">
                    <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                    $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                    $linkto = $thumb[0] ;?>
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
                        echo $category->cat_name . ','; } ?>
                    </li>
                    <li><span>Tags:</span><?php foreach((get_the_tags()) as $tags) { 
                        echo $tags->name . ','; } ?>
                    </li>
                    <li><span>Usage Rights:</span><?php echo get_post_meta(get_the_ID(), 'usage rights', true); ?></li>
                    <li><span><a href="<?php echo $fullimage[0]; ?>" class="forced-download">DOWNLOAD</a></span></li>
                    </ul>
                </div>
            <?php endwhile; ?>
            </div>
        <?php wp_pagenavi(array( 'query' => $the_query )); ?>
        <?php
        //Reset Post Data
        wp_reset_postdata();
        
    ?>
    <?php else: ?>
    <?php the_post(); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->
        <div id="sc-search-options">
            <h2>SEARCH BY GRADE, CATEGORY OR KEY WORD:</h2>
            
            <form role="search" method="get" id="categorysearch">
              <!--the grade_level and category options are hard coded-->
              <p class="wide"><label for="grade_level">Select Grade Level </label>
                <?php wp_dropdown_categories( 'name=grade_level&taxonomy=gradelevel&hide_empty=0' ); ?>
              </p>
              <p class="downl">+</p>
              
              <p class="wide"><label for="category">Select Category</label>
                <?php wp_dropdown_categories( 'name=category&taxonomy=category&hide_empty=0&orderby=name' ); ?>
              </p>
              
              <input type="submit" value="SEARCH" class="downl" />
            </form>
            <form role="search" method="get" id="keywordsearch" action="<?php echo home_url( '/' ); ?>">
              <input type="hidden" name="post_type" value="post" />
              <p class="wide"><label for="keyword">Enter Key Word</label>
              <input name="s" id="ps" type="text" /></p>
              <!--<select id="tag" name="tag">
                <option value="">Select</option>
                <?php //$tags = get_tags(array('fields'=>'names'));?>
                <?php //foreach ($tags as $tag) : ?>
                <option value="<?php //echo $tag; ?>"><?php //echo $tag; ?></option>
                <?php //endforeach; ?>
              </select>-->
              <input type="submit" value="SEARCH" class="downl" />
            </form>
            <div id="cloud-tag">
              <p><label>Click on a Tag</label><p>
              <?php wp_tag_cloud(); ?>
            </div>
        </div><!-- #search-options -->
    <?php endif; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>