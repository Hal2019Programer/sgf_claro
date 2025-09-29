<?php
$include_config= array(
	realpath('./config.php'),
	'../api/config.php',
	__DIR__.'/../config.php'
);
foreach ($include_config as $include_path) {
	if (@file_exists($include_path)) {
		require_once($include_path);
		break;
	}
}
class GConector extends MySQLi{
	private $fetch_mode='ASSOC';
	private $status_commit=FALSE;
	public function __construct(){
		parent::connect(OELFCAHOST, OELFCAUSER, OELFCAPASS, OELFCADB);
		$this->set_charset("uft8");
	}
	public function setAutocommit($status_commit=FALSE){
		$this->status_commit=$status_commit;
		$this->autocommit($this->status_commit);
	}
	public function setFechMode($mode){
		$a_mode=array('ASSOC', 'NUM', 'OBJECT');
		if(in_array($mode,$a_mode))
			$this->fetch_mode=$mode;
	}
	
	public function storeResult(){
		/*
			return FALSE si ocurre un error
			return  si ocurre un error
		*/
		
	}
	public function __destroy(){
		if($this->status_commit==FALSE)
			$this->rollback();
		$this->close();
	}
}
?>