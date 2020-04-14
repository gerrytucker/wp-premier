<?php
/**
 * PHP version 7
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
 * Plugin Name:       WP Premier
 * Plugin URI:        https://scratbygardencentre.com/wp-content/plugins/wp-premier
 * GitHub Plugin URI: https://github.com/gerrytucker/wp-premier
 * Description:       WordPress Premier plugin
 * Version:           1.0.17
 * Author:            Gerry Tucker
 * Author URI:        https://gerrytucker@gerrytucker.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-nppp2u
 * Domain Path:       /languages
 */

require_once 'classes/class_posts.php';

/**
 * NPPP2U Plugin Functions
 * 
 * @category WordPress
 * @package  wp-premier
 * @author   Gerry Tucker <gerrytucker@gerrytucker.co.uk>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://scratbygardencentre.com
 * @since    1.0
 */
class WP_Premier
{

    // API Version
    const API_VERSION = 'premier/v2';

    /**
     * Set up the client
     * 
     * @return null
     */
    function __construct() 
    {
    }

    /**
     * Activate the plugin
     * 
     * @return null
     */
    public function activate() 
    {
    }

    /**
     * Create taxonomies
     * 
     * @return null
     */
    public function createTaxonomies() 
    {
        $labels = [
            'name'              => _x('Businesses', 'taxonomy general name'),
            'singular_name'     => _x('Business', 'taxonomy singular name'),
            'search_items'      => __('Search businesses'),
            'all_items'         => __('All Businesses'),
            'parent_item'       => __('Parent Business'),
            'parent_item_colon' => __('Parent Business:'),
            'edit_item'         => __('Edit Business'),
            'update_item'       => __('Update Business'),
            'add_new_item'      => __('Add New Business'),
            'new_item_name'     => __('New Business Name'),
            'menu_name'         => __('Business'),
        ];
        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'business'],
        ];
        register_taxonomy('business', ['post'], $args);
    }

    /**
     * Register API routes
     * 
     * @return null
     */
    public function registerApiHooks() 
    {

        self::registerPostRoutes();

    }        

    /**
     * Register customer function routes
     * 
     * @return null
     */
    public function registerPostRoutes() 
    {

        // Get posts
        register_rest_route(
            self::API_VERSION,
            'posts/',
            array(
                'methods'   => 'GET',
                'callback'  => array( 'WP_Premier', 'getPosts' )
            )
        );
    
        // Get post
        register_rest_route(
            self::API_VERSION,
            'post/(?<postid>\d+)',
            array(
                'methods'   => 'GET',
                'callback'  => array( 'WP_Premier', 'getPost' )
            )
        );
    
    }

    /**
     * Get posts
     *
     * @param WP_REST_Request $request Rest request
     * 
     * @return WP_REST_Response
     */
    static function getPosts( WP_REST_Request $request ) 
    {

        $wp = new Premier_Posts();

        if ($posts = $wp->getPosts() ) {
            return new WP_REST_Response($posts, 200);
        } else {
            // return an 404 empty result set
            return new WP_REST_Response(array(), 404);
        }
            
    }

    /**
     * Get post
     *
     * @param WP_REST_Request $request Rest request
     * 
     * @return WP_REST_Response
     */
    static function getPost( WP_REST_Request $request ) 
    {
        $postid = $request['postid'];

        $wp = new Premier_Posts();

        if ($post = $wp->getPost($postid) ) {
            return new WP_REST_Response($post, 200);
        } else {
            // return an 404 empty result set
            return new WP_REST_Response(array(), 404);
        }
            
    }

    /**
     * Initialize plugin
     * 
     * @return null
     */
    static function init() 
    {
        register_activation_hook(__FILE__, array( 'WP_Premier', 'activate' ));
        add_action('create_taxonomies', array('WP_Premier', 'createTaxonomies'));
        add_action('rest_api_init', array( 'WP_Premier', 'registerApiHooks' ));
    }

}

$wp_premier = new WP_Premier();
$wp_premier->init();
