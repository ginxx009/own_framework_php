<?php

/**
 * modelAPI
 * Class for admin-related database functionalities.
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class modelAPI extends modelBase
{
    public function fetchUserData($username)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        return $stmt->fetch();
    }

    public function Login($username, $password)
    {
        $stmt = $this->prepare("SELECT * FROM credential WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        $userRow = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $userRow['password'])) {
                $_SESSION['user_session'] = $userRow['username'];
                $_SESSION['user_category'] = $userRow['category'];
                $_SESSION['username'] = $userRow['fullname'];
                if ($_SESSION['user_category'] == 2) {
                    $_SESSION['isLoggedIn'] = false;
                } else {
                    $_SESSION['isLoggedIn'] = true;
                }
                return true;
            } else {
                return false;
            }
        }
    }

    public function CheckUsernameIfExist($username)
    {
        //check first if username does exist
        $checkUser = $this->prepare("SELECT * FROM credential WHERE username=:username");
        $checkUser->execute(array(':username' => $username));
        return $checkUser->fetch();
    }

    public function Registration($fullname, $username, $password, $category)
    {

        //name doesn't exist so proceed to registration
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->prepare("INSERT INTO credential(fullname,username,password,category) VALUES(:fullname, :username, :password, :category)");
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $new_password);
        $stmt->bindParam(":category", $category);
        return $stmt->execute();
    }

    public function UploadDriversProfile($fullname, $username, $image, $address, $phonenumber, $emailaddress, $image_nbi, $image_license, $image_or_cr, $vehicle_model, $plate_number, $training_date, $fillup)
    {
        $stmt = $this->prepare("INSERT INTO user_profile(fullname,username,image,address,phonenumber,emailaddress,image_nbi,image_license,image_or_cr,vehicle_model,plate_number,training_date,fillup) VALUES(:fullname,:username,:image,:address,:phonenumber,:emailaddress,:image_nbi,:image_license,:image_or_cr,:vehicle_model,:plate_number,:training_date,:fillup)");
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
        return $stmt->execute();
    }

    public function Customer_Login($username, $password)
    {
        $stmt = $this->prepare("SELECT * FROM credential WHERE username=:username AND category = 2");
        $stmt->execute(array(':username' => $username));
        $userRow = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $userRow['password'])) {
                $_SESSION['user_session'] = $userRow['username'];
                $_SESSION['user_category'] = $userRow['category'];
                $_SESSION['username'] = $userRow['fullname'];
                return true;
            } else {
                return false;
            }
        }
    }

    public function UploadCustomerData($fullname, $username, $emailaddress, $address, $phonenumber, $date_joined, $profile_image)
    {
        $stmt = $this->prepare("INSERT INTO customer_profile(fullname,username,emailaddress,address,phonenumber,date_joined,profile_image) VALUES(:fullname,:username,:emailaddress,:address,:phonenumber,:date_joined,:profile_image)");
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":emailaddress", $emailaddress);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":phonenumber", $phonenumber);
        $stmt->bindParam(":date_joined", $date_joined);
        $stmt->bindParam(":profile_image", $profile_image);
        return $stmt->execute();
    }
}
