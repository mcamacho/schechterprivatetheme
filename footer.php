<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		
		<p>&#169; 2011 SCHECHTER DAY SCHOOL NETWORK, ALL RIGHTS RESERVED</p>

	</footer><!-- #colophon -->
</div><!-- #page -->

<script src="<?php echo get_template_directory_uri(); ?>/js/menu.js" type="text/javascript"></script>
<?php if(is_category() || is_page_template('tmpl-photo-search.php')) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.colorbox-min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/photo.js" type="text/javascript"></script>
<?php endif; ?>
<?php wp_footer(); ?>

</body>
</html>