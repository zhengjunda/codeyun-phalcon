<?php
namespace SU\Common;
/*******************
** 基础ACTION入口
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class ApiAction extends BaseAction{
	/*******************
	 * 初始化加载
	 * @
	 */
	final function initialize($params = NULL){
		$this->loadValidate();
		parent::initialize($params);
	}
}