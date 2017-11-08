<?php
namespace paidjp;

class APIRequest {
	const REQUEST_STATUS_ERROR = 'ERROR';
	const ERROR_CODE_PARAM_INVALID = 'PARAM_INVALID';
	const ERROR_CODE_REQUEST_ERROR = 'REQUEST_ERROR';
	protected static $result = array('status'=>APIRequest::REQUEST_STATUS_ERROR,'result'=>null,'error'=>null);
	protected static function request($apiUrlPath, $postData){
		$postData = self::normalPostDataForRequest($postData);
		PaidLogger::info('Request body: ' . $postData);
		$result = array('status'=>'ERROR', 'body'=>array());
		$requestError = null;
		$response = self::callRequest($apiUrlPath, $postData, $requestError);
		if ($response===false) {
			$result['body'] = array('error'=>$requestError);
			return $result;
		}
		if(self::isRequestSuccess($response)){
			$responseData = json_decode($response->body, true);
			PaidLogger::info('Response body: ' . print_r($responseData, true));
			$result['body'] = self::getResponseResult($responseData);
			$result['status'] = self::getResponseStatus($responseData);
		}
		PaidLogger::info('Request result data: ' . print_r($result, true));
		return $result;
	}
	
	private static function normalPostDataForRequest(&$postData){
		return json_encode(array(
				'body'=>$postData,
				'header'=>array('apiAuthCode'=>PAID_API_AUTH_CODE)
		));
	}
	
	private static function callRequest($apiUrlPath, &$postData, &$error){
		try {
			return \Requests::post(self::getFullApiUrl($apiUrlPath), self::getHeader(), $postData);
		} catch (Exception $e) {
			$error = $e->getMessage();
			PaidLogger::error($error);
			return false;
		}
	}
	
	private static function getFullApiUrl($apiUrlPath){
		return PAID_API_DOMAIN. $apiUrlPath;
	}
	
	private static function getHeader(){
		return array('Content-Type'=>'application/json;charset=UTF-8');
	}
	private static function isRequestSuccess(&$response){
		PaidLogger::info('status_code: ' . $response->status_code);
		if ($response->status_code !== 200)
			return false;
		PaidLogger::info('content-type: ' . $response->headers['content-type']);
		return self::isJsonHeaderContentType($response->headers['content-type']);
	}
	
	private static function isJsonHeaderContentType($headerContentType){
		return strpos(strtolower($headerContentType), 'application/json')!==false;
	}
// 	{
// 		"body": {
// 		"result": {
// 		"paidId": "219551",
// 		"b2bMemberId": "matico_test_id_01"
// 		}
// 	},
// 	"header": {
// 		"path": "/coop/member/register/ver1.0/p.json",
// 		"status": "SUCCESS"
// 		}
// 	}
	private static function getResponseStatus(&$responseData){
		return $responseData['header']['status'];
	}
	
	private static function getResponseResult(&$responseData){
// 		return isset($responseData['body']['result'])?$responseData['body']['result']: // register case
// 		isset($responseData['body']['results'])?$responseData['body']['results']: // get user status case
// 		isset($responseData['body']['detailResults']['detailResult'])?$responseData['body']['detailResults']['detailResult'][0]: // order case 
// 		$responseData['body']; // others 
		return $responseData['body'];
	}
	
	protected static function validateParams($listRequiredParams, $params){
		foreach ($listRequiredParams as $requiredParam){
			if (!self::isValueIsNotEmptyInArray($requiredParam, $params)) {
				PaidLogger::info("Param: $requiredParam is INVALID");
				return $requiredParam;
			}
		}
		PaidLogger::info("Params are OK");
		return null;
	}
	
	protected static function isValueIsNotEmptyInArray($key, $array){
		return array_key_exists($key, $array)&&!self::isValueEmptyOrNull($array[$key]);
	}
	
	protected static function isValueEmptyOrNull($value){
		return is_null($value)||trim($value)==='';
	}
	
	protected static function checkKeyExistFromArray($key, $array){
		return isset($array) || array_key_exists($key, $array);
	}
	
	protected static function response(){
		PaidLogger::info('Result: ' . print_r(self::$result, true));
		return self::$result;
	}
}