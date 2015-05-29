<?php

/**
 * Simple Instagram Shortcodes Class
 *
 * Enqueues Shortcodes
 *
 * @package simple-instagram
 */

require_once( 'instagram.php' );

class SI_Shortcodes {
    
    private static $instance;
    
    function __construct() {

        add_shortcode( 'si_feed', array( $this, 'si_feed' ) );
        add_shortcode( 'si_popular', array( $this, 'si_popular' ) );
        add_shortcode( 'si_profile', array( $this, 'si_profile' ) );


    }

    public function si_feed( $atts ) {

        extract( shortcode_atts( array(
            'limit' => 10,
            'size' => 'medium',
            'wrapper' => 'div',
            'link' => 'true',
            'width' => 'auto',
            'tag' => '',
            'user' => 'self'
        ) , $atts ) );
        
        $instagram = new SimpleInstagram();
        
        $feed = $tag == '' ? $instagram->getUserMedia( $user, $limit ) : $instagram->getTaggedMedia( $tag, $limit );

        if( !$feed || count( $feed ) < 0 ) {
            return '';
        }

        $feed = $this->checkCount( $feed, $limit );
        
        $return = $this->getImageMarkup( $feed, $width, $size, $wrapper, $link );

        return $return;
    }

    public function si_popular( $atts ) {

        extract( shortcode_atts( array(
            'limit' => 16,
            'size' => 'medium',
            'wrapper' => 'div',
            'link' => 'true',
            'width' => 'auto'
        ) , $atts ) );
        
        $limit = $limit >= 16 ? 15 : $limit;
        
        $instagram = new SimpleInstagram();
        
        $feed = $instagram->getPopularMedia( $limit );

        if( !$feed || count( $feed ) == 0 ) {
            return '';
        }

        $feed = $this->checkCount( $feed, $limit );
        
        $return = $this->getImageMarkup( $feed, $width, $size, $wrapper, $link );
        
        return $return;
    }

    function si_profile( $atts ) {
        extract( shortcode_atts( array(
            'username' => 'true',
            'profile_picture' => 'true',
            'bio' => 'true',
            'website' => 'true',
            'full_name' => 'true',
            'themed' => 'false'
        ) , $atts ) );
        
        $instagram = new SimpleInstagram();
        
        $user = $instagram->getUser();

        if( !$user ) {
            return '';
        }
        
        $class = $themed == 'true' ? 'si_profile themed' : 'si_profile';

        $return = '<div class="' . $class . '">';
        
        if( $profile_picture == 'true' && $user->profile_picture != '' ) {
            $return.= '<div class="si_profile_picture">';
            $return.= '<img src="' . $user->profile_picture . '">';
            $return.= '</div>';
        }
        
        if( $username == 'true' && $user->username != '' ) {
            $return.= '<div class="si_username">' . $user->username . '</div>';
        }
        
        if( $full_name == 'true' && $user->full_name != '' ) {
            $return.= '<div class="si_full_name">' . $user->full_name . '</div>';
        }
        
        if( $bio == 'true' && $user->bio != '' ) {
            $return.= '<div class="si_bio">' . $user->bio . '</div>';
        }
        
        if( $website == 'true' && $user->website != '' ) {
            $return.= '<div class="si_website"><a href="' . $user->website . '">View Website</a></div>';
        }
        
        $return.= '</div>';
        
        return $return;
    }

    private function getImageMarkup( $feed, $width, $size, $wrapper, $link ) {

        $return = '<div class="si_feed">';
        
        $width = str_replace( 'px', '', $width );
        $w_param = '';

        if( $width != 'auto' ) {
            $width = $width > 612 ? 612 : $width;
            $w_param = 'width="' . $width . '" height="' . $width . '"';
        }
        
        if( $wrapper == 'li' ) {
            $return.= '<ul class="si_feed_list">';
        }
        
        foreach( $feed as $image ) {

            $url = $image->images->standard_resolution->url;

            if( $width == 'auto' ) {

                switch( $size ) {
                    case 'full':
                        $url = $image->images->standard_resolution->url;
                        break;

                    case 'medium':
                        $url = $image->images->low_resolution->url;
                        break;

                    case 'small':
                        $url = $image->images->thumbnail->url;
                        break;
                }

            }
            
            // Fix https
            $url = str_replace( 'http://', '//', $url );

            $return .= $wrapper == 'div' ? '<div class="si_item">' : '<li class="si_item">';
            
            $return .= $link == 'true' ? '<a href="' . $image->link . '" target="_blank">' : null;

            $return.= '<img src="' . $url . '" ' . $w_param . ' >';

            $return .= $link == 'true' ? '</a>' : null;
            
            $return .= $wrapper =='div' ? '</div>' : '</li>';

        }

        $return .= $wrapper == 'div' ? '</div>' : '</ul>';

        return $return;

    }

    private function checkCount( $feed, $limit ) {

        if( count( $feed ) > $limit ) {
            $feed = array_slice( $array, 0, $limit );
        }

        return $feed;
    }
    
    /**
     * Get Class Instance
     *
     * @return obj
     */
    public static function getInstance() {

        if( self::$instance === null ) {
            self::$instance = new SI_Shortcodes();
        }
        return self::$instance;
        
    }
}