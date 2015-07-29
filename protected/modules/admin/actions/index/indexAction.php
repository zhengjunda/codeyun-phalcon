<?php
namespace SU\Admin\Action\Index;
use SU\Admin\Model;
use SU\Common\BackendAction as Action;

class indexAction extends Action{
    public function run(){die('__admin__indexController__indexAtion__');
		$index_run=$this->cache->get('index_run');
		if($index_run){exit($index_run);}
		$this->addJs='/js/jquery.dialog.js';
		$this->addCss=array('/css/root_index.css','/css/root_menu.css','/css/root_icon.css');
		$cache=array(
			'condition'=>'parent_id=:parent_id',
			'params'   =>array(':parent_id'=>'0'),
			'order'    =>'sort asc',
		);
		$model_category=new Category();
		$db_menu_base=$model_category->db_list($cache);
		#~~~~~~~~~~~~~~~~~~~~~~~~~
		$db_menu_ajax=$model_category->db_menu_ajax();
		#~~~~~~~~~~~~~~~~~~~~~~~~~
		$render=$this->render('index_init',array(
			'db_menu_base' =>$db_menu_base,
			'db_menu_ajax' =>$db_menu_ajax
		),true);
		$this->cache->set('index_run',$render);
		echo $render;
	}
}