<?php
/**
 *  actions that modify the theme and WP site access
 *  and a set of functions for the home login - register home page
 */

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
    
    // This theme uses Featured Images (also known as post thumbnails) for specific page Custom Header images
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 712, 150, true );
	
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

// category-logo shortcode, includes logo post-type posts for downloading
function category_logo_func( $atts ) {
    extract( shortcode_atts( array('category' => 'no category', 'title' => 'no title'), $atts ) );
    $args = array(
       'post_type' => 'logo',
       'numberposts' => -1,
       'post_status' => null,
       'category' => $category
      );
    $tmplist = '<h2 class="category-logo">' . $title . '</h2><ul class="category-logo">';
    $attachments = get_posts( $args );
        if ( $attachments ) {
            foreach ( $attachments as $attachment ) {
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $attachment->ID ), 'full' );
                $thumbURL = $thumb[0];
                $tmplist = $tmplist . '<li>';
                $tmplist = $tmplist . '<div><h3>' . apply_filters( 'the_title' , $attachment->post_title ) . '</h3><p>';
                $tmplist = $tmplist . $attachment->post_content;
                $tmplist = $tmplist . '<a href="' . $thumbURL . '" class="forced-download">Download</a></p></div>';
                $tmplist = $tmplist . get_the_post_thumbnail($attachment->ID, 'thumbnail') . '</li>';
                //$tmplist = $tmplist . '<img src="' . get_bloginfo('stylesheet_directory') . '/images/schechter-logo.gif" style="width: 180px;" /></li>';
            }
            return $tmplist . '</ul>';
        }
}
add_shortcode( 'category-logo', 'category_logo_func' );

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
    'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
    'taxonomies' => array( 'category' ),
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

//add filter to ensure the text Book, or book, is displayed when user updates a book 
//      add_filter('post_updated_messages', 'scphoto_post_type_messages');
function scphoto_post_type_messages( $messages ) {
  global $post, $post_ID;

  $messages['scphoto'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('scphoto updated. <a href="%s">View scphoto</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('scphoto updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('scphoto restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('scphoto published. <a href="%s">View scphoto</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('scphoto saved.'),
    8 => sprintf( __('scphoto submitted. <a target="_blank" href="%s">Preview scphoto</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('scphoto scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview scphoto</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('scphoto draft updated. <a target="_blank" href="%s">Preview scphoto</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Books
//    add_action( 'contextual_help', 'scphoto_post_type_add_help_text', 10, 3 );

function scphoto_post_type_add_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
  if ('sc_scphoto' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a scphoto:') . '</p>' .
      '<ul>' .
      '<li>' . __('The Title is just for reference,') . '</li>' .
      '<li>' . __('The content will be shown within scphotos.') . '</li>' .
      '<li>' . __('The custom fields are shown in this order and are:') . '</li>' .
      '<li>' . __('Name, Location, School, Class, Other and Link (this one not display).') . '</li>' .
      '<li>' . __('If the custom fields are not included just the content will be showed.') . '</li>' .
      '</ul>' ;
  } elseif ( 'edit-book' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}

//       add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','sc_scphoto','nav_menu_item'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
	return $query;
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
	
	$extra = "Please check your email for administrator status check before login.";
	$confirm = '<div>Your Registration was successful. '.$extra .'</div>';
	
	//Use this hook for multistage registrations
	//do_action('simplr_reg_next_action', array($data, $user_id, $confirm));
	
	//return confirmation message. 
	return $confirm;
}
function simplr_send_notifications($atts, $data, $passw) {
	$site = site_url();
	$name = get_bloginfo('name');
	$user_name = $data['user_login'];
	$email = $data['user_email'];
	$school = $data['school'];
	$notify = $atts['notify'];
	$emessage = __("Your registration was successful.".$atts['message']);
	$headers = "From: $name" . ' <' .get_option('admin_email') .'> ' ."\r\n\\";
	wp_mail($notify, "A new user registered for $name", "A new user has registered for $name.\rUsername: $user_name\r Email: $email\r School: $school \r",$headers);
	$emessage = $emessage . "\r\r---\r";
            if(!isset($data['password'])) {
                $emessage .= "Schechter Network Site Administrator will send you a message with the confirmation and upgrade of your user account.\r\r";
            }
	$emessage .= "Username: $user_name\rPassword: $passw\rLogin: $site/wp-login.php";
	wp_mail($data['user_email'],"$name - Registration Confirmation", apply_filters('simplr_email_confirmation_message',$emessage,$data) , $headers);
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
                    $out .= '<div>'.$mes .'</div>';
                }
            } else {
                $out = '<div>'.$message .'</div>';
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
