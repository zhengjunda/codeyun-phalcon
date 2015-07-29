<?php
namespace SU\Controller;
use SU\Common\BaseController;

class BrandController extends BaseController{
    public function init(){
    	
    }
	public function actions(){
		$dir_action='application.actions.user';
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
			#~~~~~~~~~~~~~~~~~
			#--02 用户注册接口
			#~~~~~~~~~~~~~~~~~
			'signup'=>array(
				'class'=>$dir_action.'.signupAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--03 用户登录接口
			#~~~~~~~~~~~~~~~~~
			'login'=>array(
				'class'=>$dir_action.'.loginAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--04 修改密码接口
			#~~~~~~~~~~~~~~~~~
			'changepwd'=>array(
				'class'=>$dir_action.'.changepwdAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--05 获取用户地址列表接口
			#~~~~~~~~~~~~~~~~~
			'getaddress'=>array(
				'class'=>$dir_action.'.getaddressAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--06 添加地址接口
			#~~~~~~~~~~~~~~~~~
			'address'=>array(
				'class'=>$dir_action.'.addressAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--07 修改地址接口
			#~~~~~~~~~~~~~~~~~
			'editaddress'=>array(
				'class'=>$dir_action.'.editaddressAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--08 删除收货地址
			#~~~~~~~~~~~~~~~~~
			'deladdress'=>array(
				'class'=>$dir_action.'.deladdressAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--09 第三方登陆接口
			#~~~~~~~~~~~~~~~~~
			'huConnection'=>array(
				'class'=>$dir_action.'.huConnectionAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--10 获取身份证
			#~~~~~~~~~~~~~~~~~
			'getIdent'=>array(
				'class'=>$dir_action.'.getIdentAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--11 添加实名认证
			#~~~~~~~~~~~~~~~~~
			'add_Real_Name'=>array(
				'class'=>$dir_action.'.addRealNameAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--12 修改实名认证
			#~~~~~~~~~~~~~~~~~
			'edit_Real_Name'=>array(
				'class'=>$dir_action.'.editRealNameAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--13 修改实名认证
			#~~~~~~~~~~~~~~~~~
			'check_Real_Name'=>array(
				'class'=>$dir_action.'.checkRealNameAction',
			),
			#~~~~~~~~~~~~~~~~~
			#--14 获取地区显示
			#~~~~~~~~~~~~~~~~~
			'get_area'=>array(
				'class'=>$dir_action.'.getAreaAction',
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