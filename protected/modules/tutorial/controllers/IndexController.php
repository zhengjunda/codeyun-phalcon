<?php
namespace VE\Tutorial\Controller;
use VE\Common\BaseController;

class IndexController extends BaseController{
    public function initialize(){
    	$this->tag->setTitle("后台管理");
       parent::initialize();
    }
    public function indexAction(){

		//echo('__admin__index__');
    }

	public function testAction(){
		die('__admin_index_test__');
		
	}
}