<?php
namespace paidjp;
use Katzgrau\KLogger;
date_default_timezone_set('GMT');
require(dirname(__FILE__) . '/kLogger/klogger.php');
class PaidLogger {
	private static $logger = null;
	private static $reqNo=null;
	private function __construct(){
		
	}
	private static function getLogger(){
		if (!PAID_API_ALLOW_LOG) return ;
		if (self::$logger===null){
			self::$logger = new KLogger(PAID_API_LOG_PATH, 10);
			self::$reqNo=self::generateReqNoRandomly();
		}
		return self::$logger;
	}
	private static function generateReqNoRandomly(){
		return rand(100,10000);
	}
	public static function info($message){
		if (!PAID_API_ALLOW_LOG) return ;
		self::getLogger()->logInfo(self::normalMessage($message));
	}
	public static function error($message){
		if (!PAID_API_ALLOW_LOG) return ;
		self::getLogger()->logError(self::normalMessage($message));
	}
	private static function normalMessage($orinMessage){
		return '['.self::$reqNo.'] '. $orinMessage;
	}
}