<?php
/**
 * Template Name: Photo Search
 * The template for photo search.
 */
?>

<?php get_header(); ?>

<div id="primary">
    <div id="content" role="main">
    <?php
    //display the search results when variables on $_get url appears	
    if ( count($_GET) ) : ?>
    <?php
        global $wpdb;
        $gradelevel = $_GET['grade_level'];
        $category = $_GET['category'];
        $keyword = '%' . $_GET['keyword'] . '%';
        //first construct the query for gradelevel, category and keyword using wp_query
        $graargs = $gradelevel == 'all' ? 'pre-5th,6th-8th,9th-12' :  $gradelevel;
        $catargs = $category == 'all' ? 'general-studies,jewish-studies,physical-education,prayer-ritual,other' :  $category;
        //if($keyword==''){
        //    $args = 'category_name=' . $graargs . ',' . $catargs;
        //}else{
        //    $args = 'array("category__not_in"=> array(19,1),"tag"=>array('. $keyword . ')")';
        //}
        $args = 'category_name=' . $graargs . ',' . $catargs;
        //make the query
        $the_query = new WP_Query( $args );
        //The Loop
        /*if($keyword!='') :
            $a=0;
            $photoposts = array();
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $photoposts[$a] = get_the_ID();
                $a++;
            endwhile;
            $pposts = implode(",", $photoposts);
            //construct the query for keyword
            global $wpdb;
            //make the query
            $the_query = $wpdb->get_results(
                    "SELECT *
                    FROM $wpdb->posts
                    WHERE ID IN(130,56)");
        endif;*/ ?>
            <div id="library">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="photo">
                    <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
                    $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
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
                    <li><a href="<?php echo $fullimage[0]; ?>" class="forced-download">DOWNLOAD</a></li>
                    </ul>
                </div>
            <?php endwhile; ?>
            </div>
        <?php
        //Reset Post Data
        wp_reset_postdata();
        
    ?>
    <?php else: ?>
    <?php the_post(); ?>
        <?php if ( has_post_thumbnail() ) :
            the_post_thumbnail();
          else : ?>
          <img width="720" height="180" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
        <?php endif; ?>
        <header class="entry-header">					
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->
        <div id="sc-search-options">
            <h2>SEARCH BY GRADE, CATEGORY AND KEY WORD:</h2>
            
            <form>
            <!--the grade_level and category options are hard coded-->
            <p class="wide"><label for="grade_level">Select Grade Level </label>
            <select id="grade_level" name="grade_level" >
                    <option value="all">Any</option>
                    <option value="pre-5th">Pre 5th</option>
                    <option value="6th-8th">6th 8th</option>
                    <option value="9th-12th">9th 12th</option>
            </select></p>
            <p class="downl">+</p>
            
            <p class="wide"><label for="category">Select Category</label>
            <select id="category" name="category" >
                    <option value="all">Any</option>
                    <option value="general-studies">General Studies</option>
                    <option value="jewish-studies">Jewish Studies</option>
                    <option value="physical-education">Physical Education/Sports</option>
                    <option value="prayer-ritual">Prayer/Ritual</option>
                    <option value="other">Other</option>
            </select></p>
            <p class="downl">+</p>
            
            <p class="wide"><label for="keyword">Enter Key Word</label>
	    <input name="keyword" id="keyword" type="text" /></p>
            
            <input type="submit" value="SEARCH" class="downl" />
            </form>
        </div><!-- #search-options -->
    <?php endif; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>