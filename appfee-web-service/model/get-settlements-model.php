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
 * Get settlements model class file
 *
 * This file contains the Get_Settlements_Model class that extends the post
 * authorization model.
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Model
 * @since 1.0.0
 */

/**
 * Load the the post authorization model class.
 */
require_once( 'post-authorization-model.php' );

/**
 * Defines the get settlements model
 *
 * This class defines the model to be used with getting settlement information
 * for outstanding transactions.
 *
 * @since 1.0.0
 */
class Get_Settlements_Model extends Post_Authorization_Model {

	/**
	 * cURL resource.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $curl_resource;

	/**
	 * Array to use for querying a report.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array $args {
	 *     @type string $merchantID              Merchant identification.
	 *     @type string $merchantReferenceNumber maps to {@see Post_Authorization_Model::$reference_number}
	 *     @type string $subtype                 Report sub-type.
	 *     @type string $targetDate              maps to {@see Get_Settlements_Model::$transaction_date}
	 *     @type string $type                    Report type.
	 *     @type string $versionNumber           Version number of the report.
	 * }
	 */
	protected $report_post_array;

	/**
	 * XML results of last report query.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $report_xml;

	/**
	 * Date the transaction took place in YYYYMMDD format.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $transaction_date;

	/**
	 * Get settlements model constructor.
	 *
	 * Calls the parent's constructor and populates some object properties.
	 *
	 * @since 1.0.0
	 *
	 * @see Get_Settlements_Model::$curl_resource
	 * @see Get_Settlements_Model::$report_post_array
	 *
	 * @param object $database_configuration Database configuration object.
	 * @param object $reports_configuration  Reports configuration object.
	 */
	public function __construct(
		$database_configuration,
		$reports_configuration
	) {
		parent::__construct( $database_configuration );

		$this->report_post_array = array(
			'merchantID' => $reports_configuration->get_merchant_id(),
			'merchantReferenceNumber' => &$this->reference_number,
			'subtype' => 'transactionDetail',
			'targetDate' => &$this->transaction_date,
			'type' => 'transaction',
			'versionNumber' => '1.7',
		);

		// Setup the cURL resource
		$this->curl_resource = curl_init( $reports_configuration->get_url() );
		curl_setopt( $this->curl_resource, CURLOPT_POST, true );
		curl_setopt( $this->curl_resource, CURLOPT_RETURNTRANSFER, true );
		$report_credentials = $reports_configuration->get_username()
			. ':'
			. $reports_configuration->get_password()
		;
		curl_setopt(
			$this->curl_resource,
			CURLOPT_USERPWD,
			$report_credentials
		);
	}

	/**
	 * Get settlements model destructor.
	 *
	 * Close open resource before destroying the object.
	 *
	 * @since 1.0.0
	 *
	 * @see Get_Settlements_Model::$curl_resource
	 */
	public function __destruct() {
		curl_close( $this->curl_resource );
	}

	/**
	 * Get billing information from the transaction report.
	 *
	 * Get the billing information such as name and email address from the
	 * transaction report and populate the appropriate class attributes.
	 *
	 * @since 1.0.0
	 *
	 * @see Post_Authorization_Model::$billing_email
	 * @see Post_Authorization_Model::$billing_first_name
	 * @see Post_Authorization_Model::$billing_last_name
	 * @see Post_Authorization_Model::$billing_phone_number
	 *
	 * @return boolean True if any properties were set from the transaction
	 *                 report.
	 */
	public function get_biller_information_from_report() {
		$biller_information_set = false;
		$this->set_billing_email( null );
		$this->set_billing_first_name( null );
		$this->set_billing_last_name( null );
		$this->set_billing_phone_number( null );
		if ( ! isset( $this->report_xml ) ) {
			return $biller_information_set;
		}

		$report = new SimpleXMLElement( $this->report_xml );
		if ( ! empty( $report->Requests->Request->BillTo->Email ) ) {
			$email = (string) $report->Requests->Request->BillTo->Email;
			$this->set_billing_email( $email );
			$biller_information_set = true;
		}
		if ( ! empty( $report->Requests->Request->BillTo->FirstName ) ) {
			$first_name =
				(string) $report->Requests->Request->BillTo->FirstName
			;
			$this->set_billing_first_name( $first_name );
			$biller_information_set = true;
		}
		if ( ! empty( $report->Requests->Request->BillTo->LastName ) ) {
			$last_name = (string) $report->Requests->Request->BillTo->LastName;
			$this->set_billing_last_name( $last_name );
			$biller_information_set = true;
		}
		if ( ! empty( $report->Requests->Request->BillTo->Phone ) ) {
			$phone_number = (string) $report->Requests->Request->BillTo->Phone;
			$this->set_billing_phone_number( $phone_number );
			$biller_information_set = true;
		}

		return $biller_information_set;
	}

	/**
	 * Get the transaction report.
	 *
	 * Get transaction report based on the reference number and transaction date
	 * properties.
	 *
	 * @since 1.0.0
	 *
	 * @see Get_Settlements_Model::$report_xml
	 *
	 * @return string XML transaction report.
	 */
	public function get_transaction_report() {
		$post_parameters = http_build_query( $this->report_post_array );
		curl_setopt(
			$this->curl_resource,
			CURLOPT_POSTFIELDS,
			$post_parameters
		);
		$report      = curl_exec( $this->curl_resource );
		$status_code = curl_getinfo( $this->curl_resource, CURLINFO_HTTP_CODE );
		if ( 200 === $status_code ) {
			$this->report_xml = $report;
		} else {
			$this->report_xml = false;
		}
		return $this->report_xml;
	}

	/**
	 * Get unsettled reference numbers and the dates they were created or
	 * authorized.
	 *
	 * Get reference numbers that have not been settled and their respective
	 * creation dates or the authorization date if it exists.
	 *
	 * @since 1.0.0
	 *
	 * @return array Key equals the reference number and value equals an array
	 *               with the date as element 0 and a boolean as element 1 set
	 *               to true if the transaction has been authorized.
	 */
	public function get_unsettled_reference_numbers_and_dates() {
		$references = array();
		$tsql = 'EXEC dbo.usp_WebAppFeeGetEmptySettlementReferences;';
		$query = $this->database_connection->prepare( $tsql );
		$query->execute( $this->save_data_values );
		while ( $results = $query->fetch() ) {
			$reference_number       = $results['ReferenceNumber'];
			$date_reference_created = $results['ReferenceNumberCreation'];
			$authorized             = false;
			if ( isset( $results['PaymentAuthorization'] ) ) {
				$date_reference_created = $results['PaymentAuthorization'];
				$authorized             = true;
			}
			$references[ $reference_number ] = array(
				$date_reference_created,
				$authorized,
			);
		}
		return $references;
	}

	/**
	 * Check if transaction has been settled.
	 *
	 * Evaluate the XML report to determine if the transaction has been settled.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean True if transaction is settled and false if not.
	 */
	public function is_transaction_settled() {
		if ( ! isset( $this->report_xml ) ) {
			return false;
		}

		$report = new SimpleXMLElement( $this->report_xml );
		if ( isset( $report->Requests->Request->PaymentData->EventType )
			&& 'TRANSMITTED' ==
				$report->Requests->Request->PaymentData->EventType
		) {
			return true;
		}

		return false;
	}

	/**
	 * Save settlement or authorization information to the data source.
	 *
	 * Save settlement information or authorization information to the data
	 * source.
	 *
	 * @since 1.0.0
	 *
	 * @param boolean $record_authorization Optional. If true attempt to save
	 *                                      authorization data.
	 */
	public function save_data( $record_authorization = false ) {
		if ( $record_authorization ) {
			$this->save_data_values['payment_status'] = 'AUTHORIZED';
			parent::save_data();
		} else {
			$this->save_data_values['payment_status'] = 'SETTLED';
			parent::save_data();
		}
	}

	/**
	 * Set the transaction date.
	 *
	 * Helper method that sets the transaction date.
	 *
	 * @since 1.0.0
	 *
	 * @param integer|string $date The date as string or UNIX epoch integer.
	 *
	 * @return boolean True if date was set false if not.
	 */
	public function set_transaction_date( $date ) {
		$format = 'Ymd';
		if ( is_int( $date ) ) {
			$this->transaction_date = gmdate( $format, $date );
		} elseif ( is_string( $date ) ) {
			$epoch_time = strtotime( $date );
			$this->transaction_date = gmdate( $format, $epoch_time );
		} else {
			return false;
		}

		return true;
	}
}
