<?php
	class DELLibrary
	{
		private $db;
		public $userRowsFetch;
		public $userRowsFetchID;
		public $fetchCountDriver;
		public $fetchCountLegitDriver;
		public $fetchAllDrivers;
		public $fetchLegitDriver;
		public $showHistoryData;
		public $helperHistoryData;
		public $fetchTopUpRequestData;
		public $getTopUpRequestData;
		public $getAllTopUpData;
		
		function __construct($db_con)
		{
			$this->db = $db_con;
		}

		public function Registration($fullname, $username, $password, $category)
		{
			try
			{
				//name doesn't exist so proceed to registration
				$new_password = password_hash($password, PASSWORD_DEFAULT);
				$stmt = $this->db->prepare("INSERT INTO credential(fullname,username,password,category) VALUES(:fullname, :username, :password, :category)");
				$stmt->bindParam(":fullname", $fullname);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":password", $new_password);
				$stmt->bindParam(":category", $category);
				$stmt->execute();

				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}

		public function Login($username,$password)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM credential WHERE username=:username");
				$stmt->execute(array(':username' => $username));
				$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					if(password_verify($password, $userRow['password']))
					{
						$_SESSION['user_session'] = $userRow['username'];
						$_SESSION['user_category'] = $userRow['category'];
						$_SESSION['username'] = $userRow['fullname'];
						if($_SESSION['user_category'] == 2)
						{
							$_SESSION['isLoggedIn'] = false;
						}
						else
						{
							$_SESSION['isLoggedIn'] = true;
						}
						return true;
					}
					else
					{
						return false;
					}
				}
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}

		public function Logout()
		{
			session_destroy();
			unset($_SESSION['user_session']);
			unset($_SESSION['user_category']);
			unset($_SESSION['username']);
			unset($_SESSION['ExistUsername']);
			$_SESSION['isLoggedIn'] = false;


			return true;
		}

		public function is_LoggedIn()
		{
			if(isset($_SESSION['isLoggedIn']) && $_SESSION['user_category'] != 2)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function Redirect($url)
		{
			header("Location: $url");
		}

		public function CheckUsernameIfExist($username)
		{
			//check first if username does exist
			$checkUser = $this->db->prepare("SELECT * FROM credential WHERE username=:username");
			$checkUser->execute(array(':username' => $username));
			$userRow = $checkUser->fetch(PDO::FETCH_ASSOC);
			if($checkUser->rowCount() > 0)
			{
				$_SESSION['ExistUsername'] = true;
				return true;
			}
			else
			{
				$_SESSION['ExistUsername'] = false;
				return false;
			}
		}

		public function UploadDriversProfile($fullname,$username,$image,$address,$phonenumber,$emailaddress,$image_nbi,$image_license,$image_or_cr,$vehicle_model,$plate_number,$training_date,$fillup)
		{
			try
			{
				$stmt = $this->db->prepare("INSERT INTO user_profile(fullname,username,image,address,phonenumber,emailaddress,image_nbi,image_license,image_or_cr,vehicle_model,plate_number,training_date,fillup) VALUES(:fullname,:username,:image,:address,:phonenumber,:emailaddress,:image_nbi,:image_license,:image_or_cr,:vehicle_model,:plate_number,:training_date,:fillup)");
				$stmt->bindParam(":fullname", $fullname);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":image", $image);
				$stmt->bindParam(":address", $address);
				$stmt->bindParam(":phonenumber", $phonenumber);
				$stmt->bindParam(":emailaddress", $emailaddress);
				$stmt->bindParam(":image_nbi", $image_nbi);
				$stmt->bindParam(":image_license", $image_license);
				$stmt->bindParam(":image_or_cr", $image_or_cr);
				$stmt->bindParam(":vehicle_model", $vehicle_model);
				$stmt->bindParam(":plate_number", $plate_number);
				$stmt->bindParam(":training_date", $training_date);
				$stmt->bindParam(":fillup", $fillup);
				$stmt->execute();

				return $stmt;
			}
			catch(Exception $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//fetch data using username
		public function fetchUserData($username)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE username=:username");
				$stmt->execute(array(':username' => $username));
				$this->userRowsFetch = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//fetch data using ID
		public function fetchUserDataID($user_id)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE id=:user_id");
				$stmt->execute(array(':user_id' => $user_id));
				$this->userRowsFetchID = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		
		//Count how many drivers are applying
		public function CountDriver()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT COUNT(*) AS totaldriver FROM user_profile WHERE account_activated = 0");
				$stmt->execute();
				$values = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->fetchCountDriver = $values['totaldriver'];
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}

		//Get all those drivers that are applying to become driver in delmover
		public function FetchAllDrivers()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE account_activated = 0");
				$stmt->execute();
				$this->fetchAllDrivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Get all those drivers that are confirmed by the admin
		public function FetchLegitDrivers()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE account_activated = 1");
				$stmt->execute();
				$this->fetchLegitDriver = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//This is to count how many drivers delmover have
		public function CountLegitDrivers()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT COUNT(*) AS legitdrivers FROM user_profile WHERE account_activated = 1");
				$stmt->execute();
				$values = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->fetchCountLegitDriver = $values['legitdrivers'];
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for approving the driver to delmover app
		public function ApproveDriver($id, $activated_account)
		{
			try
			{
				$stmt = $this->db->prepare("UPDATE user_profile SET account_activated=:activated_account WHERE id=:id");
				$stmt->bindParam(":activated_account", $activated_account);
				$stmt->bindParam(":id",$id);
				$stmt->execute();
				
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//TBD : Delete or Not ( This is to decline the drivers application )
		public function DeclineDriver($id)
		{
			try
			{
				$stmt = $this->db->prepare("DELETE FROM user_profile WHERE id=:id");
				$stmt->bindParam(":id",$id);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//For user area: Checking if the account is activated
		public function AccountActivated($username)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE username=:username");
				$stmt->bindParam(":username",$username);
				$stmt->execute();
				$stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for inserting history log
		public function InsertHistoryLog($user_id,$log_message,$date_log)
		{
			try
			{
				$stmt = $this->db->prepare("INSERT INTO user_history(user_id,log_message,date_log) VALUES(:user_id,:log_message,:date_log)");
				$stmt->bindParam(":user_id",$user_id);
				$stmt->bindParam(":log_message",$log_message);
				$stmt->bindParam(":date_log",$date_log);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for showing history log of each user
		public function ShowHistoryLog($user_id)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_history WHERE user_id=:user_id");
				$stmt->execute(array(':user_id' => $user_id));
				$this->showHistoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method helper showing historyLog
		public function HistoryLogHelper($username)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM user_profile WHERE username=:username");
				$stmt->execute(array(':username' => $username));
				$this->helperHistoryData = $stmt->fetch(PDO::FETCH_ASSOC);
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Insert method for top up request
		public function TopUpRequest($user_id,$username,$amount,$confirmed,$date_approved)
		{
			try
			{
				$stmt = $this->db->prepare("INSERT INTO topup_request(user_id,username,amount,confirmed,date_approved) VALUES(:user_id,:username,:amount,:confirmed,:date_approved)");
				$stmt->bindParam(":user_id", $user_id);
				$stmt->bindParam(":amount", $amount);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":confirmed", $confirmed);
				$stmt->bindParam(":date_approved",$date_approved);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for fetching up data from top up request 
		public function FetchTopUpRequest()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM topup_request");
				$stmt->execute();
				$this->fetchTopUpRequestData = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $stmt;
				
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for confirming topup request and add topup on user_profile
		public function AddELoad($user_id,$amount)
		{
			try
			{
				$stmt = $this->db->prepare("UPDATE user_profile SET top_up=:amount WHERE id=:user_id");
				$stmt->bindParam(":user_id",$user_id);
				$stmt->bindParam(":amount",$amount);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for updating confirm in topup_request
		public function UpdateConfirmation($user_id,$confirmed,$date_approved)
		{
			try
			{
				$stmt = $this->db->prepare("UPDATE topup_request SET confirmed=:confirmed, date_approved=:date_approved WHERE user_id=:user_id");
				$stmt->bindParam(":user_id",$user_id);
				$stmt->bindParam(":confirmed", $confirmed);
				$stmt->bindParam(":date_approved", $date_approved);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for fetching up data from top up request specific
		public function GetTopUpRequest($user_id)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM topup_request WHERE user_id=:user_id AND confirmed=0");
				$stmt->execute(array(':user_id' => $user_id));
			    $this->getTopUpRequestData = $stmt->fetch(PDO::FETCH_ASSOC);
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//Method for fetching up data from top up request
		public function GetAllTopUpRequest()
		{
			try
			{
				$stmt = $this->db->prepare("SELECT COUNT(*) AS topuprequests FROM topup_request WHERE confirmed = 0");
				$stmt->execute();
				$values = $stmt->fetch(PDO::FETCH_ASSOC);
				$this->getAllTopUpData = $values['topuprequests'];
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		//CUSTOMER Method
		public function UploadCustomerData($fullname,$username,$emailaddress,$address,$phonenumber,$date_joined,$profile_image)
		{
			try
			{
				$stmt = $this->db->prepare("INSERT INTO customer_profile(fullname,username,emailaddress,address,phonenumber,date_joined,profile_image) VALUES(:fullname,:username,:emailaddress,:address,:phonenumber,:date_joined,:profile_image)");
				$stmt->bindParam(":fullname", $fullname);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":emailaddress", $emailaddress);
				$stmt->bindParam(":address", $address);
				$stmt->bindParam(":phonenumber", $phonenumber);
				$stmt->bindParam(":date_joined", $date_joined);
				$stmt->bindParam(":profile_image", $profile_image);
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
		
		public function Customer_Login($username,$password)
		{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM credential WHERE username=:username AND category = 2");
				$stmt->execute(array(':username' => $username));
				$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() > 0)
				{
					if(password_verify($password, $userRow['password']))
					{
						$_SESSION['user_session'] = $userRow['username'];
						$_SESSION['user_category'] = $userRow['category'];
						$_SESSION['username'] = $userRow['fullname'];
						return true;
					}
					else
					{
						return false;
					}
				}
			}
			catch(PDOException $ex)
			{
				echo $ex->getMessage();
			}
		}
	}
?>