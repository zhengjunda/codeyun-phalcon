<?php
namespace VE\Admin\Model;
use VE\Common\BackendModel;
/*******************
** QUERY MODELÈë¿Ú
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class User extends BackendModel{
	public function initialize(){
		$this->setConnectionService('db_test');
	}
    public function getSource(){
        return 've_user';
    }

}
