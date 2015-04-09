<?php
/**
 * Configuration class structures file
 *
 * This file contains configuration class structures with class constants to
 * group similar configuration settings together from configuration.php
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Configuration
 * @since 1.0.0
 */

/**
 * Load the user configurable constants.
 */
require( 'configuration.php' );

/**
 * Database configuration settings
 *
 * Contains configuration constants for database settings.
 *
 * @since 1.0.0
 */
class Database_Configuration {

	/**
	 * Data source name (database connection parameters).
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const DATA_SOURCE_NAME = DATABASE_DSN;

	/**
	 * Password to use with the data source.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const PASSWORD = DATABASE_PASSWORD;

	/**
	 * User name to use with the data source.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const USERNAME = DATABASE_USER;

	/**
	 * Get the data source name (DSN).
	 *
	 * Helper method that returns the DATA_SOURCE_NAME property.
	 *
	 * @since 1.0.0
	 * @see Database_Configuration::DATA_SOURCE_NAME
	 * @return string Data source name (DSN).
	 */
	function get_data_source_name() {
		return self::DATA_SOURCE_NAME;
	}

	/**
	 * Get the password.
	 *
	 * Helper method that returns the PASSWORD property.
	 *
	 * @since 1.0.0
	 * @see Database_Configuration::PASSWORD
	 * @return string Password.
	 */
	function get_password() {
		return self::PASSWORD;
	}

	/**
	 * Get the user name.
	 *
	 * Helper method that returns the USERNAME property.
	 *
	 * @since 1.0.0
	 * @see Database_Configuration::USERNAME
	 * @return string User name.
	 */
	function get_username() {
		return self::USERNAME;
	}
}

/**
 * CyberSource report settings
 *
 * Contains configuration constants for retrieving reports from CyberSource.
 *
 * @since 1.0.0
 */
class CyberSource_Report_Configuration {

	/**
	 * CyberSource merchant identification.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const MERCHANT_ID = CYBERSOURCE_MERCHANT_ID;

	/**
	 * CyberSource report user password.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const PASSWORD = CYBERSOURCE_REPORT_PASSWORD;

	/**
	 * CyberSource report query URL.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const URL = CYBERSOURCE_REPORT_URL;

	/**
	 * CyberSource report user name.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const USERNAME = CYBERSOURCE_REPORT_USER;

	/**
	 * Get the CyberSource merchant ID.
	 *
	 * Helper method that returns the MERCHANT_ID property.
	 *
	 * @since 1.0.0
	 * @see CyberSource_Report_Configuration::MERCHANT_ID
	 * @return string CyberSource merchant identification.
	 */
	function get_merchant_id() {
		return self::MERCHANT_ID;
	}

	/**
	 * Get the CyberSource report user password.
	 *
	 * Helper method that returns the PASSWORD property.
	 *
	 * @since 1.0.0
	 * @see CyberSource_Report_Configuration::PASSWORD
	 * @return string Report user password.
	 */
	function get_password() {
		return self::PASSWORD;
	}

	/**
	 * Get the CyberSource report query URL.
	 *
	 * Helper method that returns the URL property.
	 *
	 * @since 1.0.0
	 * @see CyberSource_Report_Configuration::URL
	 * @return string Report query URL.
	 */
	function get_url() {
		return self::URL;
	}

	/**
	 * Get the CyberSource report user name.
	 *
	 * Helper method that returns the USERNAME property.
	 *
	 * @since 1.0.0
	 * @see CyberSource_Report_Configuration::USERNAME
	 * @return string Report user name.
	 */
	function get_username() {
		return self::USERNAME;
	}
}
