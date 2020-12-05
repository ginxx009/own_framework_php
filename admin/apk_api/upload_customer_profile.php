<?php

require_once '../database/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// base_64 encoded string from android
	$profile_image = $_POST['profile_image'];
	// edittext from android
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$emailaddress = $_POST['emailaddress'];
	$address = $_POST['address'];
	$phonenumber = $_POST['phonenumber'];
	$password = $_POST['password'];
	$date_joined = date('Y-m-d H:i:s');
	

	$path = "../images/".uniqid().".jpg";
	
	//change path to the actual path
	//temporary
	$actualPath = "192.168.254.123/delmover/admin/$path";
	

	if($user->CheckUsernameIfExist($username))
	{
		echo "User Exist";
	}
	else
	{
		if($user->Registration($fullname,$username,$password,2))
		{
			if($user->UploadCustomerData($fullname,$username,$emailaddress,$address,$phonenumber,$date_joined,$actualPath))
			{
				file_put_contents($path, base64_decode($profile_image));
				echo "Success";
			}
	else
	{
		echo "Failed";
	}
		}
		else
		{
			echo "Registration Failed";
		}
	}

	
}

?>