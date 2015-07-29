<?php
/*******************
** @update time: 2015-02-23
** @author: zhengjunda
** @
**/
class SU{
	/*******************
	* 创建App应用
	* @params 配置文件地址
	*/
	public static function createWebApplication($confPath=''){
		version_compare(PHP_VERSION,'5.3.0','<') && exit('Require PHP > 5.3.0 !');
		!file_exists($confPath) && exit($confPath.' not exists!');
		!defined('__APP_BASESPACE__') && define('__APP_BASESPACE__',__CLASS__);
		!defined('__APP_NAMEDIR__')   && define('__APP_NAMEDIR__','protected');
		!defined('__APP_ACTIONS__')   && define('__APP_ACTIONS__','actions');
		self::initialize($confPath);
	}
	/*******************
	* 项目初始化
	* @
	*/
	private static function initialize($config){
		try{
			$di          = new \Phalcon\DI\FactoryDefault();
			$application = new \Phalcon\Mvc\Application($di);
			#~~~~~~~~~~~~~~
			self::setgetData(true);
			self::setConfig($di,$config);
			self::setSession($di,true);
			self::setCookies($di,true);
			self::setView($di,true);
			self::setSecurity($di,true);
			self::setSystemAlias(true);
			self::setEventsManager($di,true);
			self::setCache($di,@$config->components->cache);
			self::setNamespaces($di,@$config->application->namespace);
			self::setBaseUri($di,@$config->application->baseUri);
			self::setRouter($di,@$config->components->router);
			self::setCrypt($di,@$config->components->crypt);
			self::setVolt($di,@$config->components->volt);
			self::setDataBase($di,@$config->components->database);
			self::setMetadata($di,@$config->components->metadata);
			self::setDispatcher($di,true);
			#~~~~~~~~~~~~~~
			self::setModules($di,$application);
			header('Content-type:text/html;charset=utf-8'); 
			echo $application->handle()->getContent();
		}catch(\Phalcon\Exception $e){self::setErrors($e);}catch(PDOException $e){self::setErrors($e);}
	}
	/*******************
	* 注册错误输出
	* @
	*/
	private static function setErrors($e){echo $e->getMessage();}
	/*******************
	* 重置$_GET数据
	* @
	*/
	private static function setGetData(){
		if(!isset($_GET['_url'])){
			$_GET['_url']=(isset($_GET['m'])?'/'.$_GET['m']:'').(isset($_GET['c'])?'/'.$_GET['c']:'index').(isset($_GET['a'])?'/'.$_GET['a']:'index');
		}
	}
	/*******************
	* 注册配置信息
	* @
	*/
	private static function setConfig(&$di,&$config){
		if(!$config){return;}
		$confArr=include_once($config);
		!isset($confArr['application']['namespace']) && $confArr['application']['namespace']=array('common'=>'application.components','module'=>'application.modules');
		$defaultDirs=array('controllersDir','modelsDir','viewsDir','modulesDir');
		foreach($defaultDirs as &$v){!isset($confArr['application']['nameDirs'][$v]) && $confArr['application']['nameDirs'][$v]=rtrim($v,'Dir');}
		$config = new \Phalcon\Config($confArr);
		$di->set('config',$config);
		$loader = new \Phalcon\Loader();
		$di->set('loader',$loader);
	}
	/*******************
	* 注册系统类别名
	* @
	*/
	private static function setSystemAlias($array=false){
		if(!$array){return;}
		$array=array(
			'CController'=>'\Phalcon\Mvc\Controller',
			'CModel'=>'\Phalcon\Mvc\Model',
		);
		foreach($array as $k=>&$v){eval('class '.$k.' extends '.$v.'{}');}
	}
	/*******************
	* 注册Modules
	* @
	*/
	private static function setModules(&$di,&$application){
		$modules  = @$di->get('config')->modules->toArray();
		if(!$modules){return;}
		foreach($modules as &$v){
			$v=array('className'=>self::toSpace($v['class']),);
		}
		$application->registerModules($modules);
	}
	/*******************
	* 注册命名空间
	* @
	*/
	private static function setNamespaces(&$di,$config){
		if(!$config){return;}
		$namespace=array();
		$nameDirs=$di->get('config')->application->nameDirs;
		!isset($config['controller']) && $config['controller']='application.'.$nameDirs->controllersDir;
		!isset($config['model']) && $config['model']='application.'.$nameDirs->modelsDir;
		foreach($config as $k=>&$v){
			if($k=='module'){continue;}
			$key=self::toSpace($k);
			$namespace[$key]=self::toPath($v);
		}
		#~~~~~~~~~~~~~~~~
		$modules  = @$di->get('config')->modules->toArray();
		if($modules){
			foreach($modules as $k=>&$v){
				if(isset($config[$k]) && isset($config[$k.'.controller'])){continue;}
				$Key=self::toSpace($k);
				isset($v['path']) and $modulePath=self::toPath($v['path']) or $modulePath=self::toPath($config['module'].'.'.$k);
				$namespace[$Key]=$modulePath;
				#~~~~~~~~~~~~~~~~
				$controllerKey=self::toSpace($k.'.controller');
				isset($v['path']) and $controllerPath=self::toPath($v['path']) or $controllerPath=self::toPath($config['module'].'.'.$k.'.'.$nameDirs->controllersDir);
				$namespace[$controllerKey]=$controllerPath;
			}
		}
		#~~~~~~~~~~~~~~~~
		$loader = $di->get('loader');
		$loader->registerNamespaces($namespace);
		$loader->register();
	}
	/*******************
	* 注册basseUri
	* @
	*/
	private static function setBaseUri(&$di,$baseUri){
		!$baseUri && $baseUri='/';
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri($baseUri);
		$di->set('url', $url, true);
	}
	/*******************
	* 注册路由
	* @
	*/
	private static function setRouter(&$di,$router){
		$router=$router->toArray();
		$mvc_router = new \Phalcon\Mvc\Router(true);
		foreach($router as $k=>$v){$mvc_router->add($k, $v);}
		#~~~~~~~~~~~~~~
		$modules=@$di->get('config')->modules->toArray();
		if(!is_array($modules)){return $di->set('router',$mvc_router,true);}
		$arr_keys=array_keys($modules);
		foreach($arr_keys as $module){
			$mvc_router->add('/'.$module.'[/]?', array('module'=>$module,'controller'=>'index','action'=>'index'));
			$mvc_router->add('/'.$module.'/:controller[/]?', array('module'=>$module,'controller'=>1,'action'=>'index'));
			$mvc_router->add('/'.$module.'/:controller/:action[/]?', array('module'=>$module,'controller'=>1,'action'=>2));
		}
		#~~~~~~~~~~~~~~
		$di->set('router',$mvc_router,true);
	}
	/*******************
	* 注册会话Session
	* @
	*/
	private static function setSession(&$di,$session){
		if(!$session){return;}
		$di->set('session', function() {
			$session = new \Phalcon\Session\Adapter\Files();
			!$session->isStarted() && $session->start();
			return $session;
		}, true);
	}
	/*******************
	* 注册会话Cookies
	* @
	*/
	private static function setCookies(&$di,$cookies){
		if(!$cookies){return;}
		$di->set('cookies', function () {
			$cookies = new \Phalcon\Http\Response\Cookies();
			$cookies->useEncryption(false);
			return $cookies;
		}, true);
	}
	/*******************
	* 注册crypt
	* @
	*/
	private static function setCrypt(&$di,$crypt){
		if(!$crypt){return;}
		$di->set('crypt', function() use ($crypt) {
			$crypt = new \Phalcon\Crypt();
			$crypt->setKey($crypt);
			return $crypt;
		});
	}
	/*******************
	* 注册安全组件
	* @
	*/
	private static function setSecurity(&$di,$security){
		if(!$security){return;}
		$di->set('security', function(){
			$security = new \Phalcon\Security();
			$security->setWorkFactor(12);
			return $security;
		}, true);
	}
	/*******************
	* 注册视图模板
	* @
	*/
	private static function setVolt(&$di,$volt){
		if(!$volt){return;}
		$di->set('volt', function($view, $di) use ($volt){
			$view_volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
			$view_volt->setOptions(array(
				'compiledPath'     => self::toPath($volt->path),
				'compiledExtension'=> isset($volt->extension)?$volt->extension:'.php',
				'compiledSeparator'=> isset($volt->separator)?$volt->separator:'_',
				'compileAlways'    => isset($volt->always)?$volt->always:false,
			));
			return $view_volt;
		});
	}
	/*******************
	* 注册数据库链接
	* @
	*/
	private static function setDataBase(&$di,$database){
		if(!$database){return;}
		foreach($database as $k=>$config){
			$di->set($k, function() use ($config){
				$adapter=strtolower($config->adapter);
				$adapter=='pgsql' && $adapter='postgresql';
				$Pdo='Phalcon\Db\Adapter\Pdo\\'.ucfirst($adapter);
				$arg=array(
					"host"    => $config->host,
					"username"=> $config->username,
					"password"=> $config->password,
					"dbname"  => $config->dbname,
				);
				if($adapter=='mysql'){
					$arg['prefix']=$config->prefix;
					$arg['options']=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
				}elseif($adapter=='postgresql'){
					$arg['port']=isset($config->port)?$config->port:5432;
				}
				$connection = new $Pdo($arg);
				return $connection;
			});
		}
	}
	/*******************
	* 注册初始化元数据适配器 使用内存
	* @
	*/
	private static function setMetadata(&$di,$modelsMetadata){
		if(!$modelsMetadata){return;}
		$di->set('metadata', function($di) use ($modelsMetadata) {
			if($modelsMetadata->enable && $modelsMetadata->options){
				$adapter=isset($modelsMetadata->adapter)?ucfirst(strtolower($modelsMetadata->adapter)):'Files';
				$metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'.$adapter;
				$options=$modelsMetadata->options;
				$options->metaDataDir=self::path($di,$options->metaDataDir);
				return new $metadataAdapter($options->toArray());
			 }else{
				return new \Phalcon\Mvc\Model\Metadata\Memory();
			 }
		}, true);
	}
	/*******************
	* 注册事件管理器
	* @
	*/
	private static function setEventsManager(&$di,$isTrue){
		if(!$isTrue){return;}
		$eventsManager = new \Phalcon\Events\Manager();
		$di->set('eventsManager',$eventsManager);
	}
	/*******************
	* 注册视图引擎(app)
	* @	
	*/
	private static function setView(&$di,$isTrue){
		if(!$isTrue){return;}
		$view = new \Phalcon\Mvc\View();
		$view->registerEngines(array('.html' => 'volt'));
		$di->set('view', $view);
	}
	/*******************
	* 注册分发器
	* @
	*/
	private static function setDispatcher(&$di,$isTrue){
		if(!$isTrue){return;}
		$di->set('dispatcher',function() use (&$di){
			$self=__CLASS__;
			$mvc_dispatcher = new \Phalcon\Mvc\Dispatcher();
			$module  = strtolower($di->get('router')->getModuleName());
			$modules = array_keys($di->get('config')->modules->toArray());
			$viewDir = 'application.'.$di->get('config')->application->nameDirs->viewsDir;
			foreach($modules as &$v){strtolower($v);}
			if(in_array($module,$modules)){
				$di->get('view')->setViewsDir($self::toPath($viewDir));
				$mvc_dispatcher->setDefaultNamespace(__APP_BASESPACE__.'\\'.ucfirst($module).'\\Controller');
			}else{
				$di->get('view')->setViewsDir($self::toPath($viewDir));
				$mvc_dispatcher->setDefaultNamespace(__APP_BASESPACE__.'\\Controller');
			}
			#~~~~~~~~~~
			$self::setErrorActions($di,$mvc_dispatcher);
			#~~~~~~~~~~
			return $mvc_dispatcher;
		},true);
	}
	/*******************
	* 注册Actions
	* @
	*/
	final static function setErrorActions(&$di,&$mvc_dispatcher){
        $eventsManager = $di->get('eventsManager');
        $eventsManager->attach("dispatch:beforeException", function($event,$dispatcher,$exception) use ($di){
			$self=__CLASS__;
        	switch ($exception->getCode()){
		         case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
					$self::evalError($di,$exception->getMessage());
					break;
		         case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
					$controller=$dispatcher->getActiveController();
					if(method_exists($controller,__APP_ACTIONS__)){
						$self::setActions($di,$controller,$exception->getMessage());
					}else{$self::evalError($di,$exception->getMessage());}
					break;
			}
			return false;
        });   
        $mvc_dispatcher->setEventsManager($eventsManager); 
	}
	/*******************
	* 扩展Actions事件
	* @
	*/
	final static function setActions(&$di,&$controller,$message){
		$router=$di->get('router');
		$moduleName=strtolower($router->getModuleName());
		$controllerName=strtolower($router->getControllerName());
		$actionName=strtolower($router->getActionName());
		$actionName=='' && $actionName='index';
		$method=__APP_ACTIONS__;
		$methodsAction=array_change_key_case($controller->$method(),CASE_LOWER);//CASE_UPPER
		$self=__CLASS__;
		if(!in_array($actionName,array_keys($methodsAction))){
			$self::evalError($di,$message);
		}else{
			if(!isset($methodsAction[$actionName]['class']) || trim($methodsAction[$actionName]['class'])==''){
				$methodsAction[$actionName]['class']=($moduleName?$moduleName.'.':'').__APP_ACTIONS__.'.'.$actionName.'Action';
			}
			$namespace=array();
			$space=$self::toSpace('action.'.$controllerName);
			#~~~~~~~~~~~~~~~~~~~~~
			$paths=preg_split('/[\.\/]/',$methodsAction[$actionName]['class']);
			$firstName=$paths[0];
			$className=end($paths);unset($paths[count($paths)-1]);
			#~~~~~~~~~~~~~~~~~~~~~
			if($moduleName && $firstName==$moduleName){
				$space=$self::toSpace($moduleName.'.action.'.$controllerName);
				array_unshift($paths,$di->get('config')->application->nameDirs->modulesDir);
			}
			strtolower($paths[0]!='application') && array_unshift($paths,'application');
			#~~~~~~~~~~~~~~~~~~~~~
			$namespace[$space]=$self::toPath(implode('.',$paths));
			$di->get('loader')->registerNamespaces($namespace,true);
			#~~~~~~~~~~~~~~~~~~~~~
			$actionSpace=$space.'\\'.$className;
			new $actionSpace($di->get('router')->getParams(),$controller);
		}
	}
	/*******************
	* 注册Error事件
	* @
	*/
	final static function evalError(&$di,$message=''){
		$errorHandler=@$di->get('config')->components->errorHandler;
		if(!$errorHandler){
			!@$di->get('config')->appliction->debug && exit($exception->getMessage());
			exit('__error__');
		}
		$handlers = explode('/',$errorHandler);
		$forward=array(
			'controller'=>isset($handlers[0])?$handlers[0]:'error',
			'action'=>isset($handlers[1])?$handlers[1]:'index',
		);
		$forward['params'][]=$message;
		$di->get('dispatcher')->forward($forward);
	}
	/*******************
	* 注册缓存
	* @
	*/
	private static function setCache(&$di,$cache){
		if(!$cache){return;}
		foreach($cache as $key=>$config){
			$di->set($key, function() use ($config){
				isset($config->backend->options->cacheDir) && $config->backend->options->cacheDir=self::toPath($config->backend->options->cacheDir);
				$frontAdapter='\Phalcon\Cache\Frontend\\'.ucfirst($config->frontend->adapter);
				$frontCache = new $frontAdapter($config->frontend->options->toArray());
				$backAdapter= '\Phalcon\Cache\Backend\\'.ucfirst($config->backend->adapter);
				return new $backAdapter($frontCache,$config->backend->options->toArray());
			});
		}
	}
	/*******************
	* import class to namespace
	* @
	*/
	public static function toSpace($class=null){
		if(!$class){return;}
		$class=__APP_BASESPACE__.'.'.strtolower($class);
		$arr_class=explode('.',$class);
		foreach($arr_class as &$v){$v=ucfirst($v);}
		$className=implode('\\',$arr_class);
		return $className;
	}
	/*******************
	* import path to realpath
	* @
	*/
	public static function toPath($path=null){
		if(!$path){return;}
		$path = str_replace('application',__APP_NAMEDIR__,$path);
		$path = __DIR__.'/../'.ltrim(str_replace('.','/',$path),'/');
		is_dir($path) AND $path==preg_replace('/\/php/','',$path) AND $path=$path.DIRECTORY_SEPARATOR OR $path==preg_replace('/\/php$/i','.php',$path);
		return $path;
	}
}
$config=__DIR__.'/../config/main.php';
SU::createWebApplication($config);

