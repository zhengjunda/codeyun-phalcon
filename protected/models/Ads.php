<?php
namespace VE\App\Models;
use VE\Common\BaseModel;
/*******************
** QUERY MODELÈë¿Ú
** @update time: 2015-02-08
** @author: zhengjunda
** @
**/
class Ads extends BaseModel{
	public function initialize(){
		$this->setConnectionService('db');
	}
    public function getSource(){
        return 've_ads';
    }

}
