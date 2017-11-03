<?php
namespace paidjp;
class Account extends APIRequest {
// 	{
// 		"body": {
// 		"memberData": {
// 		"b2bMemberId": "matico_test_id_01",
// 		"companyName": "株式会社ラクーン",
// 		"companyNameKana": "カブシキガイシャラクーン",
// 		"representativeSei": "代表",
// 		"representativeMei": "者名",
// 		"representativeSeiKana": "ダイヒョウ",
// 		"representativeMeiKana": "シャメイ",
// 		"zipCode": "103-0014",
// 		"prefecture": "東京都",
// 		"address1": "中央区",
// 		"address2": "日本橋蛎殻町 1-18-11",
// 		"clerkSei": "登録",
// 		"clerkMei": "確認",
// 		"clerkSeiKana": "トウロク",
// 		"clerkMeiKana": "カクニン",
// 		"tel": "03-5652-1692",
// 		"fax": "03-5652-1691",
// 		"email": "mactiencong@gmail.com",
// 		"establishedYear": "2010",
// 		"establishedMonth": "4",
// 		"annualSales": "1200",
// 		"businessDetailType": "10",
// 		"dealingBrand": "テストブランド",
// 		"shopCount": "100",
// 		"url1": "http://google.com"
// 		}
// 	},
// 	"header": {
// 	"apiAuthCode": "eec6b5739dd9aecfff7bd5cf8fac5b2c"
// 	}
// 	}
	/**
	 * Register user
	 * @author matico
	 * @param array $data format view in AccountTest.php
	 * @return $result['status']==SUCCESS|ERROR|CLIENT_ERROR
	 */
	public static function register($data){
		PaidLogger::info('--REGISTER--');
		$postData = array('memberData'=>$data);
		self::$result = array('status'=>'ERROR','result'=>null,'error'=>null);
		$response = self::request(PAID_API_REGISTER_PATH, $postData);
		self::$result['status'] = $response['status'];
		if (self::$result['status']==='SUCCESS')
			self::$result['result']=self::registerNormalResultData($response['body']);
		else 
			self::$result['error']=self::registerGetErrorCode($response['body']);
		PaidLogger::info('Result: ' . print_r(self::$result, true));
		return self::$result;
	}
	
	private static function registerNormalResultData($responseBodyData){
		return $responseBodyData['result'];
	}
	
	private static function registerGetErrorCode($responseBodyData){
		return $responseBodyData['result']['error'];
	}
	
	/**
	 * @author matico
	 * @param string $userId
	 * @return $result['status']==SUCCESS|ERROR|CLIENT_ERROR
	 */
	public static function checkStatus($userId){
		PaidLogger::info('--CHECK STATUS--');
		$response = self::request(PAID_API_GET_USER_STATUS_PATH, array('b2bMemberIds'=>array($userId)));
		self::$result['status'] = $response['status'];
		if ($response['status']==='SUCCESS')
			self::$result['result']['memberStatusCode'] = self::checkStatusGetMemberStatusCode($userId, $response['body']);
		else 
			self::$result['error'] = self::checkStatusGetErrorCode($userId, $response['body']);
		PaidLogger::info('Result: ' . print_r(self::$result, true));
		return self::$result;
	}
	
	private static function checkStatusGetMemberStatusCode($userId, $responseBodyData){
		if (self::checkKeyExistFromArray('successes', $responseBodyData['results'])) {
			foreach ($responseBodyData['results']['successes'] as $success){
				if ($success['b2bMemberId']===$userId) return $success['memberStatusCode'];
			}
		}
		return null;
	}
	
	private static function checkStatusGetErrorCode($userId, $responseBodyData){
		if (self::checkKeyExistFromArray('errors', $responseBodyData['results'])) {
			foreach ($responseBodyData['results']['errors'] as $success){
				if ($success['b2bMemberId']===$userId) return $success['error'];
			}
		}
		return null;
	}
	
	private static function checkKeyExistFromArray($key, $array){
		return isset($array) || array_key_exists($key, $array);
	}
}