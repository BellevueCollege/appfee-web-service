<?php
/**
 * Get settlements view class file
 *
 * This file contains the Get_Settlements_View class that extends the default
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
 * Defines the get settlements view
 *
 * This class defines the view to be used with getting settlement information
 * for outstanding transactions.
 *
 * @since 1.0.0
 */
class Get_Settlements_View extends Default_View {

	/**
	 * Get output to display.
	 *
	 * Returns output that should be displayed.
	 *
	 * @since 1.0.0
	 */
	public function get_output() {
		$this->controller->process_data();
		parent::get_output();
	}
}
