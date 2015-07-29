<?php
namespace SU\Controller;
use SU\Common\ApiController;

class DealController extends ApiController{
	public function actions(){
		$dir_action='application.actions.user';
		return array(
			'index'=>array(
				'class'=>$dir_action.'.indexAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--15 邀请有礼
			#~~~~~~~~~~~~~~~~~
			'get_user_url'=>array(
				'class'=>$dir_action.'.getUserUrlAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--16 首页引导接口(加载宝宝信息)
			#~~~~~~~~~~~~~~~~~
			'loadBaby'=>array(
				'class'=>$dir_action.'.loadBabyAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--17 用户呢称及宝宝信息修改
			#~~~~~~~~~~~~~~~~~
			'evalUserBaby'=>array(
				'class'=>$dir_action.'.evalUserBabyAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--18 获取用户及宝宝信息
			#~~~~~~~~~~~~~~~~~
			'userBaby'=>array(
				'class'=>$dir_action.'.userBabyAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--19 个人中心添加宝宝，删除宝宝，更新宝宝
			#~~~~~~~~~~~~~~~~~
			'evalBaby'=>array(
				'class'=>$dir_action.'.evalBabyAction',
			),
		);
	}
}