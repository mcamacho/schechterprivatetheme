<?php
/**
 *  actions that modify the theme and WP site access
 *  and a set of functions for the home login - register home page
 */

//function that makes possible the upload of files on the upload photos template
function insert_attachment($file_handler,$post_id,$setthumb='false') {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;
}

//filter that extends the mime upload types
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	// add the file extension to the array
	$existing_mimes['eps'] = 'application/eps';
        // call the modified list of extensions
	return $existing_mimes;
}

//filter that allows the front page admin bar just for the administrator role
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
function my_function_admin_bar($content) {
	return ( current_user_can("administrator") ) ? $content : false;
}

//action added to redirect the site to the home login register page if the user hasn't more than a subscriber role
add_action( 'template_redirect', 'schechter_private' );
function schechter_private() {
    if( ! is_page_template( 'tmpl-login-register.php' )  ){
        $mypages = get_pages( array( 'meta_value' => 'tmpl-login-register.php' ) );
        $logregpag = $mypages[0]->ID;
        if( ! is_user_logged_in() ) {
            wp_redirect(get_permalink($logregpag));
            exit;
        }elseif(current_user_can ('subscriber')){
            wp_redirect(get_permalink($logregpag));
            exit;		
        }
    }
} /*end schechter_private*/

//schechter private theme setup
add_action( 'after_setup_theme', 'schechter_setup' );
function schechter_setup() {
    
    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Grab Image_Text_WIdget.
    require( dirname( __FILE__ ) . '/inc/widgets.php' );

    // Add default posts and comments RSS feed links to <head>.
    add_theme_support( 'automatic-feed-links' );

    // This theme uses wp_nav_menu() sidebar.
    register_nav_menu( 'primary', __( 'Primary Menu', 'schechtertheme' ) );
    
    // This theme uses Featured Images for attach image to logo and photo
    add_theme_support( 'post-thumbnails' );
	
}// schechter_setup

//image text widget init and sidebar registration
add_action( 'widgets_init', 'schechter_widgets_init' );
function schechter_widgets_init() {
    
    // register FooWidget widget
    register_widget("Image_Text_Widget");
    
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'schechtertheme' ),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    //Add a footer sidebar for the home template
    register_sidebar( array(
        'name' => __( 'Home Footer', 'schechtertheme' ),
        'id' => 'sidebar-home',
        'description' => __( 'widget area for the home area over footer', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    //Add a footer sidebar for the main link of each of the menu options
    register_sidebar( array(
        'name' => __( 'Widgets - Menu 1', 'schechtertheme' ),
        'id' => 'sidebar-m1',
        'description' => __( 'widget area for the main page of menu 1, hero-footer template must be assigned to the page, and order to 1', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    register_sidebar( array(
        'name' => __( 'Widgets - Menu 2', 'schechtertheme' ),
        'id' => 'sidebar-m2',
        'description' => __( 'widget area for the main page of menu 2, hero-footer template must be assigned to the page, and order to 2', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Widgets - Menu 3', 'schechtertheme' ),
        'id' => 'sidebar-m3',
        'description' => __( 'widget area for the main page of menu 3, hero-footer template must be assigned to the page, and order to 3', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
	register_sidebar( array(
        'name' => __( 'Widgets - Menu 3.1', 'schechtertheme' ),
        'id' => 'sidebar-m31',
        'description' => __( 'widget area for the main page of submenu 1 for menu 3, hero-footer template must be assigned to the page, and order to 6', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
	register_sidebar( array(
        'name' => __( 'Widgets - Menu 3.2', 'schechtertheme' ),
        'id' => 'sidebar-m32',
        'description' => __( 'widget area for the main page of submenu 2 for menu 3, hero-footer template must be assigned to the page, and order to 7', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    register_sidebar( array(
        'name' => __( 'Widgets - Menu 4', 'schechtertheme' ),
        'id' => 'sidebar-m4',
        'description' => __( 'widget area for the main page of menu 4, hero-footer template must be assigned to the page, and order to 4', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    register_sidebar( array(
        'name' => __( 'Widgets - Menu 5', 'schechtertheme' ),
        'id' => 'sidebar-m5',
        'description' => __( 'widget area for the main page of menu 5, hero-footer template must be assigned to the page, and order to 5', 'schechtertheme' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}

// category-logo shortcode, includes logo post-type posts on a page, ready for downloading
add_shortcode( 'category-logo', 'category_logo_func' );
function category_logo_func( $atts ) {
    extract( shortcode_atts( array('category' => 'no category', 'title' => 'no title'), $atts ) );
    $args = array(
        'post_type' => 'logo',
        'numberposts' => -1,
        'post_status' => null,
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'order',
        'logotype' => $category
      );
    $tmplist = '<h2 class="category-logo">' . $title . '</h2><ul class="category-logo">';
    $attachments = get_posts( $args );
        if ( $attachments ) {
            foreach ( $attachments as $attachment ) {
                $thefile = get_post_meta($attachment->ID, 'file', true);
                $tmplist = $tmplist . '<li>';
                $tmplist = $tmplist . '<div><h3>' . apply_filters( 'the_title' , $attachment->post_title ) . '</h3><p>';
                $tmplist = $tmplist . $attachment->post_content;
                $tmplist = $tmplist . '<a href="' . $thefile . '" class="forced-download">Download</a></p></div>';
                $tmplist = $tmplist . get_the_post_thumbnail($attachment->ID, 'thumbnail') . '</li>';
            }
            return $tmplist . '</ul>';
        }
}

//add resource post type
add_action('init', 'resource_post_type');
function resource_post_type() 
{
  $labels = array(
    'name' => _x('resources', 'post type general name'),
    'singular_name' => _x('resource', 'post type singular name'),
    'add_new' => _x('Add New', 'resource'),
    'add_new_item' => __('Add New resource'),
    'edit_item' => __('Edit resource'),
    'new_item' => __('New resource'),
    'all_items' => __('All resources'),
    'view_item' => __('View resource'),
    'search_items' => __('Search resources'),
    'not_found' =>  __('No resources found'),
    'not_found_in_trash' => __('No resources found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'resources'

  );
  $args = array(
    'labels' => $labels,
    'description' => 'resource type post used for the resource library',
    'public' => true,
    'hierarchical' => false,
    'supports' => array( 'title', 'editor', 'author' ),
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => null,
    
    'show_in_nav_menus' => true,
    'publicly_queryable' => false,
    'exclude_from_search' => true,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => false,
    'capability_type' => 'post'
  ); 
  register_post_type('sharedrsc',$args);
}
//add logo post type
add_action('init', 'logo_post_type');
function logo_post_type() 
{
  $labels = array(
    'name' => _x('Logos', 'post type general name'),
    'singular_name' => _x('Logo', 'post type singular name'),
    'add_new' => _x('Add New', 'logo'),
    'add_new_item' => __('Add New Logo'),
    'edit_item' => __('Edit Logo'),
    'new_item' => __('New Logo'),
    'all_items' => __('All Logos'),
    'view_item' => __('View Logo'),
    'search_items' => __('Search Logos'),
    'not_found' =>  __('No logos found'),
    'not_found_in_trash' => __('No logos found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Logos'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'hierarchical' => false,
    'description' => 'Logo type post used for the logo library',
    'supports' => array( 'title', 'editor', 'author', 'custom-fields', 'thumbnail' ),
    'taxonomies' => array( 'logotype' ),
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => null,
    
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post'
  ); 
  register_post_type('logo',$args);
}

add_action( 'init', 'additional_taxonomies' );
function additional_taxonomies() {
	// create a new taxonomy
	register_taxonomy(
		'gradelevel',
		'post',
		array(
                        'hierarchical' => true,
			'label' => __( 'Grade Level' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'gradelevel' )
		)
	);
        
        register_taxonomy(
		'logotype',
		'logo',
		array(
                        'hierarchical' => true,
			'label' => __( 'Logo Types' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'logotype' )
		)
	);
}

add_action("admin_init", "add_logo_meta_box");
function add_logo_meta_box(){
  add_meta_box("logo-file-path", "Logo File", "logo_meta_box", "logo");
}
 
function logo_meta_box(){
  global $post;
  $custom = get_post_custom($post->ID);
  $file_path = isset($custom["file"][0]) ? $custom["file"][0] : '';
  echo '<label>Logo File:</label>';
  echo '<select name="file-path" >';
  echo '<option value="" >Select</option>';
  global $wpdb;
	$the_query = $wpdb->get_results("SELECT post_title, guid
					FROM $wpdb->posts
					WHERE post_type = 'attachment' AND post_excerpt = 'Logo'");
	if(count($the_query)>0):
	foreach( $the_query as $post_results ) :
		$selected = $post_results->guid == $file_path ? ' selected="selected"' : '';
		echo '<option value="'. $post_results->guid .'" '. $selected .' >'. $post_results->post_title .'</option>';
	endforeach; endif;
  echo '</select>';
}
add_action('save_post', 'update_logo_field');
function update_logo_field(){
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
	if ( isset($_POST['post_type']) && 'logo' == $_POST['post_type'] ) 
	{
		global $post;
		update_post_meta($post->ID, "file", $_POST["file-path"]);
	}
}


/*
 * set of functions for the login register home page
 */
function simplr_validate($data) {
    $errors = array();
    //validate the existance of first and last name, title and school
    if(!$data['first_name']){$errors[] = __('You must enter your first name.'); }
    if(!$data['last_name']){$errors[] = __('You must enter your last name.'); }
    if(!$data['title']){$errors[] = __('You must enter your title.'); }
    if(!$data['school']){$errors[] = __('You must enter the school/affiliation.'); }
    // Validate username
    if(!$data['user_login']) { 
        $errors[] = __('You must enter a username.'); 
    } else {
        // check whether username is valid
        $user_test = validate_username( $data['user_login'] );
        if($user_test != true) {
            $errors[] .= __('Invalid Username.');
        }
        // check whether username already exists
        $user_id = username_exists( $data['user_login'] );
        if($user_id) {
            $errors[] .= __('This username already exists.');
        }
    } //end username validation
    if(!$data['user_pass'] || !$data['user_pass_confirm']) {
        $errors[] = __('You must enter a password and password confirmation.');
    }
    // Make sure passwords match
    if($data['user_pass'] != $data['user_pass_confirm']) {
        $errors[] = __('The passwords you entered do not match.');
    }	
    // Validate email
    if(!$data['user_email']) { 
        $errors[] = __('You must enter an email.'); 
    } else {
        $email_test = email_exists($data['user_email']);
        if($email_test != false) {
                $errors[] .= __('An account with this email has already been registered.');
            }
        if( !is_email($data['user_email']) ) {
                $errors[] .= __('Please enter a valid email.');
            }	
        } // end email validation
    return $errors;
}
function simplr_setup_user($atts,$data) {
	//check options
	global $options;
	$admin_email = $atts['from'];
	$emessage = $atts['message'];
	$role = $atts['role']; 
	//Assign POST variables
	$fname = $data['first_name'];
	$lname = $data['last_name'];
	$title = $data['title'];
	$school = $data['school'];
	$user_name = $data['user_login'];
	$user_name = sanitize_user($user_name, true);
	$passw = $data['user_pass'];
	$email = $data['user_email'];
	
	//This part actually generates the account
	
	$userdata = array(
	'user_login' => $user_name,
	'first_name' => $fname,
	'last_name' => $lname,
	'user_pass' => $passw,
	'user_email' => $email,
	'role' => $role
	);
	
	// create user	
	$user_id = wp_insert_user( $userdata );
	
	//Process additional fields
	add_user_meta($user_id,'title',$title);
	add_user_meta($user_id,'school',$school);
	
	//notify admin of new user
	simplr_send_notifications($atts,$data, $passw);
	
	$_POST['first_name'] = '';
	$_POST['last_name'] = '';
	$_POST['title'] = '';
	$_POST['school'] = '';
	$_POST['user_login'] = '';
	$_POST['user_email'] = '';
	
	$extra = "Please wait for the message entry clearance.";
	$confirm = '<div>Your Registration was successful. '.$extra .'</div>';
	
	//return confirmation message. 
	return $confirm;
}
function simplr_send_notifications($atts, $data, $passw) {
	$site = site_url();
	$name = get_bloginfo('name');
	$user_name = $data['user_login'];
	$email = $data['user_email'];
	$title = $data['title'];
	$school = $data['school'];
	$notify = $atts['notify'];
	$emessage = __("Your registration was successful.".$atts['message']);
	$headers = "From: $name" . ' <' .get_option('admin_email') .'> ' ."\r\n\\";
	wp_mail($notify, "A new user registered for $name", "A new user has registered for $name.\rUsername: $user_name\rEmail: $email\rTitle: $title\rSchool: $school \r",$headers);
	$emessage = $emessage . "\r\r---\r";
            if(!isset($data['password'])) {
                $emessage .= "Schechter Network Site Administrator will send you a message with the confirmation and upgrade of your user account.\r\r";
            }
	$emessage .= "Username: $user_name\rPassword: $passw\rLogin: $site/login-register/";
	wp_mail($data['user_email'],"$name - Registration", apply_filters('simplr_email_confirmation_message',$emessage,$data) , $headers);
}
function sreg_process_form($atts) {
	//security check
	$errors = simplr_validate($_POST);
	$message = array();
	if( $errors ==  true ) :
	    $message = $errors;
	endif; 
	if (!$message) {		
            $output = simplr_setup_user($atts,$_POST);
            return $output;
	} else {	
            //Print the appropriate message
            if(is_array($message)) {
                $out = '';
                foreach($message as $mes) {
                    $out .= '<p>'.$mes .'</p>';
                }
            } else {
                $out = '<p>'.$message .'</p>';
            }
            //return shortcode output
            return $out;
	}
} //sreg_process_form
function sreg_basic($atts) {
//Check if the user is logged in, if so he doesn't need the registration page
	if ( is_user_logged_in() ) {
	    return "You are already registered for this site!!!";
	} else {
            //Then check to see whether a form has been submitted, if so, I deal with it.
            $output = sreg_process_form($atts);	
            return $output;
	} //Close LOGIN Conditional
} //sreg_basic

//call to the register, echoes the results
function private_home(){
    return sreg_basic(array(
            'role' => 'subscriber',
            'from' => get_bloginfo('admin_email'),
            'message' => 'Thank you for registering',
            'notify' => get_bloginfo('admin_email'),
            'fb' => false,
            ));
}

?>
