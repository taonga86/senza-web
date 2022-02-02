<?php
/**
 * Get_Wishlist class.
 *
 * @package headless-cms
 */

namespace Headless_CMS\Features\Inc\Queries;

use Headless_CMS\Features\Inc\Traits\Singleton;

/**
 * Class Get_Wishlist
 */
class Register_Dreams {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Action
		 */

		// Register dreams type.
        add_action( 'init', 'cptui_register_my_cpts_dream' );

	}
    public function cptui_register_my_cpts_dream() {

        /**
         * Post Type: dreams.
         */
    
        $labels = [
            "name" => __( "dreams", "storefront" ),
            "singular_name" => __( "dream", "storefront" ),
            "menu_name" => __( "Produits favoris", "storefront" ),
        ];
    
        $args = [
            "label" => __( "dreams", "storefront" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => false,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => false,
            "delete_with_user" => true,
            "exclude_from_search" => true,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => [ "slug" => "dream", "with_front" => true ],
            "query_var" => true,
            "menu_icon" => "dashicons-heart",
            "supports" => [ "custom-fields", "author" ],
            "show_in_graphql" => true,
            "graphql_single_name" => "dream",
            "graphql_plural_name" => "dreams",
        ];
    
        register_post_type( "dream", $args );
    }
    

    

}
