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
	if (isset ($_POST['fdescription'])) {
		$description = $_POST['fdescription'];
	} else {
		echo 'Please enter some notes';
	}
        
	$tags = $_POST['post_tags'];
	$usagerights = $_POST['usagerights'];
        
        if($_POST['gradelevel']==0){
            $alltax = get_categories(array('taxonomy'=>'gradelevel','hide_empty'=>0));
            $i=0;$taxids = array();
            foreach($alltax as $tax){$taxids[$i]=$tax->term_id;$i++;}
        }else{$taxids = array($_POST['gradelevel']);}

	// ADD THE FORM INPUT TO $new_post ARRAY
	$new_post = array(
	'post_title'	=>	$title,
	'post_content'	=>	$description,
	'post_category'	=>	array($_POST['cat']),  // Usable for custom taxonomies too
        'tax_input'     =>      array( 'gradelevel' => $taxids),
	'tags_input'	=>	array($tags),
	'post_status'	=>	'publish',           // Choose: publish, preview, future, draft, etc.
	'post_type'	=>	'post',  //'post',page' or use a custom post type if you want to
	'usagerights'	=>	$usagerights
	);

	//SAVE THE POST
	$pid = wp_insert_post($new_post);

        //KEEPS OUR COMMA SEPARATED TAGS AS INDIVIDUAL
	wp_set_post_tags($pid, $_POST['post_tags']);

	//REDIRECT TO PHOTO LIBRARY PAGE
	//$link = get_permalink( $pid );
	wp_redirect( home_url() . '/photo-library/' );

	//ADD OUR CUSTOM FIELDS
	add_post_meta($pid, 'usage rights', $usagerights, true); 

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
				<label for="title">IMAGE TITLE</label>
				<input type="text" id="title" value="" tabindex="5" name="title" />
			</fieldset>
                        
                        <!-- post Content -->
			<fieldset class="content">
				<label for="fdescription">DESCRIPTION (LIMIT 80 CHARACTERS)</label>
				<input type="text" id="fdescription" value="" tabindex="10" name="fdescription" maxlength="80" />
			</fieldset>

                        <!-- post Grade Level -->
			<fieldset class="category">
				<label for="gradelevel">GRADE LEVEL</label>
				<?php wp_dropdown_categories( 'name=gradelevel&tab_index=15&taxonomy=gradelevel&hide_empty=0&show_option_all=All&orderby=slug' ); ?>
			</fieldset>

			<!-- post Category -->
			<fieldset class="category">
				<label for="cat">CATEGORY</label>
				<?php wp_dropdown_categories( 'tab_index=20&taxonomy=category&hide_empty=0&orderby=slug' ); ?>
			</fieldset>

			<!-- post tags -->
			<fieldset class="tags">
				<label for="post_tags">Additional Keywords (comma separated):</label>
				<input type="text" value="" tabindex="25" name="post_tags" id="post_tags" />
			</fieldset>
                        
                        <!-- post Usage Rights -->
			<fieldset class="content">
				<label for="usagerights">USAGE RIGHTS (LIMIT 200 CHARACTERS)</label>
				<textarea id="usagerights" tabindex="30" name="usagerights" rows="3" maxlength="200" ></textarea>
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