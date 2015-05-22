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
 * Post authorization controller class file
 *
 * This file contains the Post_Authorization_Controller class that extends the
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
 * Defines the post authorization controller
 *
 * This class defines the controller to be used with payment authorization posts
 * from CyberSource.
 *
 * @since 1.0.0
 */
class Post_Authorization_Controller extends Default_Controller {

	/**
	 * Process HTTP post data and save it to the model object.
	 *
	 * Takes an array of key values (usually from HTTP post) and saves values
	 * from the array to a model object.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     Array of key values usually passed in from the PHP $_POST variable.
	 *
	 *     @type string $decision             Transaction decision.
	 *     @type string $req_reference_number Transaction reference number.
	 *     @type string $req_bill_to_email    Optional. Billing email address.
	 *     @type string $req_bill_to_forename Optional. Billing first name.
	 *     @type string $req_bill_to_phone    Optional. Billing phone number.
	 *     @type string $req_bill_to_surname  Optional. Billing last name.
	 * }
	 *
	 * @return boolean True if the post fields are populated (even if invalid),
	 *                 false if the post fields are not populated correctly.
	 */
	public function process_data( $post_array ) {
		if ( empty( $post_array['decision'] )
			|| empty( $post_array['req_reference_number'] )
		) {
			return false;
		}

		$transaction_decision = $post_array['decision'];
		if ( 'ACCEPT' !== $transaction_decision ) {
			return false;
		}

		$reference_number = $post_array['req_reference_number'];
		$email_address    = null;
		$first_name       = null;
		$last_name        = null;
		$phone_number     = null;
		if ( ! empty( $post_array['req_bill_to_email'] ) ) {
			$email_address = $post_array['req_bill_to_email'];
		}
		if ( ! empty( $post_array['req_bill_to_forename'] ) ) {
			$first_name = $post_array['req_bill_to_forename'];
		}
		if ( ! empty( $post_array['req_bill_to_surname'] ) ) {
			$last_name = $post_array['req_bill_to_surname'];
		}
		if ( ! empty( $post_array['req_bill_to_phone'] ) ) {
			$phone_number = $post_array['req_bill_to_phone'];
		}

		$this->model->set_billing_email( $email_address );
		$this->model->set_billing_first_name( $first_name );
		$this->model->set_billing_last_name( $last_name );
		$this->model->set_billing_phone_number( $phone_number );
		$this->model->set_reference_number( $reference_number );
		$this->model->save_data();

		return true;
	}
}
