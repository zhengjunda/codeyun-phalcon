<?php
namespace SU\Common;
/*******************
** ����ACTION���
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class ApiAction extends BaseAction{
	/*******************
	 * ��ʼ������
	 * @
	 */
	final function initialize($params = NULL){
		$this->loadValidate();
		parent::initialize($params);
	}
}