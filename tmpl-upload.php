<?php
/**
 * Template Name: Photo Upload
 * The template for photo upload.
 */
?>
<?php
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

	// Do some minor form validation to make sure there is content
	if (isset ($_POST['title'])) {
		$title =  $_POST['title'];
	} else {
		echo 'Please enter the wine name';
	}
	if (isset ($_POST['description'])) {
		$description = $_POST['description'];
	} else {
		echo 'Please enter some notes';
	}

	$tags = $_POST['post_tags'];
	//$winerating = $_POST['winerating'];

	// ADD THE FORM INPUT TO $new_post ARRAY
	$new_post = array(
	'post_title'	=>	$title,
	'post_content'	=>	$description,
	'post_category'	=>	array($_POST['cat']),  // Usable for custom taxonomies too
	'tags_input'	=>	array($tags),
	'post_status'	=>	'publish',           // Choose: publish, preview, future, draft, etc.
	'post_type'	=>	'post'//,  'post',page' or use a custom post type if you want to
	/*'winerating'	=>	$winerating*/
	);

	//SAVE THE POST
	$pid = wp_insert_post($new_post);

             //KEEPS OUR COMMA SEPARATED TAGS AS INDIVIDUAL
	wp_set_post_tags($pid, $_POST['post_tags']);

	//REDIRECT TO THE NEW POST ON SAVE
	$link = get_permalink( $pid );
	wp_redirect( $link );

	//ADD OUR CUSTOM FIELDS
	add_post_meta($pid, 'rating', $winerating, true); 

	//INSERT OUR MEDIA ATTACHMENTS
	if ($_FILES) {
		foreach ($_FILES as $file => $array) {
		$newupload = insert_attachment($file,$pid);
		// $newupload returns the attachment id of the file that
		// was just uploaded. Do whatever you want with that now.
		}

	} // END THE IF STATEMENT FOR FILES

} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM

//POST THE POST YO
do_action('wp_insert_post', 'wp_insert_post');

?>

<?php get_header(); ?>

<div id="primary">
    <div id="content" role="main">
      <img width="720" height="180" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_site_header.gif" class="attachment-post-thumbnail wp-post-image" alt="private_schechter_header" title="private_schechter_header">
        <header class="entry-header">					
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        <div class="wpcf7">
		<form id="new_post" name="new_post" method="post" action="" class="wpcf7-form" enctype="multipart/form-data">
			<!-- post name -->
			<fieldset name="name">
				<label for="title">Photo Name:</label>
				<input type="text" id="title" value="" tabindex="5" name="title" />
			</fieldset>

			<!-- post Category -->
			<fieldset class="category">
				<label for="cat">Category:</label>
				<?php wp_dropdown_categories( 'tab_index=10&taxonomy=category&hide_empty=0' ); ?>
			</fieldset>

			<!-- post Content -->
			<fieldset class="content">
				<label for="description">Description:</label>
				<textarea id="description" tabindex="15" name="description" cols="80" rows="10"></textarea>
			</fieldset>

			<!-- images -->
			<fieldset class="image">
				<label for="image_photo">Front of the Bottle</label>
				<input type="file" name="image_photo" id="image_photo" tabindex="25" />
			</fieldset>

			<!-- post tags -->
			<fieldset class="tags">
				<label for="post_tags">Additional Keywords (comma separated):</label>
				<input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
			</fieldset>

			<fieldset class="submit">
				<input type="submit" value="Post Review" tabindex="40" id="submit" name="submit" />
			</fieldset>

			<input type="hidden" name="action" value="new_post" />
			<?php wp_nonce_field( 'new-post' ); ?>
		</form>
		</div> <!-- END WPCF7 -->

		<!-- END OF FORM -->
						<?php //wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->

        <?php endwhile; // end of the loop. ?>
    
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>