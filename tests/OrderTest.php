<?php

namespace paidjp;
class OrderTest extends TestCase
{
	
	public function testOrderWithNotConfirmedUser()
	{
		$data = json_decode('{
          "b2bMemberId": "test_00001",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000000001"
        }', true);
		$response = Order::order($data);
		$this->assertSame('ERROR', $response['status']);
	}
	
	public function testOrderWithB2bMemberIdIsEmpty()
	{
		$data = json_decode('{
          "b2bMemberId": " ",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000000001"
        }', true);
		$response = Order::order($data);
		$this->assertSame('ERROR', $response['status']);
		$this->assertSame('PARAM_INVALID', $response['error']['code']);
	}
	
	public function testOrderWithConfirmedUser()
	{
		$data = json_decode('{
          "b2bMemberId": "maticotest",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000n000101323"
        }', true);//000000010131
		$response = Order::order($data);
		$this->assertSame('SUCCESS', $response['status']);
	}
	
	public function testOrderWithDuplicateB2bCreditId()
	{
		$data = json_decode('{
          "b2bMemberId": "maticotest",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000000010131"
        }', true);
		$response = Order::order($data);
		$this->assertSame('ERROR', $response['status']);
	}
	
	public function testOrderWithNotExistUser()
	{
		$data = json_decode('{
          "b2bMemberId": "notexist",
          "contents": "test",
          "code": "1234567",
          "price": "1000",
          "b2bCreditId": "000009810131"
        }', true);
		$response = Order::order($data);
		$this->assertSame('ERROR', $response['status']);
	}
}
