<?php
namespace VE\Member\Controller;
use VE\Common\BaseController;

class IndexController extends BaseController
{
    public function initialize()
    {
    	$this->tag->setTitle("后台管理");
        parent::initialize();
    }
    
    public function indexAction()
    {
		die('___user___');
    }


}