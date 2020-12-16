<?php
/**
 * modelAPI
 * API Related
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
$oModel = new modelAPI;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// edittext from android
	$username = $_GET['username'];
	$aData = $oModel->fetchUserData($username);

	$response = array();

	if($aData == null)
	{
		$response["Success"] = 0;
		$response["Message"] = "Failed on Fetching Data";
	}
	else
	{
		$response['Data'] = [
			'username' => $aData['username'],
			'fullname' => $aData['fullname'],
			'address' => $aData['address'],
			'phonenumber' => $aData['phonenumber'],
			'emailaddress' => $aData['emailaddress'],
			'profileImage' => $aData['image'],
			'platenumber' => $aData['plate_number'],
			'topup' => $aData['top_up'],
			'accountactivated' => $aData['account_activated'],
			'requirement' => $aData['fillup']
		];
		array_push($response);
	}
	echo json_encode($response);
	
}
