<?php
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
