<?php
/**
 * Default view class file
 *
 * This file contains the Default_View class.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage View
 * @since 1.0.0
 */

/**
 * Default view class defines the basic application view
 *
 * This class is usually extended but can be used when additional functionality
 * is not needed. It is used to define the bare minimum information needed to
 * implement a view within the application.
 *
 * @since 1.0.0
 */
class Default_View {

	/**
	 * Stores the controller object.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var object
	 */
	protected $controller;

	/**
	 * Stores the model object.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var object
	 */
	protected $model;

	/**
	 * Default view constructor.
	 *
	 * Populates the controller and model properties from the constructor
	 * parameters.
	 *
	 * @since 1.0.0
	 *
	 * @see Default_View::$controller
	 * @see Default_View::$model
	 *
	 * @param object $controller A controller object.
	 * @param object $model A model object.
	 */
	public function __construct( $controller, $model ) {
		$this->controller = $controller;
		$this->model = $model;
	}

	/**
	 * Get output to display.
	 *
	 * Returns output that should be displayed.
	 *
	 * @since 1.0.0
	 */
	public function get_output() {
		echo 'AppFee Web Service v' . VERSION_NUMBER;
	}
}
