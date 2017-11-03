<?php
require(dirname(__FILE__) . '/config.php');
require(dirname(__FILE__) . '/lib/Requests/library/Requests.php');
Requests::register_autoloader();
require(dirname(__FILE__) . '/lib/PaidLogger.php');
require(dirname(__FILE__) . '/lib/APIRequest.php');
require(dirname(__FILE__) . '/lib/Account.php');
require(dirname(__FILE__) . '/lib/Order.php');