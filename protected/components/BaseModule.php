<?php
namespace SU\Common;
use SU;
/*******************
** MODULE�����
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class BaseModule{
	/*******************
	 * ��ʼ���Զ�����{ϵͳ���÷���}
	 * @
	 */
	final function registerAutoloaders(){}
	/*******************
	 * ��ʼ��ע�����{ϵͳ���÷���}
	 * @
	 */
	public function registerServices($di){
		$this->id=$di->get('router')->getModuleName();
		$this->di=$di;
		method_exists($this,'init') && $this->init();
	}
	/*******************
	 * �������������������ռ�
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
	 * ��������������MODULE�������ļ�
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