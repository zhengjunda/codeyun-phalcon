<?php
namespace SU\Controller;
use SU\Common\BaseController;

class ErrorController extends BaseController{
    public function init(){
    	$this->tag->setTitle("App");
    }
    public function indexAction($params=''){
		echo '___INDEX__ERROR___::'.$params;
    }
}



