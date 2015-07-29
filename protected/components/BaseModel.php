<?php
namespace SU\Common;
use CModel;
/*******************
** »ù´¡MODELÈë¿Ú
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class BaseModel extends CModel{
	protected function initialize(){
		method_exists($this,'init') && $this->init();
	}
	public function getLastSql(){
		return $this->getReadConnection()->getSQLStatement();
	}

}
