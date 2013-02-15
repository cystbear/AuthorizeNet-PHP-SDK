<?php

/*
 * This file is part of the AuthorizeNet PHP-SDK package.
 *
 * For the full copyright and license information, please view the License.pdf
 * file that was distributed with this source code.
 */

error_reporting(E_ALL | E_STRICT);

require_once 'ClassLoader.php';
$loader = new Composer\Autoload\ClassLoader();
$loader->add('AuthorizeNet', dirname(__DIR__).'/src/');
$loader->register(true);

/**
 * Enter your test account credentials to run tests against sandbox.
 */
define("AUTHORIZENET_API_LOGIN_ID", "");
define("AUTHORIZENET_TRANSACTION_KEY", "");
define("AUTHORIZENET_MD5_SETTING", "");
define("AUTHORIZENET_SANDBOX", true);       // Set to false to test against production
/**
 * Enter your live account credentials to run tests against production gateway.
 */
define("MERCHANT_LIVE_API_LOGIN_ID", "");
define("MERCHANT_LIVE_TRANSACTION_KEY", "");

/**
 * Card Present Sandbox Credentials
 */
define("CP_API_LOGIN_ID", "");
define("CP_TRANSACTION_KEY", "");

// define("AUTHORIZENET_LOG_FILE", dirname(__FILE__) . "/log");
// Clear logfile
// file_put_contents(AUTHORIZENET_LOG_FILE, "");

if (!function_exists('curl_init')) {
    throw new Exception('AuthorizeNetSDK needs the CURL PHP extension.');
}
if (!function_exists('simplexml_load_file')) {
  throw new Exception('The AuthorizeNet SDK requires the SimpleXML PHP extension.');
}
if (AUTHORIZENET_API_LOGIN_ID == "") {
    die('Enter your merchant credentials in '.__FILE__.' before running the test suite.');
}
