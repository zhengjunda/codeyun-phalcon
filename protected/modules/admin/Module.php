<?php
namespace SU\Admin;
use SU\Common\BaseModule;
class Module extends BaseModule{
	public function init(){
		$this->setNamespace(array(
			'admin.model'=>$this->id.'.models',
			'admin.common'=>$this->id.'.components',
			'admin.validate'=>$this->id.'.validators',
		));
	}
}