<?php
namespace SU\Common;
use CController;
/*******************
** 基础控制器入口
** @update time: 2015-02-23
** @author: zhengjunda
** @
**/
class BaseController extends CController{
	/*******************
	 * 初始化加载
	 * @
	 */
	protected function initialize(){
		if(method_exists($this,'beforeController')){
			$dispatcher=$this->di('dispatcher');
			$controller=$dispatcher->getActiveController();
			$this->beforeController($controller);
		}
		method_exists($this,'init') && $this->init();

	}
	/*******************
	 * 定义get方法($_GET($name))
	 * @param string $name 
	 * @return mixed
	 */
	public function get($name=null){
		if($name==null){return $this->request->get();}
		if(is_string($name) && $name!=''){return $this->request->get($name);}
		if(is_array($name) && count($name)>1){
			$return=array();$request=$this->request->get();
			foreach($name as &$v){
				is_string($v) && trim($v)!='' && $return[]=@$request[$v];
			}
			return $return;
		}
		return null;
	}
	/*******************
	 * 定义post方法($_POST($name))
	 * @param string $name
	 * @return mixed
	 */
	public function post($name=null){
		if($name==null){return $this->request->getPost();}
		if(is_string($name) && $name!=''){return $this->request->getPost($name);}
		if(is_array($name) && count($name)>1){
			$return=array();$request=$this->request->getPost();
			foreach($name as &$v){
				is_string($v) && trim($v)!='' && $return[]=@$request[$v];
			}
			return $return;
		}
		return null;
	}
	/*******************
	 * 定义render方法(视图渲染)
	 * @param string $name
	 * @param array $params
	 */
	public function render($name=null,$params=null,$exit=false){
		if($name=='' || !is_string($name)){return null;}
		$names=preg_split('/[\.\/]/',$name);
		if(count($names)==1){
			$controller=$this->di->get('router')->getControllerName();
			$name=($controller!=''?$controller:'index').'/'.$name;
		}
		if(is_array($params) && count($params)>0){
			foreach($params as $k=>&$v){$this->assign($k,$v);}
		}
		$this->view->partial($name);//render pick
	}
	/*******************
	 * 定义assign方法(注册视图变量)
	 * @param string $name
	 * @param array or string $params
	 */
	public function assign($name='',$params=null){
		if($name=='' || !is_string($name)){return null;}
		$this->view->setVar($name,$params);
	}
	/*******************
	 * 定义redirect方法(重定向地址)
	 * @param string $uri
	 */
	public function redirect($uri=''){
		if(!is_string($uri) || $uri==''){return false;}
		$this->response->redirect($uri);
	}
	/*******************
	 * 定义forward方法
	 * @param string $uri
	 * @param array $params
	 * @
	 */
	public function forward($uri='',$params=array()){
    	$args = explode('/',$uri);
		$forward=array();
		count($args)>2 && $forward['module']=$args[0];
		$forward['controller']=	count($args)>2?$args[1]:@$args[0];
		$forward['action']=	count($args)>2?$args[2]:@$args[1];
		$forward['params']=	is_string($params)?array($params):$params;
    	$this->dispatcher->forward($forward);
	}
	/*******************
	 * 定义cache方法
	 * @param string $name
	 * @return object
	 */
	public function cache($name=null){
		static $cache=null;
		if(is_string($name) && $name!=''){
			($cache==null or !isset($cache[$name])) && $cache[$name]=$this->di->getShared($name);
			return $cache[$name];
		}
		return false;
	}
	/*******************
	 * 定义session方法
	 * @param string $name
	 * @return object
	 */
	public function session($name=null,$params=null){
		static $session;
		$session=='' && $session=$this->di->getShared('session');
		if($name=='' || !is_string($name)){return $session;}
		if($params===null){return $session->get($name);}
		return $session->set($name,$params);
	}
	/*******************
	 * 获取di属性方法
	 * @param string $name
	 * @return object
	 */
	public function di($name=null){
		if($name=='' || !is_string($name)){return null;}
		static $di=null;
		($di==null or !isset($di[$name])) and $di[$name]=$this->di->get($name);
		return $di[$name];
	}
	/*******************
	 * 定义DB eventsLog方法
	 * @param string $name
	 * @return object
	 */
	public function log($name=null,&$object=null){
		$config=$this->di->get('config');
		if($name==null && !isset($config->application->debug) && !$config->application->debug){return false;}
		$eventsManager = $this->di->get('eventsManager');
		if($name=='db'){
			$logger = new \Phalcon\Logger\Adapter\File(System::toPath($config->components->logger->path.'.sql').date('Y-m-d').'.log');
			$eventsManager->attach('db', function($event, $connection) use ($logger) {
				$event->getType()=='beforeQuery' && $logger->log($connection->getSQLStatement(),\Phalcon\Logger::INFO);
			});
			$connection=$object->getReadConnection();
			$connection->setEventsManager($eventsManager);
		}
	}
	/*******************
	 * 定义Error方法
	 * @param string $message
	 * @return ***
	 */
	public function error($message){
		exit('___'.$message.'___');
	}
}
