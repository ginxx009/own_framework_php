<?php

require_once '../database/database.php';

$getUsername = $_SESSION['username'];


if($user->HistoryLogHelper($getUsername))
  {
	  //get id from user_profile db 
	  $userprofile = $user->helperHistoryData;
  }

if(isset($_POST['submit']))
{
	if($user->fetchUserData($getUsername))
	{
		
		$user_id = $user->userRowsFetch['id'];
		$username = $user->userRowsFetch['username'];
		$amount = $_POST['amount'];
		
		$log_message = "You requested an amount of " . $amount . " to top up. Waiting for approval";
		$date_log = date('Y-m-d H:i:s');
		$user_id = $userprofile['id'];
		$default_date = "0000-00-00 00:00:00";
		
		if($_POST['amount'] = "")
		{
			echo "Invalid Amount Input";
		}
		else
		{
			if($user->TopUpRequest($user_id,$username,$amount,0,$default_date))
			{
				//Insert log history
				$user->InsertHistoryLog($user_id,$log_message,$date_log);
				
				$user->Redirect('../pages/user-topup.php?successful');
				echo "Successfully Requested";
			}
			else
			{
				echo "There's something wrong!";
			} 
		}
	}
}

?>