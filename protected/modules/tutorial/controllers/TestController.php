<?php
namespace VE\Tutorial\Controller;
use VE\Common\BackendController;

class TestController extends BackendController{
    public function initialize(){
    	$this->tag->setTitle("后台管理");
       parent::initialize();
    }
    public function indexAction(){
		die('__admin_test__');
    }
}