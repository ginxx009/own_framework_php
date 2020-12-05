<?php

require_once '../database/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// base_64 encoded string from android
	$imageData = $_POST['image'];
	$imageData2 = $_POST['image_nbi'];
	$imageData3 = $_POST['image_license'];
	$imageData4 = $_POST['image_or_cr'];
	// edittext from android
	// $imageName = $_POST['image_name'];
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	$address = $_POST['address'];
	$phonenumber = $_POST['phonenumber'];
	$emailaddress = $_POST['emailaddress'];
	$vehicle_model = $_POST['vehicle_model'];
	$plate_number= $_POST['plate_number'];
	$preferred_date = $_POST['preferred_date'];
	$donefillingup = $_POST['fillup'];
	

	$path = "../images/".uniqid().".jpg";
	$path2 = "../images/".uniqid().".jpg";
	$path3 = "../images/".uniqid().".jpg";
	$path4 = "../images/".uniqid().".jpg";
	
	//change path to the actual path
	//temporary
	$actualPath = "192.168.254.123/delmover/admin/$path";
	$actualPath2 = "192.168.254.123/delmover/admin/$path2";
	$actualPath3 = "192.168.254.123/delmover/admin/$path3";
	$actualPath4 = "192.168.254.123/delmover/admin/$path4";

	var_dump($username);

	if($user->UploadDriversProfile($fullname,$username,$actualPath,$address,$phonenumber,$emailaddress,$actualPath2,$actualPath3,$actualPath4,$vehicle_model,$plate_number,$preferred_date,$donefillingup))
	{
		file_put_contents($path, base64_decode($imageData));
		file_put_contents($path2, base64_decode($imageData2));
		file_put_contents($path3, base64_decode($imageData3));
		file_put_contents($path4, base64_decode($imageData4));
		echo "Success";
	}
	else
	{
		echo "Failed";
	}
}

?>