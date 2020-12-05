<?php
require_once '../database/database.php';

if(isset($_GET['user_id']))
{	
	$id = $_GET['user_id'];
	
	if($user->GetTopUpRequest($id))
	{
		$topUpRequest = $user->getTopUpRequestData;
		$log_message = "Successfully added an amount of ".$topUpRequest['amount']." to your load balance";
		$date_log = date('Y-m-d H:i:s');
		
		if($user->fetchUserDataID($id))
		{
			$getBalance = $user->userRowsFetchID;
			$newAmount = $getBalance['top_up'] + $topUpRequest['amount'];
			
			if($user->AddELoad($id,$newAmount))
			{
				$user->UpdateConfirmation($id,1,$date_log);
				$user->InsertHistoryLog($id,$log_message,$date_log);
				$user->Redirect('../pages/topuprequest.php?successful');
			}
			else
			{
				echo "There was something wrong adding load";
			}
		}
	}
	else
	{
		echo "There was something wrong";
	}
}
?>