<?php
namespace SU\Common;
/*******************
** ϵͳ���ù������
** @update time: 2015-02-18
** @author: zhengjunda
** @
**/
class System{
	/*******************
	 * import object to array
	 * @
	 */
	public static function toArray(&$array=array()){
		$array=(array)$array;
		foreach($array as $k=>$v){
			if(is_object($v)){$array[$k]=self::toArray($v);}
		}
		return $array;
	}

}