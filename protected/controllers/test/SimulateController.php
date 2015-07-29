<?php
namespace VE\Controllers;
use VE\Common\BackendController;

class SimulateController extends BackendController{
    public function initialize(){
    	$this->tag->setTitle("后台管理");
       parent::initialize();
	   $this->api_cookie = $_SERVER['DOCUMENT_ROOT'].'/protected/runtime/api_cookie_test.tmp';
    }
    public function indexAction(){
		$verifycodeId=self::verifycodeId();
		$_SESSION['verifycodeId']=$verifycodeId;
		$this->render('simulate/index',array('verifycodeid'=>$verifycodeId,'verify'=>$verify));
    }

	public function loginAction(){
		$arr=array(
			'url'=>'http://passport.uc108.com/login.aspx?mode=1',
			'post'=>'0',
			'header'=>'0',
			'postfields'=>'',
			'cookiejar' =>$this->api_cookie,
			'cookiefile'=>$this->api_cookie,
			'postfields'=>array(
				'username'=>'人丑只能多读书',
				'password'=>'060850abc',
				'verifyCode'=>$this->post('verifyCode'),
				'verifycodeid'=>$this->post('verifycodeid'),
			),
			'httpheader'=>array(
				'Accept'=>'application/json, text/javascript, */*; q=0.01',
				'Accept-Encoding'=>'gzip, deflate',
				'Accept-Language'=>'zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
				'Cache-Control'=>'no-cache',
				'Connection'=>'keep-alive',
				'Content-Type'=>'application/x-www-form-urlencoded; charset=GBK',
				'Pragma'=>'no-cache',
				'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36',
				'X-Requested-With'=>'XMLHttpRequest',
				'Host'=>'passport.uc108.com',
				'Origin'=>'http://shengzhou.108sq.com',
				'Referer'=>'http://shengzhou.108sq.com/User/Login',
			),
		);
		$db_curl=self::curl_get_contents($arr);
		print_r($db_curl);die();
	}
	private static function verify(){
		$url='http://passport.uc108.com/ValidateCode.aspx?CodeID='.$_SESSION['verifycodeId'];
		header("Content-type: image/jpeg;");
		$arr=array(
			'url'=>$url,
			'post'=>'0',
			'header'=>'0',
			'postfields'=>'',
			'cookiejar' =>'',
			'cookiefile'=>'',
			'httpheader'=>array(
				'Accept'=>'image/png,image/*;q=0.8,*/*;q=0.5',
				'Accept-Encoding'=>'gzip, deflate',
				'Accept-Language'=>'zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
				'Connection'=>'keep-alive',
				'Host'=>'regcheckcode.taobao.com',
				'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36',
				'Host'=>'passport.uc108.com',
				'Referer'=>'http://shengzhou.108sq.com/User/Login',
			)
		);
		$data = self::curl_get_contents($arr);
		echo $data;
	}
	private static function verifycodeId(){
		$url='http://passport.uc108.com/getvalidatecode.aspx?rt=1&r=0.'.self::randomkeys();
		$arr=array(
			'url'=>$url,
			'post'=>'0',
			'header'=>'0',
			'httpheader'=>array(
				'Accept'=>'image/png,image/*;q=0.8,*/*;q=0.5',
				'Accept-Encoding'=>'gzip, deflate',
				'Accept-Language'=>'zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
				'Connection'=>'keep-alive',
				'Host'=>'regcheckcode.taobao.com',
				'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36',
				'Host'=>'passport.uc108.com',
				'Referer'=>'http://shengzhou.108sq.com/User/Login',
			)
		);
		$data = self::curl_get_contents($arr);
		preg_match('/\"(.*)\"/',$data,$match);
		return @$match[1];
	}
	private static function randomkeys($length=16){
		$pattern='123456789';$key='';
		for($i=0;$i<$length;$i++){$key .= $pattern{mt_rand(0,8)};}
		return $key;
	}
	public static function curl_get_contents($arg=array()){
		if(!is_array($arg) || count($arg)<1){$arg=array('url'=>'http://www.baidu.com/');}
		$arr_set=array();
		foreach($arg as $key=>&$v){
			$key=strtolower($key);
			$arr_set[$key]=$v;
		}
		$arr_opt=array(
			'timeout'    =>array(CURLOPT_TIMEOUT),
			'url'        =>array(CURLOPT_URL),
			'header'     =>array(CURLOPT_HEADER,0),
			'post'       =>array(CURLOPT_POST,0),
			'postfields' =>array(CURLOPT_POSTFIELDS),
			'referer'    =>array(CURLOPT_REFERER),
			'useragent'  =>array(CURLOPT_USERAGENT),
			'httpheader' =>array(CURLOPT_HTTPHEADER),
			'cookiejar'  =>array(CURLOPT_COOKIEJAR),
			'cookiefile' =>array(CURLOPT_COOKIEFILE),
			'ssl_verifyhost'  =>array(CURLOPT_SSL_VERIFYHOST,2),
			'ssl_verifypeer'  =>array(CURLOPT_SSL_VERIFYPEER,false),  //CURLINFO_SSL_VERIFYRESULT - 通过设置CURLOPT_SSL_VERIFYPEER返回的SSL证书验证请求的结果
			'ssl_verifyresult'=>array(CURLINFO_SSL_VERIFYRESULT,true),
			'connecttimeout'  =>array(CURLOPT_CONNECTTIMEOUT,120),
			'returntransfer'  =>array(CURLOPT_RETURNTRANSFER,true),
		);
		$ci=curl_init();
		foreach($arr_opt as $key=>&$opt){
			$is_set=isset($arr_set[$key]);
			if(isset($opt[1]) || $is_set!=''){
				$value=($is_set?$arr_set[$key]:$opt[1]);
				if($key=='postfields' && is_array($value) && count($value)>0){
					$_v='';
					foreach($value as $k=>$v){$_v.="&$k=$v";}
					$value=ltrim($_v,'&');
				}
				curl_setopt($ci,$opt[0],$value);
			}
		}
		$data = curl_exec($ci);
		curl_close($ci);
		return $data;
	}

}