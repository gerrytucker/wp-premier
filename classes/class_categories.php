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
class Premier_Categories
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
     * Get categories
     * 
     * @return array
     */
    public function getCategories() 
    {

        $categories = get_categories(
            array(
                'hide_empty'    => false,
            )
        );

        $response = array();

        foreach ( $categories as $category ) {
            $response[] = array(
                'id'              => $category->cat_ID,
                'title'           => $category->cat_name,
            );
        }

        return $response;
    }

}
