<?php
/**
 * Template Name: Resource Upload
 * The template for resource upload.
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
	if (isset ($_POST['fdescription'])) {
		$description = $_POST['fdescription'];
	} else {
		echo 'Please enter some notes';
	}

	// ADD THE FORM INPUT TO $new_post ARRAY
	$new_post = array(
	'post_title'	=>	$title,
	'post_content'	=>	$description,
	'post_status'	=>	'draft',           // Choose: publish, preview, future, draft, etc.
	'post_type'	=>	'sharedrsc',  //'post',page' or use a custom post type if you want to
	);

	//SAVE THE POST
	$pid = wp_insert_post($new_post);

	//REDIRECT TO PHOTO LIBRARY PAGE
	//$link = get_permalink( $pid );
	wp_redirect( home_url() . '/shared-resources/' );

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
            <div class="upload-photos">
		<form id="new_post" name="new_post" method="post" action="" class="upload-photos-form" enctype="multipart/form-data">
			<!-- post name -->
			<fieldset name="name">
				<label for="title">ATTACHMENT TITLE</label>
				<input type="text" id="title" value="" tabindex="5" name="title" />
			</fieldset>
                        
                        <!-- post Content -->
			<fieldset class="content">
				<label for="fdescription">DESCRIPTION (LIMIT 80 CHARACTERS)</label>
				<input type="text" id="fdescription" value="" tabindex="10" name="fdescription" maxlength="80" />
			</fieldset>
                        
			<!-- images -->
			<fieldset class="image">
				<label for="image_photo">Chose File to Upload</label>
				<input type="file" name="image_photo" id="image_photo" tabindex="45" />
                                <label>(Maximum upload file size: 32MB)</label>
			</fieldset>
                        
			<fieldset class="submit">
				<input type="submit" value="UPLOAD" tabindex="50" id="submit" name="submit" style="width:auto;" />
			</fieldset>

			<input type="hidden" name="action" value="new_post" />
			<?php wp_nonce_field( 'new-post' ); ?>
		</form><!-- END OF FORM -->
	    </div> <!-- END upload-photos -->
        </div><!-- .entry-content -->

        <?php endwhile; // end of the loop. ?>
    
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>