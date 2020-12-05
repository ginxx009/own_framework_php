<?php

require_once '../database/database.php';

if(isset($_GET['logout']) && $_GET['logout'] == true)
{
	$user->Logout();
	$user->Redirect('../../index.html');
}

?>