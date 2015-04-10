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
 * Get settlements controller class file
 *
 * This file contains the Get_Settlements_Controller class that extends the
 * default controller.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Controller
 * @since 1.0.0
 */

/**
 * Load the the default controller class.
 */
require_once( 'default-controller.php' );

/**
 * Defines the get settlements controller
 *
 * This class defines the controller to be used with getting settlement
 * information for outstanding transactions.
 *
 * @since 1.0.0
 */
class Get_Settlements_Controller extends Default_Controller {

	/**
	 * Process data related to transactions that have yet to be settled.
	 *
	 * Get transaction reference numbers that have missing settlement records
	 * and check if those references have been settled.
	 *
	 * @since 1.0.0
	 */
	public function process_data() {
		foreach ( $this->model->get_unsettled_reference_numbers_and_dates()
			as $reference_number => $reference_information
		) {
			$reference_date = $reference_information['0'];
			$authorized     = $reference_information['1'];
			$this->model->set_reference_number( $reference_number );
			$this->model->set_transaction_date( $reference_date );
			$this->model->get_transaction_report();
			if ( ! $authorized
				&& $this->model->get_biller_information_from_report()
			) {
				$this->model->save_data( true );
			}
			if ( $this->model->is_transaction_settled() ) {
				$this->model->save_data();
			}
		}
	}
}
