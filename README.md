# AppFee Web Service

The AppFee Web Service handles POST confirmations from
[CyberSource](http://www.cybersource.com/) that confirm transaction
authorization from their [Secure Acceptance Web/Mobile]
(http://www.cybersource.com/products/payment_security/secure_acceptance_web_mobile/)
service and gathers the transaction settlement status using CyberSource XML
reports.

This application implements database stored procedures that rely on the database
table defined in the main application
[AppFee](https://github.com/BellevueCollege/appfee).

## Configuration

When deploying this web service you must provide a valid configuration.php file.
The [configuration-sample.php](./appfee-web-service/configuration-sample.php)
file is provided as a template.

### BASE_URI

The directory that the application is hosted from.

**If application URL is**

http://www.example.local/web_service/appfee-web-service

**Base URI will be**

/web_service/appfee-web-service

### CYBERSOURCE_MERCHANT_ID

Your merchant id that you use to identify yourself with CyberSource. This is
also the same merchant id that you use when logging into the CyberSource
Business Center.

### CYBERSOURCE_REPORT_USER

A username that has been configured in the CyberSource Business Center
with the *Report Download* role.

### CYBERSOURCE_REPORT_PASSWORD

The password to use with the *CYBERSOURCE_REPORT_USER*.

### CYBERSOURCE_REPORT_URL

The CyberSource report URL to use to query a *On‑Demand Single Transaction
Report* for settlement data.

*Production:* https://ebc.cybersource.com/ebc/Query

*Test:* https://ebctest.cybersource.com/ebctest/Query

*CyberSource Documentation:* [Requesting a Report With a Query API]
(http://apps.cybersource.com/library/documentation/dev_guides/Reporting_Developers_Guide/html/wwhelp/wwhimpl/js/html/wwhelp.htm#href=downloading.04.2.html)

### DATABASE_DSN

The data source name (DSN) to use for data connections.

*Example:* dblib:host=mssql.example.local:1433\OptionalInstanceName;dbname=Database

*PHP Documentation:* [PDO Drivers](https://php.net/manual/en/pdo.drivers.php)

### DATABASE_USER

User string to use when authenticating to the data source.

### DATABASE_PASSWORD

Password to use with the user string to authenticate to the data source.

### SHARED_SECRET

Used as a prefix name space to obscure the application's functional name spaces.

### TIMEZONE

Timezone to use for time calculations.

*PHP Documentation:* [List of Supported Timezones]
(https://php.net/manual/en/timezones.php)

## Application Usage

This application exposes two main name spaces */post-authorization* and
*/get-settlements*. Both of these name spaces are accessed with the
*SHARED_SECRET* found in the configuration file.

The shared secret is implemented to avoid discovery of the post authorization
URL. As CyberSource does not provide a security implementation around it's HTTP
POST mechanism, the shared secret provides obscurity to make the
post-authorization URL hard to guess.

### Post Authorization

This handles posts coming directly from CyberSource. This URL must be configured
in the CyberSource Business Center. Once configured CyberSource will use this
URL to post live order information, the web service uses this information to
update database records so that order information is kept up to date.

*URL Example:* https://www.example.local/**\[SHARED_SECRET\]**/post-authorization

### Get Settlements

This URL should be configured to be requested at an interval from a local
systems. For example using cron + wget.

When this URL is requested the application queries CyberSource with outstanding
orders and receives their settlement status. If the order is settled the web
service will update the appropriate database columns.

*URL Example:* https://www.example.local/**\[SHARED_SECRET\]**/get-settlements
