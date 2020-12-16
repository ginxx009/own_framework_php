<?php

/**
 * modelAPI
 * API Related
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */

$oModel = new ModelAPI;

$username = $_POST['username'];
$password = $_POST['password'];

$cust_login = $oModel->Customer_Login($username,$password);

if($cust_login)
{
	echo "Login Success";
}
else
{
	echo "Username or Password is Incorrect";
}
?>