# The lib use for Yii Framework 1.x to communicate with paid.jp API for payment.
# How to use
1. Fetch source, put to vendors/ directory of your project
2. Some config for lib in: /config.php. See and update:
```
const PAID_API_AUTH_CODE = 'put_your_auth_code_here';
const PAID_API_LOG_PATH = 'your log path, eg: /tmp/paidlib/';
``` 
3. Require autoloader.php to your source
``` 
$userId='user_id_want_to_check_status';
$result = Account::checkStatus($userId);
``` 
# API Format will be return
```
print_r(self::$result, true)
===>
Array
(
    [status] => SUCCESS|CLIENT_ERROR|ERROR // success or error
    [result] => array() // data will be returned in success cases
    [error] => Array
        (
            [code] => REQUEST_ERROR|PARAM_INVALID // error when request or param is invalid
            [detail] => C01|b2bCreditId // error_code_from_paidjp or invalid param name
        )

)
```
# Example and testcases
Some examples and testcases see /tests/ dir