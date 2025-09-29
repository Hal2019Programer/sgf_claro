<?php
define('PATH_LOGS', $_SERVER['DOCUMENT_ROOT'].'/log');
define('FILE_LOGS', PATH_LOGS.'/log.txt');
class GException extends ErrorException{
	private $msgout;	
	public function __construct($msgout="", $message = "" , $code = 0 , $severity = 1 , $filename = __FILE__ , $lineno = __LINE__){
		$args=func_get_args();
		$this->msgout=array_shift($args);
		call_user_func_array(array($this, 'parent::__construct'), $args);
		//parent::__construct($message, $code);
		//parent::__construct($message, $code , $severity , $filename , $lineno , $previous);
	}
	
	public function getOutMsg(){
		$this->registerLog();
		return $this->msgout;
	}

	public function registerLog(){
		if(!is_dir(PATH_LOGS))
			throw new Exception("No existe la carpeta para registrar los log: ".PATH_LOGS);
		if(!file_exists(FILE_LOGS))
			throw new Exception("No existe el archivo de logs que indico: ".FILE_LOGS);
		if(!is_writeable(FILE_LOGS))
			throw new Exception("No tiene accesso para escribir en el archivo: ".FILE_LOGS);
		$error="archivo: ".$this->getFile()." linea: ".$this->getLine()." [".$this->getMessage()."]\n";
		$fhandle = fopen(FILE_LOGS, "a+");
		fwrite($fhandle, $error);
		fclose($fhandle);
	}
	
}
?>