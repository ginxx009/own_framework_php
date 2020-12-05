<?php

require_once '../database/database.php';

if(isset($_POST['username']) && isset($_POST['password']))
{
	if($user->Customer_Login($_POST['username'],$_POST['password']))
	{
		echo "Login Success";
	}
	else
	{
		echo "Username or Password is Incorrect";
	}
}
else
{
	echo "All field are required";
}
?>