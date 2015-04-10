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
 * Default model class file
 *
 * This file contains the Default_Model class.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Model
 * @since 1.0.0
 */

/**
 * Default model class defines the basic application model
 *
 * This class is usually extended but can be used when additional functionality
 * is not needed. It is used to store the bare minimum information needed to
 * implement a model within the application.
 *
 * @since 1.0.0
 */
class Default_Model {

	/**
	 * Stores error messages recorded by an controller.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string[]
	 */
	protected $errors;

	/**
	 * Default model constructor.
	 *
	 * Populates the $errors property.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->errors = array();
	}

	/**
	 * Add error messages to the errors property.
	 *
	 * Called by a controller to add error messages to the model.
	 *
	 * @since 1.0.0
	 * @see Default_Model::$errors
	 * @param string $error_message The message to be added to the errors
	 *                              property.
	 */
	public function add_error( $error_message ) {
		$this->errors[] = $error_message;
	}

	/**
	 * Return the error messages array property.
	 *
	 * Returns error messages recorded to the model's errors array property.
	 *
	 * @since 1.0.0
	 * @see Default_Model::$errors
	 * @return string[] Error messages recorded to the model.
	 */
	public function get_errors() {
		return $this->errors;
	}
}
