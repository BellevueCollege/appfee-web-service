<?php
/**
 * Controls URL name-space and routing for the application
 *
 * This file handles all http calls to the application and loads the appropriate
 * model, view, & controller for each URL request. It also defines the current
 * application version number.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @since 1.0.0
 */

/**
 * Load the user configurable constants.
 */
require( 'configuration.php' );

/**
 * Defines the application version number.
 *
 * @since 1.0.0
 * @var string
 */
define( 'VERSION_NUMBER', '0.1.0.0' );

// Set the timezone.
date_default_timezone_set( TIMEZONE );

$request_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$base_uri = rtrim( BASE_URI, '/' ) . '/';

// Check to make sure we are hosted out of the correct directory.
if ( $base_uri !== substr( $request_uri, 0, strlen( $base_uri ) ) ) {
	$error_message = 'The BASE_URI constant does not match the requested '
		. 'URI. Please review the configuration.php file and set BASE_URI to '
		. 'the appropriate path'
	;
	throw new Exception( $error_message );
}

// Redirect to HTTPS if the request is made over HTTP.
if ( ! isset( $_SERVER['HTTPS'] ) ) {
	$url = 'https://' . $request_host . $request_uri;
	header( $_SERVER['SERVER_PROTOCOL'] . ' Moved Permanently' );
	header( 'Location: ' . $url );
	exit();
}

$application_uri = substr( $request_uri, strlen( $base_uri ) );

/*
 * If the first namespace after the $base_uri does not match the SHARED_SECRET
 * then print the application name and version.
 */
if ( SHARED_SECRET !== substr( $application_uri,
			0, strlen( SHARED_SECRET )
		)
) {
	/**
	 * Load class file for Post Authorization View.
	 */
	require( 'view/default-view.php' );
	$view = new Default_View( null, null );
	echo $view->get_output();
	exit();
}

$application_request = substr( $application_uri, strlen( SHARED_SECRET ) + 1 );

switch ( $application_request ) {
	case 'post-authorization':
		/**
		 * Load class file for Post Authorization Model.
		 */
		require( 'model/post-authorization-model.php' );

		/**
		 * Load class file for Post Authorization Controller.
		 */
		require( 'controller/post-authorization-controller.php' );

		/**
		 * Load class file for Post Authorization View.
		 */
		require( 'view/post-authorization-view.php' );

		// Model view controller objects.
		$model = new Post_Authorization_Model(
			DATABASE_DSN,
			DATABASE_USER,
			DATABASE_PASSWORD
		);
		$controller = new Post_Authorization_Controller( $model );
		$view       = new Post_Authorization_View( $controller, $model );

		// Get output
		echo $view->get_output();
		break;

		default:
			/**
			 * Load class file for Post Authorization View.
			 */
			require( 'view/default-view.php' );
			$view = new Default_View( null, null );
			echo $view->get_output();
}
