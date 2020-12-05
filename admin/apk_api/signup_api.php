<?php

require_once '../database/database.php';

if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['category']))
{
	if($user->CheckUsernameIfExist($_POST['username']))
	{
		echo "User Exist";
	}
	else
	{
		if($user->Registration($_POST['fullname'],$_POST['username'],$_POST['password'],$_POST['category']))
		{
			echo "Registration Success";
		}
		else
		{
			echo "Registration Failed";
		}
	}
}
else
{
	echo "All field are required";
}
?>