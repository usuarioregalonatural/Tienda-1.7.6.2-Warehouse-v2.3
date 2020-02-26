<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class UtilsElementor {

    public static function is_development_mode() {
        return false;
    }

    public static function get_edit_link( $post_id = 0 ) {
        return 'edit link';
    }

    public static function is_post_type_support( $post_id = 0 ) {
        return true;
    }

    public static function get_placeholder_image_src() {
        return ELEMENTOR_ASSETS_URL . 'images/placeholder.png';
    }

    public static function generate_random_string( $length = 7 ) {
        $salt = 'abcdefghijklmnopqrstuvwxyz';
        return substr( str_shuffle( str_repeat( $salt, $length ) ), 0, $length );
    }

    public static function get_youtube_id_from_url( $url ) {
        preg_match( '/^.*(?:youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/', $url, $video_id_parts );

        if ( empty( $video_id_parts[1] ) ) {
            return false;
        }

        return $video_id_parts[1];
    }

}
