<?php
/**
 * PHP Version 7
 * 
 * WP-Premier Plugin Functions
 * 
 * @category WordPress
 * @package  wp-premier
 * @author   Gerry Tucker <gerrytucker@gerrytucker.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://scratbygardencentre.com
 */

/**
 * WP-Premier Plugin Functions
 * 
 * @category WordPress
 * @package  wp-premier
 * @author   Gerry Tucker <gerrytucker@gerrytucker.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://scratbygardencentre.com
 * @since    2.0.0
 */
class Premier_Posts
{

    /**
     * Version 
     */
    const VERSION = "1.0";

    /**
     * Set up the client
     * 
     * @return null
     */
    public function __construct() 
    {
    }

    /**
     * Get posts
     * 
     * @return array
     */
    public function getPosts() 
    {

        $posts = get_posts(
            array(
                'numberposts'  => -1
            )
        );

        $response = array();

        foreach ( $posts as $post ) {
            // Get post thumbnail
            $thumbnail = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'thumbnail', false
            );
            $medium = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'medium', false
            );
            $large = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'large', false
            );
  
            $response[] = array(
                'id'              => $post->ID,
                'title'            => $post->post_title,
                'link'            => '/post/' . $post->ID, 
                'thumbnail_url'   => $thumbnail[0],
                'medium_url'      => $medium[0],
                'large_url'       => $large[0],
            );
        }

        return $response;
    }

    /**
     * Get posts
     * 
     * @return array
     */
    public function getPost($postid) 
    {

        $posts = get_posts(
            array(
                'post__in' => array($postid)
            )
        );

        $response = array();

        foreach ( $posts as $post ) {
            // Get post thumbnail
            $thumbnail = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'thumbnail', false
            );
            $medium = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'medium', false
            );
            $large = wp_get_attachment_image_src(
                get_post_thumbnail_id($post->ID), 'large', false
            );
  
            $response[] = array(
                'id'              => $post->ID,
                'title'            => $post->post_title,
                'author'          => get_the_author_meta('display_name', $post->post_author),
                'content'         => apply_filters('the_content', $post->post_content),
                'date'            => get_the_date(get_option('date_format'), $post->ID),
                'link'            => '/post/' . $post->ID,
                'thumbnail_url'   => $thumbnail[0],
                'medium_url'      => $medium[0],
                'large_url'       => $large[0],
            );
        }

        return $response;
    }

}
