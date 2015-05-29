<?php 

class SimpleInstagram {

    private $api_url = 'https://api.instagram.com/v1',
            $access_token;

    function __construct() {

        $this->access_token = get_option( 'si_access_token' );

    }

    public function getUser() {

        $url = $this->api_url . '/users/self?access_token=' . $this->access_token;
        
        return $this->makeCall( $url );

    }

    public function getOwnFeed( $count = 6 ) {

        $url = $this->api_url . '/users/self/feed?access_token=' . $this->access_token . '&count=' . $count;
        
        return $this->makeCall( $url );

    }

    public function getUserMedia( $user, $count = 6 ) {

        $url = $this->api_url . '/users/' . $user . '/media/recent?access_token=' . $this->access_token . '&count=' . $count;
        
        return $this->makeCall( $url );

    }

    public function getTaggedMedia( $tag, $count = 6 ) {

        $url = $this->api_url . '/tags/' . $tag . '/media/recent?access_token=' . $this->access_token . '&count=' . $count;
        
        return $this->makeCall( $url );

    }

    public function getPopularMedia( $count = 6 ) {

        $url = $this->api_url . '/media/popular?access_token=' . $this->access_token . '&count=' . $count;
        
        return $this->makeCall( $url );

    }

    public function getUserId( $username ) {

        $url = $this->api_url . '/users/search?q=' . $username. '&access_token=' . $this->access_token;
        return $this->makeCall( $url );

    }

    private function makeCall( $url ) {

        $request = wp_remote_get( $url );
        $data = $this->parseData( $request['body'] );

        return $data;

    }

    private function parseData( $response ) {


        $return = json_decode( $response );
        if( !$return || is_null( $return ) || $return->meta->code == 400 ) {
            return false;
        }

        $data = $return->data;

        return $data;

    }

}