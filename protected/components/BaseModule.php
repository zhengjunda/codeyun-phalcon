<?php
namespace SU\Common;
use SU;
/*******************
** MODULE层入口
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class BaseModule{
	/*******************
	 * 初始化自动加载{系统内置方法}
	 * @
	 */
	final function registerAutoloaders(){}
	/*******************
	 * 初始化注册服务{系统内置方法}
	 * @
	 */
	public function registerServices($di){
		$this->id=$di->get('router')->getModuleName();
		$this->di=$di;
		method_exists($this,'init') && $this->init();
	}
	/*******************
	 * 构建方法，加载命名空间
	 * ~~~~~~
	 *	$this->setNamespace(array(
	 *		'admin.model'=>$this->id.'.models',
	 *		'admin.common'=>$this->id.'.components',
	 *		'admin.validate'=>$this->id.'.validators',
	 *	));
	 * ~~~~~~
	 * @
	 */
	public function setNamespace($params=null){
		if(!is_array($params) || count($params)<1){return;}
		$namespace=array();
		foreach($params as $k=>&$v){
			$key=SU::toSpace($k);
			$paths=preg_split('/[\.\/]/',$v);
			strtolower($this->id)==strtolower($paths[0]) and $v='application.'.$this->di->get('config')->application->nameDirs->modulesDir.'.'.$v;
			$value=SU::toPath($v);
			$namespace[$key]=$value;
		}
		$this->di->get('loader')->registerNamespaces($namespace,true);
	}
	/*******************
	 * 构建方法，加载MODULE层配置文件
	 * ~~~~~~
	 *	$this->setConfig(array(
	 *		'path'=>'admin.config.main.php',
	 *		'merge'=>true,
	 *	));
	 * ~~~~~~
	 * @
	 */
	public function setConfig($params=null){
		if(!is_array($params) || count($params)<1){return;}
	
	}
}