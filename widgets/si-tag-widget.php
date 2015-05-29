<?php
class SI_Tag_Widget extends WP_Widget {
    
    public function SI_Tag_Widget() {
        $widget_ops = array('classname' => 'si_tag_widget', 'description' => __( 'A widget to display an Instagram Feed by Tag', 'si_feed' ));
        
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'si_tag_widget');
        
        $this->WP_Widget( 'si_tag_widget', __( 'Simple Instagram Tag Widget', 'si_tag' ), $widget_ops, $control_ops );
    }
    
    public function widget( $args, $instance ) {
        extract( $args );
        
        //Our variables from the widget settings.
        $title = apply_filters( 'widget_title', $instance['title'] );

        $count = $instance['count'];
        if( $count > 25 ) {
            $count = 25;
        }

        $tag = $instance['tag'];
        echo $before_widget;
        
        // Display the widget title
        if( $title )echo $before_title . $title . $after_title;
        
        $instagram = new SimpleInstagram();
        
        $feed = $instagram->getTaggedMedia( $tag, $count );

        if( !$feed || count( $feed ) == 0 ) {
            echo '';
            return;
        }
        
        $return = '<div class="si_feed_widget">';
        
        $return.= '<ul class="si_feed_list">';
        
        foreach( $feed as $image ) {
            
            $url = $image->images->standard_resolution->url;
            
            $url = str_replace( 'http://', '//', $url );
            
            $return.= '<li class="si_item">';
            
            $return.= '<a href="' . $image->link . '" target="_blank">';
            $return.= '<img src="' . $url . '">';
            $return.= '</a>';
            $return.= '</li>';
        }

        $return.= '</ul>';
        
        $return.= '</div>';
        
        echo $return;
        
        echo $after_widget;
    }
    
    
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['count'] = $new_instance['count'];
        $instance['tag'] = strip_tags( $new_instance['tag'] );
        return $instance;
    }
    
    public function form( $instance ) {
        
        $defaults = array('title' => __( 'From Instagram', 'simple-instagram' ), 'count' => __( '12', 'simple-instagram' ), 'tag' => __( 'food', 'simple-instagram' ));
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
            <label for="<?php echo $this->get_field_id( 'tag' ); ?>">
                <?php _e( 'Tag:', 'simple-instagram' ); ?>
            </label>
            <input 
                id="<?php echo $this->get_field_id( 'tag' ); ?>" 
                name="<?php echo $this->get_field_name( 'tag' ); ?>" 
                value="<?php echo $instance['tag']; ?>" 
                style="width:100%;" 
            />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>">
                <?php _e( 'Number of Images (25 Maximum):', 'simple-instagram' ); ?>
            </label>
            <input 
                id="<?php echo $this->get_field_id( 'count' ); ?>" 
                name="<?php echo $this->get_field_name( 'count' ); ?>" 
                value="<?php echo $instance['count']; ?>" 
                style="width:100%;" 
            />
        </p>

      <?php
    }

}