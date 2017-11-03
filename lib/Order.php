<?php
namespace paidjp;
class Order extends APIRequest {
	/**
	 * @author matico
	 * @param array $data = json_decode('{
          "b2bMemberId": "test_00001",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000000001"
        }', true);
	 * @return $result['status']==SUCCESS|ERROR
	 */
	public static function order($data){
		PaidLogger::info('--ORDER--');
		$requestOrderResponse = self::requestOrder($data);
		$response = $requestOrderResponse['status']==='SUCCESS'?self::confirmOrder($data):$requestOrderResponse;
		self::$result['status'] = $response['status'];
		if (self::$result['status']==='SUCCESS')
			self::$result['result']=$response['body'];
		else 
			self::$result['error']=$response['body'];
		PaidLogger::info('Result: ' . print_r(self::$result, true));
		return self::$result;
	}
	
	private static function requestOrder($data){
		$postData = array(
				'credits'=>array(
						'credit'=>array(
								$data
						)
				)
		);
		PaidLogger::info('Request order');
		return self::request(PAID_API_ORDER_PATH, $postData);
	}
	
	private static function confirmOrder($data){
		$postData = array(
				'credits'=>array(
						'credit'=>array(
								array(
										'b2bMemberId'=>$data['b2bMemberId'],
										'b2bCreditId'=>$data['b2bCreditId'],
										'price'=>$data['price']
								)
						)
				)
		);
		PaidLogger::info('Confirm order');
		return self::request(PAID_API_CONFIRM_ORDER_PATH, $postData);
	}
}