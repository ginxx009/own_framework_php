<?php

/**
 * modelAPI
 * API Related
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */

$oModel = new ModelAPI;


$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];
$category = $_POST['category'];

if($oModel->CheckUsernameIfExist($username))
{
	echo "User Exist";
}
else
{
	if($oModel->Registration($fullname,$username,$password,$category))
	{
		echo "Registration Success";
	}
	else
	{
		echo "Registration Failed";
	}
}
?>