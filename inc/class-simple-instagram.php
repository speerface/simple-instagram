<?php

class Simple_Instagram {

    private $api_url = 'https://api.instagram.com/v1',
            $access_token;

    function __construct() {

        $this->access_token = get_option( 'si_access_token' );

    }

    public function get_user() {

        $url = $this->api_url . '/users/self?access_token=' . $this->access_token;

        return $this->make_call( $url );

    }

    public function get_own_feed( $count = 6 ) {

        $url = $this->api_url . '/users/self/feed?access_token=' . $this->access_token . '&count=' . $count;

        return $this->make_call( $url );

    }

    public function get_user_media( $user, $count = 6 ) {

        $url = $this->api_url . '/users/' . $user . '/media/recent?access_token=' . $this->access_token . '&count=' . $count;

        return $this->make_call( $url );

    }

    public function get_tagged_media( $tag, $count = 6 ) {

        $url = $this->api_url . '/tags/' . $tag . '/media/recent?access_token=' . $this->access_token . '&count=' . $count;

        return $this->make_call( $url );

    }

    public function get_popular_media( $count = 6 ) {

        $url = $this->api_url . '/media/popular?access_token=' . $this->access_token . '&count=' . $count;

        return $this->make_call( $url );

    }

    public function get_user_id( $username ) {

        $url = $this->api_url . '/users/search?q=' . $username. '&access_token=' . $this->access_token;
        return $this->make_call( $url );

    }

    private function make_call( $url ) {

        $request = wp_remote_get( $url );
        $data = $this->parse_data( $request['body'] );

        return $data;

    }

    private function parse_data( $response ) {

        $return = json_decode( $response );
        if ( ! $return || is_null( $return ) || $return->meta->code == 400 ) {
            return false;
        }

        $data = $return->data;

        return $data;

    }

}