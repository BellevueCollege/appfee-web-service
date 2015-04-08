<?php
/**
 * Post authorization view class file
 *
 * This file contains the Post_Authorization_View class that extends the default
 * view.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage View
 * @since 1.0.0
 */

/**
 * Load the the default view class.
 */
require_once( 'default-view.php' );

/**
 * Defines the post authorization view
 *
 * This class defines the view to be used with payment authorization posts from
 * CyberSource.
 *
 * @since 1.0.0
 */
class Post_Authorization_View extends Default_View {

	/**
	 * Get output to display.
	 *
	 * Returns output that should be displayed.
	 *
	 * @since 1.0.0
	 */
	public function get_output() {
		$this->controller->process_data( $_POST );
		parent::get_output();
	}
}
