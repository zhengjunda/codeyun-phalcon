<?php
namespace SU\Admin\Controller;
use SU\Common\BackendController as Controller;
class IndexController extends Controller{
	public function actions(){
		$dir_action='admin.actions.index';
		return array(
			'index'=>array(
				'class'=>$dir_action.'.indexAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--01 检查新用户接口
			#~~~~~~~~~~~~~~~~~
			'checkNewUser'=>array(
				'class'=>$dir_action.'.checkNewUserAction',
			),
		);
    }
}