<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Simple Instagram
 * @author    Aaron Speer <adspeer@gmail.com>
 * @license   GPL-2.0+
 * @copyright 2013 Press75
 */

if( isset( $_GET['token'] ) ) {
    $token = sanitize_text_field( $_GET['token'] );
    update_option( 'si_access_token', $_GET['token'] );
}

$token = get_option( 'si_access_token' ) ? get_option( 'si_access_token' ) : null;

?>

<div class="wrap">
    <h2>Simple Instagram Settings</h2>
    <section id="authorize">
        <div class="section_title">
            Authorize Your Instagram Account
        </div>
        <div class="section_content active">
            <?php if( is_null( $token ) ): ?>
                <h3><?php _e( 'Account not yet Authorized', 'simple-instagram' ); ?></h3>
                <p><?php _e( 'Before you can display your Instagram feeds, you will need to authorize your Instagram account.', 'simple-instagram' ); ?></p>
                <p><?php _e( 'Use the button below to begin the Authorization process. You will be redirected to Instagram to sign in and authorize this plugin. Once you authorize the plugin, you will be redirected to this page.', 'simple-instagram' ); ?></p>
                <a href="https://api.instagram.com/oauth/authorize/?client_id=f565b2166806431eb8ffbd19d7ea257a&response_type=code&redirect_uri=http://plugins.westwerk.com/si/authenticate_user.php?return_uri=<?php echo admin_url( 'options-general.php?page=simple-instagram' ); ?>" class="button button-primary">Authorize with Instagram</a>
            <?php else: ?>
                <h3><?php _e( 'Your account has successfully been authorized to use Simple Instagram!', 'simple-instagram' ); ?></h3>
                <p><?php _e( 'Feeds not displaying? There might be a problem with your current Authorization. Use the button below to try re-authorizing with Instagram.', 'simple-instagram' ); ?></p>
                <p><a href="https://api.instagram.com/oauth/authorize/?client_id=f565b2166806431eb8ffbd19d7ea257a&response_type=code&redirect_uri=http://plugins.westwerk.com/si/authenticate_user.php?return_uri=<?php echo admin_url( 'options-general.php?page=simple-instagram' ); ?>" class="button button-secondary">Re-Authorize with Instagram</a></p>
            <?php endif; ?>
        </div>
    </section>
    <?php if( !is_null( $token ) ): ?>
        <section id="search">
            <div class="section_title">
                Lookup User ID
            </div>
            <div class="section_content active">
                <p>In order to display the feed of another user, you'll need to know their user ID. Use the form below to search for a user by their username.</p>
                <form>
                    <label>Username:</label>
                    <input type="text" name="user_name">
                    <button class="search_user button button-secondary" value="Search">Search!</button>
                    <div id="search_results"></div>
                </form>
            </div>
        </section>
    <?php endif; ?>
</div>