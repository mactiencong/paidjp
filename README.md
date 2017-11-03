# The lib use for Yii Framework 1.x
# The lib communicate with paid.jp API for payment.

# How to use
1. Fetch source, put to vendors/ directory of your project
2. Some config for lib in: /config.php. See and update:
- const PAID_API_AUTH_CODE = 'put_your_auth_code_here';
- const PAID_API_LOG_PATH = 'your log path, eg: /tmp/paidlib/';
3. Require autoloader.php to your source
# Example and testcases
Some example and testcases see /tests/ dir
