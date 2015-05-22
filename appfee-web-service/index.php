<?php
/*
 * AppFee Web Service
 * Copyright (C) 2015 Bellevue College
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

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
 * Load configuration structures.
 */
require( 'include/configuration-structures.php' );

/**
 * Defines the application version number.
 *
 * @since 1.0.0
 * @var string
 */
define( 'VERSION_NUMBER', '1' );

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

		// Configuration objects.
		$database_configuration = new Database_Configuration();

		// Model view controller objects.
		$model      = new Post_Authorization_Model( $database_configuration );
		$controller = new Post_Authorization_Controller( $model );
		$view       = new Post_Authorization_View( $controller, $model );

		// Get output
		echo $view->get_output();
		break;

	case 'get-settlements':
		/**
		 * Load class file for Get Settlements Model.
		 */
		require( 'model/get-settlements-model.php' );

		/**
		 * Load class file for Get Settlements Controller.
		 */
		require( 'controller/get-settlements-controller.php' );

		/**
		 * Load class file for Get Settlements View.
		 */
		require( 'view/get-settlements-view.php' );

		// Configuration objects.
		$database_configuration = new Database_Configuration();
		$reports_configuration  = new CyberSource_Report_Configuration();

		// Model view controller objects.
		$model = new Get_Settlements_Model(
			$database_configuration,
			$reports_configuration
		);
		$controller = new Get_Settlements_Controller( $model );
		$view       = new Get_Settlements_View( $controller, $model );

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
