<?php
/**
 * modelAPI
 * API Related
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */

$oModel = new ModelApi;

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


$path = uniqid().".jpg";

//change path to the actual path
//temporary
$actualPath = "/assets/uploaded_images/$path";


if($oModel->CheckUsernameIfExist($username))
{
	echo "User Exist";
}
else
{
	$oModel->Registration($fullname,$username,$password,2);
	if($oModel->UploadCustomerData($fullname,$username,$emailaddress,$address,$phonenumber,$date_joined,$actualPath))
	{
		file_put_contents($path, base64_decode($profile_image));
		echo "Success";
	}
	else
	{
		echo "Failed";
	}
}

?>