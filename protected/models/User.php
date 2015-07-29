<?php
namespace VE\Model;
use VE\Common\BaseModel;
/*******************
** QUERY MODELÈë¿Ú
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class User extends BaseModel{
	public function initialize(){
		$this->setConnectionService('db_test');
	}
    public function getSource(){
        return 've_user';
    }

}
