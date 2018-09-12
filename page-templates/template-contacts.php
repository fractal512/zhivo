<?php
/**
 * Template Name: Contacts
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<hr>
		<h2>Template Name: Contacts</h2>
		<hr>
		<div id="contact-form" class="contact-form">
			<h2><?php _e('Contact us', 'zhivo'); ?></h2>
			<?php
			global $zhivo_contact_error;
			if( isset($zhivo_contact_error) && $zhivo_contact_error ):
			?>
			<div class="error"><?php _e('Some fields are not filled or filled incorrectly!', 'zhivo'); ?></div>
			<?php elseif( isset($_GET['contact_status']) && $_GET['contact_status']=='success' ): ?>
			<div class="success"><?php _e('Message sent. Thank you!', 'zhivo'); ?></div>
			<?php endif; ?>
			<form id="zhivo-contact-form" action="<?php echo esc_url( zhivo_current_url() ); ?>" method="POST">
				<label for="name"><?php _e('Your name', 'zhivo'); ?>:</label>
				<input type="text" id="name" name="contact_name">
				<label for="email"><?php _e('E-mail', 'zhivo'); ?>:</label>
				<input type="text" id="email" name="contact_email">
				<label for="subject"><?php _e('Subject', 'zhivo'); ?>:</label>
				<input type="text" id="subject" name="contact_subject">
				<label for="message"><?php _e('Message', 'zhivo'); ?>:</label>
				<textarea id="message" name="contact_message"></textarea>
				<input type="hidden" name="action" value="zhivo-contact">
				<?php wp_nonce_field( 'zhivo_form_contact' ); ?>
				<div class="form-submit"><input class="form-submit-btn" type="submit" value="<?php _e('Send message', 'zhivo'); ?>"></div>
			</form>
		</div>
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
