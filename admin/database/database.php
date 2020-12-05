<?php
session_start();

class dbConnection extends PDO
{
	private $sHost;
	private $sDbname;
	private $sUsername;
	private $sPassword;

	public function __construct()
	{
		$this->setDsn();
		try{
			$setDsn = 'mysql:host='. $this->sHost . ';dbname=' . $this->sDbname . ';';
			$aOptions = array(
				PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
			parent::__construct($setDsn, $this->sUsername, $this->sPassword, $aOptions);
		}
		catch(PDOException $oException)
		{
			echo 'Connection Failed : ' . $oException->getMessage();
		}
	}

	private function setDsn()
	{
		$this->sHost = 'localhost';
		$this->sDbname = 'delmover_db';
		$this->sUsername = 'root';
		$this->sPassword = '';
		// $this->sHost = 'localhost';
		// $this->sDbname = 'id15187527_delmover_db';
		// $this->sUsername = 'id15187527_delmover_db_user';
		// $this->sPassword = 'NF7-#eAe_(dUC&bd';
	}
}

$db_con = new dbConnection();

include_once '../lib/library.php';
$user = new DELLibrary($db_con);

?>