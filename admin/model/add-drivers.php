<?php

require_once '../database/database.php';

if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']))
{
	if($user->CheckUsernameIfExist($_POST['username']))
	{
		$user->Redirect('../pages/registration.php');
	}
	else
	{
		if($user->Registration($_POST['fullname'],$_POST['username'],$_POST['password'],0))
		{
			$user->Redirect('../pages/login.php');
			echo "Registration Success";
		}
	}
}
?>