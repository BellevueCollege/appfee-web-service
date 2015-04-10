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
 * AppFee web service sample configuration file
 *
 * Defines constants used by the end user to configure the application for their
 * environment. This file should be populated with the appropriate values and
 * saved under the file name configuration.php
 *
 * @copyright 2015 Bellevue College
 * @license GNU General Public License, version 2
 * @link https://github.com/BellevueCollege/appfee
 * @package AppFee-WebService
 * @subpackage Configuration
 * @since 1.0.0
 */

/**
 * Defines the base URI where the application is being hosted.
 *
 * @since 1.0.0
 * @var string
 */
define( 'BASE_URI', '' );

/**
 * The CyberSource merchant identification.
 *
 * @since 1.0.0
 * @var string
 */
define( 'CYBERSOURCE_MERCHANT_ID', '' );

/**
 * CyberSource user name with access to reports.
 *
 * @since 1.0.0
 * @var string
 */
define( 'CYBERSOURCE_REPORT_USER', '' );

/**
 * CyberSource report user password.
 *
 * @since 1.0.0
 * @var string
 */
define( 'CYBERSOURCE_REPORT_PASSWORD', '' );

/**
 * CyberSource report query URL.
 *
 * @since 1.0.0
 * @var string
 */
define( 'CYBERSOURCE_REPORT_URL', '' );

/**
 * Defines the data source name (database connection parameters).
 *
 * @since 1.0.0
 * @var string
 */
define( 'DATABASE_DSN', '' );

/**
 * Defines the user name to use when connecting to the data source.
 *
 * @since 1.0.0
 * @var string
 */
define( 'DATABASE_USER', '' );

/**
 * Defines the password to use when connecting to the data source.
 *
 * @since 1.0.0
 * @var string
 */
define( 'DATABASE_PASSWORD', '' );

/**
 * Defines the shared secret that will be used in the application URL.
 *
 * @since 1.0.0
 * @var string
 */
define( 'SHARED_SECRET', '' );

/**
 * Defines the local timezone.
 *
 * @since 1.0.0
 * @var string
 */
define( 'TIMEZONE', '' );
