<?php
/**
 * Template Name: Login Register Tmpl
 */
 ?>
<?php get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <img width="960" height="180" style="margin-left:-250px;" src="<?php echo get_bloginfo('template_url'); ?>/images/Schechter_private_login_header.gif" class="" alt="private_schechter_header" title="private_schechter_header">
       
        <?php the_post(); ?>
            <header class="entry-header">					
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->
        
        <div id="login-register">
            <?php $args = array('redirect' => home_url());?>
            <div class="left">
                <h2>Login</h2>
                <?php wp_login_form($args); ?>
            <?php if ( count($_POST) > 0 ) : ?>
            <div class="register-response">
                <?php echo private_home() ?>
            </div>
            <?php endif; ?><!--endif POST variables-->
            </div><!--end left-col-->
            
            <div class="right">
                <h2>Register</h2>
            <form id="registerform" method="post" name="registerform">
                <p><label for="first_name">FIRST NAME</label>
                <input name="first_name" id="first_name" type="text" class="input" value="<?php echo count($_POST) ? $_POST['first_name'] : ''; ?>" /></p>
                
                <p><label for="last_name">LAST NAME</label>
                <input name="last_name" id="last_name" type="text" class="input" value="<?php echo count($_POST) ? $_POST['last_name'] : ''; ?>" /></p>
                
                <p><label for="title">TITLE</label>
                <input name="title" id="title" type="text" class="input" value="<?php echo count($_POST) ? $_POST['title'] : ''; ?>" /></p>
                
                <p><label for="school">SCHOOL / AFFILIATION</label>
                <input name="school" id="school" type="text" class="input" value="<?php echo count($_POST) ? $_POST['school'] : ''; ?>" /></p>
                
                <p><label for="user_login">USERNAME</label>
                <input name="user_login" id="user_login" type="text" class="input" value="<?php echo count($_POST) ? $_POST['user_login'] : ''; ?>" /></p>
                
                <p><label for="user_pass">PASSWORD</label>
                <input name="user_pass" id="user_pass" type="password" class="input" /></p>
                
                <p><label for="user_pass_confirm">CONFIRM PASSWORD</label>
                <input name="user_pass_confirm" id="user_pass_confirm" type="password" class="input" /></p>
                
                <p><label for="user_email">EMAIL</label>
                <input name="user_email" id="user_email" type="text" class="input" value="<?php echo count($_POST) ? $_POST['user_email'] : ''; ?>" /></p>
                <p class="register-submit"><input id="wp-register" type="submit" value="REGISTER" /></p>
            </form>
            </div>
        </div>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>