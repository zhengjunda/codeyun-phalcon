<?php
namespace SU\Common;
/*******************
** 校验有效类入口
** @update time: 2015-02-18
** @author: zhengjunda
** @
**/
class Validate{
	/*******************
	 * intialize __construct
	 * @
	 */
	private $controller=null;
	public function __construct($controller=null){
		$controller && !$this->controller && $this->controller=$controller;
	
	}
	/*******************
	 * import validate the api_sign 
	 * @
	 */
	public static function apiSign($params=null){
		if($params=='' || !isset($params['app']) || !isset($params['api_sign']) || !self::loadKey($params['app'])){return false;}
		$apiSign=$params['api_sign'];
		$apiKey=self::loadKey($params['app']);
		$clientTime = $params['timestamp'];
		unset($params['api_sign'],$params['callback'],$params['_'],$params['m'],$params['c'],$params['a']);
		#~~~~~~~~~~~~~~~~~~~
		#--获取转译后apiSigns
		#~~~~~~~~~~~~~~~~~~~
		$server_time = $_SERVER['REQUEST_TIME'];
		$params['timestamp'] = $server_time - $server_time%600;
		$api_sign_time = self::createSign($params,$apiKey);
		#~~~~~~~~~~~~~~~~~~~
		unset($params['timestamp']);
		$api_sign_notime = self::createSign($params,$apiKey);
		$apiSigns = array($api_sign_time,$api_sign_notime);
		#~~~~~~~~~~~~~~~~~~~
		#--比较输出
		#~~~~~~~~~~~~~~~~~~~
		if(!in_array($apiSign,$apiSigns)){
			return false;
		}else{return true;}
	}
	/*******************
	 * import create Sign
	 * @
	 */
	protected static function createSign($params,$api_key){
		if(!$params || !$api_key) return false;
		ksort($params);
		$dictionary = '';
		foreach ($params as $val) {
			$dictionary .= $val;
		}
		$dictionary .= $api_key;
		$api_sign = md5($dictionary);
		return $api_sign;
	}
	/*******************
	 * import loadKey
	 * @
	 */
	private static function loadKey($key){
		if(!$key) return false;
		static $apiKey=null;
		$apiKey==null && $apiKey=self::loadConfig();
		return $apiKey[$key];
	}
	/*******************
	 * import create config
	 * @
	 */
	private static function loadConfig(){
		return array(
			'android' => 'fda1153b300e1a8cae00c4a6fe295743',
			'ios'     => '30d3ea847974682659462332f254af1b',
			'web'	  => '2e68f9496918c949bc3b5a10fd27d49a',
			'h5'	  => '5899ac7839178f62ffc97dbfe1f88b50',
			'default' => 'd484feef4f6e564920fabd0de3c58d77',
		);
	}
}