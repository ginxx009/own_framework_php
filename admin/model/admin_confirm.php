<?php
require_once '../database/database.php';

if(isset($_GET['id']))
{
	$id = $_GET['id'];
	$log_message = "Welcome to delmover. Get your first top up now !";
	$date_log = date('Y-m-d H:i:s');
	if($user->ApproveDriver($id,1))
	{
		$user->InsertHistoryLog($id,$log_message,$date_log);
		$user->Redirect('../pages/drivers');
	}
	else
	{
		echo "There was something wrong";
	}
}
?>