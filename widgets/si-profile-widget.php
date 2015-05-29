<?php

require_once( SI_PLUGIN_DIR . '/inc/instagram.php' );

class SI_Profile_Widget extends WP_Widget {
    
    function SI_Profile_Widget() {
        $widget_ops = array('classname' => 'si_profile_widget', 'description' => __( 'A widget to display your Instagram Profile', 'si_profile' ));
        
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'si_profile_widget');
        
        $this->WP_Widget( 'si_profile_widget', __( 'Simple Instagram Profile Widget', 'si_profile' ), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {

        extract( $args );
        
        $title = apply_filters( 'widget_title', $instance['title'] );
        $profile_picture = $instance['profile_picture'];
        
        $username = $instance['username'];
        $full_name = $instance['full_name'];
        $bio = $instance['bio'];
        $website = $instance['website'];
        
        echo $before_widget;
        
        if( $title ) echo $before_title . $title . $after_title;
        
        $instagram = new SimpleInstagram();
        
        $user = $instagram->getUser();
        
        $return = '<div class="si_profile_widget">';
        
        if( $profile_picture == 'true' && $user->profile_picture != '' ) {
            
            $url = str_replace( 'http://', '//', $user->profile_picture );
            $return.= '<div class="si_profile_picture">';
            $return.= '<img src="' . $url . '">';
            $return.= '</div>';
        }
        
        $return.= $username == 'true' && $user->username != '' ? '<div class="si_username">' . $user->username . '</div>' : null;
        
        $return.= $full_name == 'true' && $user->full_name != '' ? '<div class="si_full_name">' . $user->full_name . '</div>' : null;
        
        $return.= $bio == 'true' && $user->bio != '' ? '<div class="si_bio">' . $user->bio . '</div>' : null;
        
        $return.= $website == 'true' && $user->website != '' ? '<div class="si_website"><a href="' . $user->website . '">View Website</a></div>' : null;
        
        $return.= '</div>';
        
        echo $return;
        
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['profile_picture'] = isset( $new_instance['profile_picture'] ) ? 'true' : 'false';
        $instance['username'] = isset( $new_instance['username'] ) ? 'true' : 'false';
        $instance['full_name'] = isset( $new_instance['full_name'] ) ? 'true' : 'false';
        $instance['bio'] = isset( $new_instance['bio'] ) ? 'true' : 'false';
        $instance['website'] = isset( $new_instance['website'] ) ? 'true' : 'false';
        
        return $instance;
    }

    function form( $instance ) {
        
        $defaults = array('title' => __( 'My Instagram Profile', 'simple-instagram' ));
        $instance = wp_parse_args( (array)$instance, $defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'simple-instagram' ); ?>
            </label>
            <input 
                id="<?php echo $this->get_field_id( 'title' ); ?>" 
                name="<?php echo $this->get_field_name( 'title' ); ?>" 
                value="<?php echo $instance['title']; ?>" 
                style="width:100%;" 
            />
        </p>

        <p>
            <label><?php _e( 'Include the Following:', 'simple-instagram' ); ?></label><br />
            <input type="checkbox" 
                name="<?php echo $this->get_field_name( 'profile_picture' ); ?>" 
                <?php if( isset( $instance['profile_picture'] ) && $instance['profile_picture'] == 'true' ) { echo 'checked="checked"'; } ?> /> 
                <?php _e( 'Profile Picture', 'simple-instagram' ); ?><br />
            <input type="checkbox" 
                name="<?php echo $this->get_field_name( 'username' ); ?>" 
                <?php if( isset( $instance['username'] ) && $instance['username'] == 'true' ) { echo 'checked="checked"'; } ?> /> 
                <?php _e( 'Username', 'simple-instagram' ); ?><br />
            <input type="checkbox" 
                name="<?php echo $this->get_field_name( 'full_name' ); ?>" 
                <?php if( isset( $instance['full_name'] ) && $instance['full_name'] == 'true' ) { echo 'checked="checked"'; } ?> /> 
                <?php _e( 'Full Name', 'simple-instagram' ); ?><br />
            <input type="checkbox" 
                name="<?php echo $this->get_field_name( 'bio' ); ?>" 
                <?php if( isset( $instance['bio'] ) && $instance['bio'] == 'true' ) { echo 'checked="checked"'; } ?> /> 
                <?php _e( 'Bio', 'simple-instagram' ); ?><br />
            <input type="checkbox" 
                name="<?php echo $this->get_field_name( 'website' ); ?>" 
                <?php if( isset( $instance['website'] ) && $instance['website'] == 'true' ) { echo 'checked="checked"'; } ?> /> 
                <?php _e( 'Website', 'simple-instagram' ); ?><br />
        </p>

      <?php
  }
  
}
