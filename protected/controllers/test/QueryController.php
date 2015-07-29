<?php
namespace VE\Controller;
use VE\Common\BaseController;
use VE\Models\User;

class QueryController extends BaseController{
    public function initialize(){
    	$this->tag->setTitle("App");
		parent::initialize();
    }
	public function actions(){
		$dir_action='application.actions.user';
		return array(
			'index'=>array(
				'class'=>$dir_action.'.indexAction',
			),
			'manage'=>array(
				'class'=>$dir_action.'.manageAction',
				
			),
			'setting'=>array(
				'class'=>$dir_action.'.settingAction',
				
			),
			'property'=>array(
				'class'=>$dir_action.'.propertyAction',
				
			),
			'edit'=>array(
				'class'=>$dir_action.'.editAction',
				
			),
		);
	}
	public function indexAction(){
		//$session=$this->session();
		//$session->set('name','test');
		//$conditions='id != :id:';
		//$parameters = array('id'=>1);
		//'columns' =>'user_name,id'

		$mysql= new \VE\App\Models\Mysql();

		$data = $mysql::find(array(
			'conditions'=>'id > :id:',
			"bind"  => array('id'=>39),
			'limit' => 1,
			//'columns' =>'user_name,id'
		));

		#~~~~~~~~~~~~~~~~~~~~~~~~~~~
		$save_data=$data->toArray();

		$pgsql= new \VE\App\Models\Pgsql();
		$this->log('db',$pgsql);

		foreach($save_data[0] as $k=>$v){
			$pgsql->$k=$v;
		}
		//$connection=$pgsql->getReadConnection();
		if($pgsql->create()){
			die('_______true______');
		}else{
			die('______false______');
		}



		$data=$user::find(array('limit' => 2,'columns'=>'user_name,id,is_effect'));


		exit;
	
	}

	public function adsAction(){
		
		$ads=new \VE\App\Models\Ads();
$this->log('db',$ads);
		$data=array(
			'appid'=>'vexxx',
			'source'=>'xxxx',
			'idfa'=>'xxxxxxxxxxxx',
			'activate'=>0
		);
		$ads->id='vexxx';
		$ads->appid='vexxx';
		$ads->source='vexxx';
		$ads->idfa='vexxx';
		$ads->activate='1';
		if($ads->create()){
			die('_______true______');
		}else{
			die('______false______');
		}
	}
}