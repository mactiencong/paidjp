<?php
namespace paidjp;

class APIRequest {
	protected static $result = array('status'=>'ERROR','result'=>null,'error'=>null);
	public static function request($apiUrlPath, $postData){
		$postData = json_encode(array(
				'body'=>$postData,
				'header'=>array('apiAuthCode'=>PAID_API_AUTH_CODE)
		));
		PaidLogger::info('Request body: ' . $postData);
		$response = \Requests::post(self::getFullApiUrl($apiUrlPath), self::getHeader(), $postData);
		$result = array('status'=>'ERROR', 'body'=>array());
		if(self::isRequestSuccess($response)){
			$responseData = json_decode($response->body, true);
			PaidLogger::info('Response body: ' . print_r($responseData, true));
			$result['body'] = self::getResponseResult($responseData);
			$result['status'] = self::getResponseStatus($responseData);
		}
		PaidLogger::info('Response data: ' . print_r($result, true));
		return $result;
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
}