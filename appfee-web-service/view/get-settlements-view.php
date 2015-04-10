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
