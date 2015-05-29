<?php

/**
 * Simple Instagram AJAX Class
 *
 * Enqueues AJAX actions
 *
 * @package simple-instagram
 */

require_once( SI_PLUGIN_DIR . '/inc/instagram.php' );

class SI_Ajax {
    
    private static $instance;
    
    function __construct() {

        add_action( 'wp_ajax_search_users', array( $this, 'search_users' ) );

    }

    public function search_users() {

        $username = sanitize_text_field( $_POST['user'] );

        if( !$username || $username == '' ) {
            echo '';
            exit;
        }

        $instagram = new SimpleInstagram();

        $users = $instagram->getUserId( $username );

        if( !$users || count( $users ) == 0 ) {
            echo '';
            exit;
        }

        foreach( $users as $result ): ?>
            <div class="si_sr">
                <div class="si_sr_user_image">
                    <img src="<?php echo $result->profile_picture; ?>">
                </div>
                <div class="si_sr_user_info">
                    <div class="si_sr_user_name">
                        <strong>username: </strong><?php echo $result->username; ?>
                    </div>
                    <div class="si_sr_user_id">
                        <strong>user ID: </strong><?php echo $result->id; ?>
                    </div>
                </div>
            </div>
        <?php endforeach;

        exit;
    }
    
    /**
     * Get Class Instance
     *
     * @return obj
     */
    public static function getInstance() {

        if( self::$instance === null ) {
            self::$instance = new SI_Ajax();
        }
        return self::$instance;

    }
}