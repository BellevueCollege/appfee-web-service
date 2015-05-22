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
 * Post authorization model class file
 *
 * This file contains the Post_Authorization_Model class that extends the
 * default model.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Model
 * @since 1.0.0
 */

/**
 * Load the the default model class.
 */
require_once( 'default-model.php' );

/**
 * Defines the post authorization model
 *
 * This class defines the model to be used with payment authorization posts from
 * CyberSource.
 *
 * @since 1.0.0
 */
class Post_Authorization_Model extends Default_Model {

	/**
	 * The billing email address.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $billing_email;

	/**
	 * The billing first name.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $billing_first_name;

	/**
	 * The billing last name.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $billing_last_name;

	/**
	 * The billing phone number.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $billing_phone_number;

	/**
	 * A PDO Object.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var PDO
	 */
	protected $database_connection;

	/**
	 * Array map of CyberSource field name keys to class property variable
	 * values.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array $args {
	 *     @type string $billing_email maps to {@see Post_Authorization_Model::$billing_email}
	 *     @type string $billing_first_name maps to {@see Post_Authorization_Model::$billing_first_name}
	 *     @type string $billing_last_name maps to {@see Post_Authorization_Model::$billing_last_name}
	 *     @type string $billing_phone maps to {@see Post_Authorization_Model::$billing_phone_number}
	 *     @type string $payment_status Set to either AUTHORIZED or SETTLED
	 *     @type string $reference_number maps to {@see Post_Authorization_Model::$reference_number}
	 * }
	 */
	protected $save_data_values;

	/**
	 * The transaction reference number.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reference_number;

	/**
	 * Post authorization model constructor.
	 *
	 * Calls the parent's constructor and populate the database_connection
	 * property.
	 *
	 * @since 1.0.0
	 *
	 * @see Post_Authorization_Model::$database_connection
	 * @see Post_Authorization_Model::$save_data_values
	 *
	 * @param object $database_configuration Database configuration object.
	 */
	public function __construct( $database_configuration ) {
		parent::__construct();

		$this->database_connection = new PDO(
			$database_configuration->get_data_source_name(),
			$database_configuration->get_username(),
			$database_configuration->get_password()
		);

		$this->save_data_values = array(
			'reference_number'   => &$this->reference_number,
			'payment_status'     => 'AUTHORIZED',
			'billing_first_name' => &$this->billing_first_name,
			'billing_last_name'  => &$this->billing_last_name,
			'billing_email'      => &$this->billing_email,
			'billing_phone'      => &$this->billing_phone_number,
		);
	}

	/**
	 * Save student information to the data source and set the reference number.
	 *
	 * Save student information such as first name, last name, date of birth,
	 * program of study, etc. to the data source. Also receive the transaction
	 * reference number from the database.
	 *
	 * @since 1.0.0
	 *
	 * @see Post_Authorization_Model::$billing_email
	 * @see Post_Authorization_Model::$billing_first_name
	 * @see Post_Authorization_Model::$billing_last_name
	 * @see Post_Authorization_Model::$billing_phone_number
	 * @see Post_Authorization_Model::$database_connection
	 * @see Post_Authorization_Model::$reference_number
	 */
	public function save_data() {
		$tsql = 'EXEC dbo.usp_WebAppFeeUpdatePayment'
			. ' @ReferenceNumber = :reference_number,'
			. ' @PaymentStatus = :payment_status,'
			. ' @BillingFirstName = :billing_first_name,'
			. ' @BillingLastName = :billing_last_name,'
			. ' @BillingEmail = :billing_email,'
			. ' @BillingPhoneNumber = :billing_phone'
			. ';'
		;
		$query = $this->database_connection->prepare( $tsql );
		$query->execute( $this->save_data_values );
	}

	/**
	 * Set the billing email address.
	 *
	 * Helper method that sets the billing email address.
	 *
	 * @since 1.0.0
	 * @see Post_Authorization_Model::$billing_email
	 * @param string $billing_email Billing contact's email address.
	 */
	public function set_billing_email( $billing_email ) {
		$this->billing_email = $billing_email;
	}

	/**
	 * Set the billing first name.
	 *
	 * Helper method that sets the billing first name.
	 *
	 * @since 1.0.0
	 * @see Post_Authorization_Model::$billing_first_name
	 * @param string $billing_first_name Billing contact's first name.
	 */
	public function set_billing_first_name( $billing_first_name ) {
		$this->billing_first_name = $billing_first_name;
	}

	/**
	 * Set the billing last name.
	 *
	 * Helper method that sets the billing last name.
	 *
	 * @since 1.0.0
	 * @see Post_Authorization_Model::$billing_last_name
	 * @param string $billing_last_name Billing contact's last name.
	 */
	public function set_billing_last_name( $billing_last_name ) {
		$this->billing_last_name = $billing_last_name;
	}

	/**
	 * Set the billing phone number.
	 *
	 * Helper method that sets the billing phone number.
	 *
	 * @since 1.0.0
	 * @see Post_Authorization_Model::$billing_phone_number
	 * @param string $billing_phone_number Billing contact's phone number.
	 */
	public function set_billing_phone_number( $billing_phone_number ) {
		$this->billing_phone_number = $billing_phone_number;
	}

	/**
	 * Set the reference number.
	 *
	 * Helper method that sets the reference number.
	 *
	 * @since 1.0.0
	 * @see Post_Authorization_Model::$reference_number
	 * @param string $reference_number Transaction reference number.
	 */
	public function set_reference_number( $reference_number ) {
		$this->reference_number = $reference_number;
	}
}
