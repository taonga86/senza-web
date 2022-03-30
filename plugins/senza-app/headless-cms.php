<?php
/**
 * Plugin Name: Senza app
 * Description: A WordPress plugin that adds features to use WordPress as a headless CMS with any front-end environment using REST API
 * Plugin URI:  https://ecovisuel.ch
 * Author:      Taonga Banda
 * Author URI:  Ecovisuel
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     2.0.0
 * Text Domain: ecovisuel-headless-wordpress
 *
 * @package ecovisuel-headless-wordpress
 */

define( 'HEADLESS_CMS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'HEADLESS_CMS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'HEADLESS_CMS_BUILD_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/build' );
define( 'HEADLESS_CMS_BUILD_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/build' );
define( 'HEADLESS_CMS_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once HEADLESS_CMS_PATH . '/inc/helpers/autoloader.php';
require_once HEADLESS_CMS_PATH . '/inc/helpers/custom-functions.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function headless_cms_features_plugin_loader() {
	\Headless_CMS\Features\Inc\Plugin::get_instance();
}

headless_cms_features_plugin_loader();

function add_subscriptions_menu() {
    add_submenu_page('woocommerce','Subscriptions','Subscriptions', 'manage_options', 'edit.php?post_type=subscription');
}

// Change the 30 to customise item's order within WooCommerce submenu.
add_action( 'admin_menu', 'add_subscriptions_menu', 30 );

define('GRAPHQL_JWT_AUTH_SECRET_KEY','>)c/9M~lr4}~kscK_0r9X5q~q2GjKRslox*4/VSG+ c+3ZgtZomRv:^r^_:^;%JX');
define('JWT_AUTH_SECRET_KEY', 'a1*@:VH[2T9RuH2aKC`uC`X 3ApkCP{-A-y*5)|29fFBRFH[0PcgQ_Nx?FCKR1-d');
	define('JWT_AUTH_CORS_ENABLE', true);
////


use WPGraphQL\AppContext;
use WPGraphQL\Model\Subscription;


// the important part for ACF mutations specifically and also in general for input actions.
// adds the input fields for the ACF fields to add, or just general fields you would want to add.
add_action( 'graphql_input_fields', function ( $fields, $type_name, $config ) {
	//todo also create user input requires this
	if ( $type_name === 'CreateSubscriptionInput' ) {
		$fields = array_merge( $fields, [
			//  add the fields to the input element of the update user input type.
			'userId'   => [ 'type' => 'String' ],
			'orderFreq' => [ 'type' => 'Number' ],
			'pickUpDay'  => [ 'type' => 'Number' ],
			'items'  => [ 'type' => 'String' ],
		] );
	}
	// todo create and update
	// this type name can be found by looking at what type of input is given in mutations on graphql
	if ( $type_name === 'UpdateSubscriptionInput' ) {
		$fields = array_merge( $fields, [
			//  add the fields to the input element of the update user input type.
			// simple string created in ACF
			'userId'   => [ 'type' => 'String' ],
			'orderFreq' => [ 'type' => 'Number' ],
			'pickUpDay'  => [ 'type' => 'Number' ],
			'items'  => [ 'type' => 'String' ],
		] );
	}

	return $fields;
}, 20, 3 );

// what happens when mutation contains any of the input fields when mutating user info, todo check if create works
add_action( 'graphql_subscription_object_mutation_update_additional_data', function ( $user_id, $input, $mutation_name, $context, $info ) {
	if ( isset( $input['userId'] ) ) {
		// Consider other sanitization if necessary and validation such as which
		// user role/capability should be able to insert this value, etc.
		update_user_meta( $user_id, 'userId', $input['userId'] );
	}
	if ( isset( $input['orderFreq'] ) ) {
		// Consider other sanitization if necessary and validation such as which
		// user role/capability should be able to insert this value, etc.
		update_user_meta( $user_id, 'orderFreq', $input['orderFreq'] );
	}
	if ( isset( $input['pickUpDay'] ) ) {
		// Consider other sanitization if necessary and validation such as which
		// user role/capability should be able to insert this value, etc.
		update_user_meta( $user_id, 'pickUpDay', $input['pickUpDay'] );
	}
	if ( isset( $input['items'] ) ) {
		// Consider other sanitization if necessary and validation such as which
		// user role/capability should be able to insert this value, etc.
		update_user_meta( $user_id, 'items', $input['items'] );
	}
}, 10, 5 );

