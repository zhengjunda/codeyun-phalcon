<?php
namespace VE\App\Models;
use VE\Common\BaseModel;
/*******************
** QUERY MODELÈë¿Ú
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class Pgsql extends BaseModel{
	public function initialize(){
		$this->setConnectionService('db_pgsql');
	}
    public function getSource(){
        return 've_ads';
    }




}
