<?php
namespace SU\Common;
use SU\Common\BaseController;
/*******************
** 基础ACTION入口
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class BaseAction{
	public $controller;
	/********************
	 * 初始化构造方法
	 * @params array $params
	 * @params object $controller
	 * @return ***
	 */
	final function __construct($params=null,&$controller=null){
		$this->controller=$controller?$controller:new BaseController();
		method_exists($this,'initialize') && $this->initialize($params);
	}
	/*******************
	 * 初始化加载
	 * @
	 */
	protected function initialize($params=null){
		method_exists($this,'init') && $this->init();
		method_exists($this,'run') && $this->run($params);
	}
	/********************
	 * 重置GET魔术方法
	 * @params string $name
	 * @return ***
	 */
	public function __get($name){
		$name=strtolower($name);
		$method='get'.ucfirst($name);
		if(method_exists($this,$name)){return $this->$name();}
		if(method_exists($this,$method)){return $this->$method();}
		#~~~~~~~~~~~~~~~
		if(isset($this->controller->$name) || method_exists($this->controller,$method)){return $this->controller->$name;}
		if(method_exists($this->controller,$method)){return $this->controller->$name();}
		return $this->controller->error('class named ('.get_class($this).') property '.$name.' or '.$method.' did`t exists !');
	}
	/********************
	 * 重置SET魔术方法
	 * @params string $name
	 * @params anytype $value
	 * @return ***
	 */
	public function __set($name,$value){
		$name=strtolower($name);
		$method='set'.ucfirst($name);
		if(method_exists($this,$name)){return $this->$name($value);}
		if(method_exists($this,$method)){return $this->$method($value);}
		#~~~~~~~~~~~~~~~
		if(isset($this->controller->$name) || method_exists($this->controller,$method)){return $this->controller->$name=$value;}
		if(method_exists($this->controller,$method)){return $this->controller->$name($value);}
		return $this->controller->error('class named ('.get_class($this).') property '.$name.' or '.$method.' did`t exists !');
	}
	/********************
	 * 重置CALL魔术方法
	 * @params string $method
	 * @params anytype $params
	 * @return ***
	 */
	public function __call($method,$params){	
		if(class_exists('Closure', false) && isset($this->$method) && $this->$method instanceof Closure){
			return call_user_func_array($this->$method, $params);
		}
		#~~~~~~~~~~~~~~~
		static $methods=null;
		!$methods && $methods=get_class_methods($this->controller);
		if(in_array($method,$methods) || class_exists('Closure', false) && isset($this->$method) && $this->$method instanceof Closure){
			return call_user_func_array(array($this->controller,$method),$params);
		}
		return $this->controller->error('class named ('.get_class($this).') method '.$method.' did`t exists !');
	}
}