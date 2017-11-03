<?php

namespace paidjp;
class AccountTest extends TestCase
{

    public function testRegister()
    {   
    	$data = json_decode('{
		"b2bMemberId": "test_00001",
		"companyName": "株式会社ラクーン",
		"companyNameKana": "カブシキガイシャラクーン",
		"representativeSei": "代表",
		"representativeMei": "者名",
		"representativeSeiKana": "ダイヒョウ",
		"representativeMeiKana": "シャメイ",
		"zipCode": "103-0014",
		"prefecture": "東京都",
		"address1": "中央区",
		"address2": "日本橋蛎殻町 1-18-11",
		"clerkSei": "登録",
		"clerkMei": "確認",
		"clerkSeiKana": "トウロク",
		"clerkMeiKana": "カクニン",
		"tel": "03-5652-1692",
		"fax": "03-5652-1691",
		"email": "mactiencong@gmail.com",
		"establishedYear": "2010",
		"establishedMonth": "4",
		"annualSales": "1200",
		"businessDetailType": "10",
		"dealingBrand": "テストブランド",
		"shopCount": "100",
		"url1": "http://google.com"
		}', true);
    	$response = Account::register($data);
    	$this->assertSame('SUCCESS', $response['status']);
    }
    
    public function testRegisterWithExistUser()
    {
    	$data = json_decode('{
		"b2bMemberId": "maticotest",
		"companyName": "株式会社ラクーン",
		"companyNameKana": "カブシキガイシャラクーン",
		"representativeSei": "代表",
		"representativeMei": "者名",
		"representativeSeiKana": "ダイヒョウ",
		"representativeMeiKana": "シャメイ",
		"zipCode": "103-0014",
		"prefecture": "東京都",
		"address1": "中央区",
		"address2": "日本橋蛎殻町 1-18-11",
		"clerkSei": "登録",
		"clerkMei": "確認",
		"clerkSeiKana": "トウロク",
		"clerkMeiKana": "カクニン",
		"tel": "03-5652-1692",
		"fax": "03-5652-1691",
		"email": "mactiencong@gmail.com",
		"establishedYear": "2010",
		"establishedMonth": "4",
		"annualSales": "1200",
		"businessDetailType": "10",
		"dealingBrand": "テストブランド",
		"shopCount": "100",
		"url1": "http://google.com"
		}', true);
    	$response = Account::register($data);
    	$this->assertSame('CLIENT_ERROR', $response['status']);
    }
    
    public function testGetStatusWithNotConfirmedUser()
    {
    	$userId = 'test_00001';
    	$response = Account::checkStatus($userId);
    	$this->assertSame('SUCCESS', $response['status']);
    }
    
    public function testGetStatusWithConfirmUser()
    {
    	$userId = 'maticotest';
    	$response = Account::checkStatus($userId);
    	$this->assertSame('SUCCESS', $response['status']);
    }
    
    public function testGetStatusWithNotExistUser()
    {
    	$userId = 'notexist';
    	$response = Account::checkStatus($userId);
    	$this->assertSame('CLIENT_ERROR', $response['status']);
    }
}