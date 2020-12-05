<?php

require_once '../database/database.php';

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	
	// edittext from android
	$username = $_GET['username'];

	$response = Array();

	if($user->fetchUserData($username))
	{
		$response['Data'] = [
			'username' => $user->userRowsFetch['username'],
			'fullname' => $user->userRowsFetch['fullname'],
			'address' => $user->userRowsFetch['address'],
			'phonenumber' => $user->userRowsFetch['phonenumber'],
			'emailaddress' => $user->userRowsFetch['emailaddress'],
			'profileImage' => $user->userRowsFetch['image'],
			'platenumber' => $user->userRowsFetch['plate_number'],
			'topup' => $user->userRowsFetch['top_up'],
			'accountactivated' => $user->userRowsFetch['account_activated'],
			'requirement' => $user->userRowsFetch['fillup']
		];
		array_push($response);
		
	}
	else
	{
		$response["Success"] = 0;
		$response["Message"] = "Failed on Fetching Data";
		
	}
	echo json_encode($response);
}

?>