<?php
namespace SU\Common;
/*******************
** 基础控制器入口
** @update time: 2015-02-23
** @author: zhengjunda
** @
**/
class ApiController extends BaseController{
	/*******************
	 * 初始化加载
	 * @
	 */
	public function initialize(){
		$this->loadValidate();
		parent::initalize();
	}
	/*******************
	 * 检查API_SIGN是否合法
	 * @params string api_sign
	 * @return void
	 */
	public function loadValidate(){
		if(!Validate::apiSign($this->get())){
			$this->compileReturn(array(
				'code'=>'10002',
				'desc'=>'api_sign验证失效!'
			));
		}
	}
	/*******************
	 * 返回重编译数据
	 * @params mixed $data 要返回的数据
	 * @return void
	 */
	public function compileReturn($data=null,$type='JSON'){
		if(!is_string($type) || $data==''){return $data;}
		$type=='' && $type='JSON';
		switch(strtoupper($type)){
			case 'EVAL':
				header('Content-Type:text/html;charset=utf-8');
				break;
			case 'JSON':
				header('Content-Type:application/json;charset=utf-8');
				$data=json_encode($data);
				break;
			case 'JSONP':
				header('Content-Type:application/json;charset=utf-8');
				$callback=$this->get('callback');
				$handler= $callback!='' && is_string($callback) ? $callback : 'jsonpReturn';
				$data=$handler.'('.json_encode($data).');';
				break;
		}
		print_r($data);exit;
	}
}
